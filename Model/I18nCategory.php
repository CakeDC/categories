<?php
/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('CategoriesAppModel', 'Categories.Model');

/**
 * Category model
 *
 * @package categories
 * @subpackage categories.models
 */
 class I18nCategory extends CategoriesAppModel {

/**
 * Name
 *
 * @var string $name
 */
	public $name = 'I18nCategory';

/**
 * alias
 *
 * @var string $name
 */
	public $alias = 'I18nCategory';

/**
 * Name
 *
 * @var string $name
 */
	public $useTable = 'categories';

/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Tree' => array('parent' => 'category_id'),
		'Translate' => array('name'),
	);

/**
 * belongsTo associations
 *
 * @var array $belongsTo
 */
	public $belongsTo = array(
		'ParentCategory' => array('className' => 'Categories.Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array $hasMany
 */
	public $hasMany = array(
		'ChildCategory' => array(
			'className' => 'Categories.Category',
			'foreignKey' => 'category_id',
			'dependent' => false
		)
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Constructor
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		$userClass = Configure::read('App.UserClass');
		if (empty($userClass)) {
			$userClass = 'User';
		}
		$this->belongsTo['User'] = array(
			'className' => $userClass,
			'foreignKey' => 'user_id');
		parent::__construct($id, $table, $ds);
		$this->_setupBehaviors();
		$this->validate = array(
			'name' => array(
				'required' => array('rule' => array('notEmpty'), 'required' => true, 'allowEmpty' => false, 'message' => __d('categories', 'Please enter a category name'))));
	}

/**
 * Adds a new record to the database
 *
 * @param string $userId, user id
 * @param array post data, should be Contoller->data
 * @return array
 */
	public function add($userId = null, $data = null) {
		if (!empty($data)) {
			$data[$this->alias]['user_id'] = $userId;
			$this->create($data);
			$result = $this->save($data);
			if ($result !== false) {
				$this->clearCache();
				$this->data = array_merge($data, $result);
				return true;
			} else {
				throw new OutOfBoundsException(__d('categories', 'Could not save the category, please check your inputs.'));
			}
			return $result;
		}
	}

/**
 * Edits an existing Category.
 *
 * @param string $id, category id
 * @param string $userId, user id
 * @param array $data, controller post data usually $this->data
 * @return mixed True on successfully save else post data as array
 * @throws OutOfBoundsException If the element does not exists
 */
	public function edit($id = null, $userId = null, $data = null) {
		$conditions = array("{$this->alias}.{$this->primaryKey}" => $id);
		if (!empty($userId)) {
			$conditions["{$this->alias}.user_id"] = $userId;
		}
		$category = $this->find('first', array(
			'contain' => array('User', 'ParentCategory'),
			'conditions' => $conditions));

		if (empty($category)) {
			throw new OutOfBoundsException(__d('categories', 'Invalid Category'));
		}

		$category[$this->alias]['name_translation'] = $this->readTranslations($category[$this->alias]['id'], 'name');
		$this->set($category);

		if (!empty($data)) {
			$this->Behaviors->disable('Translate');
			$this->set($data);
			$result = $this->save(null, true);
			if ($result) {
				if (!empty($data[$this->alias]['name_translation'])) {
					$this->saveTranslations($this->id, 'name', $data[$this->alias]['name_translation']);
				}
			}
			$this->Behaviors->enable('Translate');
			if ($result) {
				$this->clearCache();
				$this->data = $result;
				return true;
			} else {
				return $data;
			}
		} else {
			return $category;
		}
	}

	public function saveTranslations($id, $field, $translations) {
		$I18n = ClassRegistry::init('I18nModel');
		$translationsData = $I18n->find('all', array('conditions' => array('model' => $this->alias, 'foreign_key' => $id, 'field' => 'name')));
		$map = array();
		if (!empty($translationsData)) {
			$map = Set::combine($translationsData, '{n}.I18nModel.locale', '{n}.I18nModel');
		}

		foreach ($translations as $locale => $translation) {
			if (isset($map[$locale])) {
				$map[$locale]['content'] = $translation;
				$I18n->create($map[$locale]);
				$I18n->save($map[$locale]);
			} else {
				$data = array(
					'model' => $this->alias,
					'foreign_key' => $id,
					'field' => 'name',
					'content' => $translation,
					'locale' => $locale);
				$I18n->create($data);
				$I18n->save($data);
			}
		}
	}

/**
 * Read translations
 *
 * @param string
 * @param string
 * @return array
 */
	public function readTranslations($id, $field) {
		$I18n = ClassRegistry::init('I18nModel');
		$translations = $I18n->find('all', array('conditions' => array('model' => $this->alias, 'foreign_key' => $id, 'field' => 'name')));
		if (empty($translations)) {
			return array();
		}
		return Set::combine($translations, '{n}.I18nModel.locale', '{n}.I18nModel.content');
	}

/**
 * Returns the record of a Category.
 *
 * @param string $slug, category slug.
 * @return array
 * @throws OutOfBoundsException If the element does not exists
 */
	public function view($slug = null) {
		$category = $this->find('first', array(
			'contain' => array('User', 'ParentCategory'),
			'conditions' => array(
				'or' => array(
				$this->alias . '.id' => $slug,
				$this->alias . '.slug' => $slug))));
		if (empty($category)) {
			throw new OutOfBoundsException(__d('categories', 'Invalid Category'));
		}
		return $category;
	}

/**
 * Validates the deletion
 *
 * @param string $id, category id
 * @param string $userId, user id
 * @param array $data, controller post data usually $this->data
 * @return boolean True on success
 * @throws OutOfBoundsException If the element does not exists
 */
	public function validateAndDelete($id = null, $userId = null, $data = array()) {
		$category = $this->find('first', array(
			'conditions' => array(
				$this->alias . '.' . $this->primaryKey => $id,
				$this->alias . '.user_id' => $userId)));

		if (empty($category)) {
			throw new OutOfBoundsException(__d('categories', 'Invalid Category'));
		}

		$this->data['category'] = $category;
		if (!empty($data)) {
			$data[$this->alias]['id'] = $id;
			$tmp = $this->validate;
			$this->validate = array(
				'id' => array('rule' => 'notEmpty'),
				'confirm' => array('rule' => '[1]'));

			$this->set($data);
			if ($this->validates()) {
				if ($this->delete($data[$this->alias]['id'])) {
					return true;
				}
			}
			$this->validate = $tmp;
			throw new Exception(__d('categories', 'You need to confirm to delete this Category'));
		}
	}

/**
 * Get list of categories from cache based on actual locale
 *
 * @return array, categories in find('list') format
 */
	public function getCacheCategories() {
		$locale = Configure::read('Config.language');
		$categories = Cache::read('category_' . $locale);
		if (empty($categories)) {
			$categories = $this->find('all');
			if (!empty($categories)) {
				$categories = Set::combine($categories, '{n}.' . $this->alias . '.id', '{n}.' . $this->alias . '.name');
			} else {
				$categories = array();
			}
			Cache::write('category_' . $locale, $categories);
		}
		return $categories;
	}

/**
 * Clear categories cache
 *
 */
	public function clearCache() {
		$locales = $this->getSupportedLanguages();
		foreach ($locales as $locale) {
			Cache::delete('category_' . $locale);
		}
	}

/**
 * Return list of languages admin interface and other methods are support
 *
 * @return array list of languages
 */
	public function getSupportedLanguages() {
		$languages = Configure::read('Config.languages');
		if (defined('DEFAULT_LANGUAGE')) {
			$languages[] = DEFAULT_LANGUAGE;
		}
		return $languages;
	}
}
