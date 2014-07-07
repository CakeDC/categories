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

App::uses('Model', 'Categories.I18nCategory'); 
App::uses('CategoriesAppController', 'Categories.Controller');

/**
 * Categories controller
 *
 * @package categories
 * @subpackage categories.controllers
 */
class I18nCategoriesController extends CategoriesAppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'I18nCategories';

/**
 * Models
 *
 * @var array
 */
	public $uses = array(
		'Categories.I18nCategory'
	);

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array(
		'Html',
		'Form',
		'Utils.Tree'
	);

/**
 * beforeFilter callback
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Category = $this->I18nCategory;
		$this->Auth->allow('view', 'index');
		$this->set('modelName', $this->modelClass);
	}

/**
 * Index for category.
 * 
 */
	public function index() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}

/**
 * View for category.
 *
 * @param string $slug, category slug 
 */
	public function view($slug = null) {
		try {
			$category = $this->Category->view($slug);
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('category')); 
	}

/**
 * Admin index for category.
 * 
 */
	public function admin_index() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate()); 
	}

/**
 * Admin index
 *
 */
	public function admin_tree() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->Category->find('all', array('order' => $this->Category->alias . '.lft')));
	}

/**
 * Admin view for category.
 *
 * @param string $slug, category slug 
 */
	public function admin_view($slug = null) {
		try {
			$category = $this->Category->view($slug);
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('category'));
	}

/**
 * Admin add for category.
 * 
 */
	public function admin_add($categoryId = null) {
		try {
			$result = $this->Category->add($this->Auth->user('id'), $this->request->data);
			if ($result === true) {
				$this->Session->setFlash(__d('categories', 'The category has been saved'));
				$this->redirect(array('action' => 'index'));
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data) && !empty($categoryId)) {
			$this->request->data[$this->Category->alias]['category_id'] = $categoryId;
		}
		$categories = $this->Category->find('list');
		$users = $this->Category->User->find('list');
		$this->set(compact('categories', 'users'));
	}

/**
 * Admin edit for category.
 *
 * @param string $id, category id 
 */
	public function admin_edit($id = null) {
		try {
			$actualLanguages = $this->Category->getSupportedLanguages();
			App::uses('Languages', 'Utils.Lib');
			$Languages = new Languages();
			$languages = $Languages->lists('locale');
			$this->set(compact('languages', 'actualLanguages'));
			$result = $this->Category->edit($id, null, $this->request->data);
			if ($result === true) {
				$this->Session->setFlash(__d('categories', 'Category saved'));
				$this->redirect(array('action' => 'view', $this->Category->data[$this->Category->alias]['slug']));
			} else {
				$this->request->data = $result;
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		$categories = $this->Category->find('list');
		$users = $this->Category->User->find('list');
		$this->set(compact('categories', 'users'));
	}

/**
 * Admin delete for category.
 *
 * @param string $id, category id 
 */
	public function admin_delete($id = null) {
		try {
			$result = $this->Category->validateAndDelete($id, $this->Auth->user('id'), $this->request->data);
			if ($result === true) {
				$this->Session->setFlash(__d('categories', 'Category deleted'));
				$this->redirect(array('action' => 'index'));
			}
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->Category->data['category'])) {
			$this->set('category', $this->Category->data['category']);
		}
	}
}
