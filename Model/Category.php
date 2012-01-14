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
class Category extends CategoriesAppModel {

/**
 * Name
 *
 * @var string $name
 */
	public $name = 'Category';

/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Tree' => array('parent' => 'category_id'),
		'Utils.Sluggable' => array('label' => 'name'),
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
			'foreignKey' => 'user_id'
		);
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'name' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'required' => true,
					'allowEmpty' => false,
					'message' => __d('categories', 'Please enter a category name')
				)
			)
		);
	}

/**
 * Adds a new record to the database
 *
 * @param string $userId, user id
 * @param array post data, should be Contoller->data
 * @return boolean
 */
	public function add($userId = null, $data = null) {
		if (!empty($data)) {
			$data[$this->alias]['user_id'] = $userId;
			$this->create($data);
			$result = $this->save($data);
			if ($result !== false) {
				$this->data = array_merge($data, $result);
				return true;
			}

			throw new OutOfBoundsException(__d('categories', 'Could not save the category, please check your inputs.'));
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

		$this->set($category);
		if (empty($data)) {
			return $category;
		}

		$this->set($data);
		$result = $this->save(null, true);
		if ($result) {
			$this->data = $result;
			return true;
		} else {
			return $data;
		}
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
					$this->alias . '.slug' => $slug
				)
			)
		));

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
		$category = $this->find('first', array('conditions' => array(
			"{$this->alias}.{$this->primaryKey}" => $id,
			"{$this->alias}.user_id" => $userId
		)));

		if (empty($category)) {
			throw new OutOfBoundsException(__d('categories', 'Invalid Category'));
		}

		$this->data['category'] = $category;
		if (!empty($data)) {
			$data[$this->alias]['id'] = $id;
			$tmp = $this->validate;
			$this->validate = array(
				'id' => array('rule' => 'notEmpty'),
				'confirm' => array('rule' => '[1]')
			);

			$this->set($data);
			if (!$this->validates()) {
				$this->validate = $tmp;
				throw new Exception(__d('categories', 'You need to confirm to delete this Category'));
			}

			if ($this->delete($data[$this->alias]['id'])) {
				return true;
			}
		}
	}
}
