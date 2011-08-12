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

App::import('Controller', 'Categories.Categories');

App::uses('Controller', 'Controller');
App::uses('Router', 'Routing');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');

/**
 * TestCategoriesController
 *
 * @package Categories
 * @subpackage Categories.tests.cases.controllers
 */
class TestCategoriesController extends CategoriesController {

/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect URL
 *
 * @var mixed
 */
	public $redirectUrl = null;

/**
 * Rendered view
 *
 * @var string
 */
	public $renderedView = null;
 
/**
 * Override controller method for testing
 * @todo find way to not rewrite code here
 *
 */
	public function redirect($url, $status = null, $exit = true) {
		if (!empty($this->request->params['isAjax'])) {
			return $this->setAction('short_list', $this->Favorite->model);
		} else if (isset($this->viewVars['status']) && isset($this->viewVars['message'])) {
			$this->Session->setFlash($this->viewVars['message'], 'default', array(), $this->viewVars['status']);
			$this->redirectUrl = $url;
		}
	}

/**
 * Override controller method for testing
 *
 * @param string $action 
 * @param string $layout 
 * @param string $file 
 * @return void
 */
	public function render($action = null, $layout = null, $file = null) {
		$this->renderedView = $action;
	} 
}


/**
 * Categories controller test cases
 *
 * @package 	categories
 * @subpackage	categories.tests.cases.controlles
 */
class CategoriesControllerTestCase extends CakeTestCase {

/**
 * Autoload entrypoint for fixtures dependecy solver
 *
 * @var string
 */
	public $plugin = 'categories';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.article',
		'plugin.categories.categorized',
		'plugin.categories.category',
		'plugin.categories.translate',
		'plugin.categories.user');

/**
 * Start Test callback
 *
 * @param string $method
 * @return void
 */
	public function startTest() {
		$this->Categories = new TestCategoriesController(new CakeRequest());
		$this->Categories->constructClasses();

		$this->Collection = $this->getMock('ComponentCollection');
		if (!class_exists('MockAuthComponent2')) {
			$this->getMock('AuthComponent', array('user'), array($this->Collection), 'MockAuthComponent2');
		}

		$this->AuthComponent = new MockAuthComponent2($this->Collection);
		$this->AuthComponent->enabled = true;
		$this->Categories->Auth = $this->AuthComponent;
		
		
		$this->Categories->request->params = array(
			'named' => array(),
			'pass' => array(),
			'url' => array());
		$fixture = new CategoryFixture();
		$this->record = array('Category' => $fixture->records[0]);
	}

/**
 * End Test callback
 *
 * @param string $method
 * @return void
 */
	public function endTest() {
		unset($this->Categories);
		ClassRegistry::flush();
	}

/**
 * Convenience method to assert Flash messages
 *
 * @return void
 */
	public function assertFlash($message) {
		$flash = $this->Categories->Session->read('Message.flash');
		$this->assertEqual($flash['message'], $message);
		$this->Categories->Session->delete('Message.flash');
	}

/**
 * Test object instances
 *
 * @return void
 */
	public function testInstance() {
		$this->assertInstanceOf('CategoriesController', $this->Categories);
		$this->assertInstanceOf('Category', $this->Categories->Category);
	}


/**
 * testIndex
 *
 * @return void
 */
	public function testIndex() {
		//$this->Categories->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Categories->Auth
			->expects($this->any())
			->method('user')
			->will($this->returnValue('user-1'));
		$this->Categories->index();
		$this->assertTrue(!empty($this->Categories->viewVars['categories']));
	}

/**
 * testView
 *
 * @return void
 */
	public function testView() {
		//$this->Categories->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Categories->Auth
			->expects($this->any())
			->method('user')
			->will($this->returnValue('user-1'));
		$this->Categories->view('first_category');
		$this->assertTrue(!empty($this->Categories->viewVars['category']));

		$this->Categories->view('WRONG-ID');
		//$this->Categories->expectRedirect(array('action' => 'index'));
		$this->assertFlash('Invalid Category');
		//$this->Categories->expectExactRedirectCount();
	}

/**
 * testAdminIndex
 *
 * @return void
 */
	public function testAdminIndex() {
		//$this->Categories->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Categories->Auth
			->expects($this->any())
			->method('user')
			->will($this->returnValue('user-1'));
		$this->Categories->admin_index();
		$this->assertTrue(!empty($this->Categories->viewVars['categories']));
	}

/**
 * testAdminAdd
 *
 * @return void
 */
	public function testAdminAdd() {
		//$this->Categories->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Categories->request->data = $this->record;
		unset($this->Categories->request->data['Category']['id']);
		$this->Categories->admin_add();
		//$this->Categories->expectRedirect(array('action' => 'index'));
		$this->assertFlash('The category has been saved');
		//$this->Categories->expectExactRedirectCount();
	}

/**
 * testAdminEdit
 *
 * @return void
 */
	public function testAdminEdit() {
		//$this->Categories->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Categories->Auth
			->expects($this->any())
			->method('user')
			->will($this->returnValue('user-1'));
		$this->Categories->admin_edit('category-1');
		$this->assertEqual($this->Categories->request->data['Category'], $this->record['Category']);

		$this->Categories->request->data = $this->record;
		$this->Categories->admin_edit('category-1');
		//$this->Categories->expectRedirect(array('action' => 'view', 'slug1'));
		$this->assertFlash('Category saved');
		//$this->Categories->expectExactRedirectCount();
	}

/**
 * testAdminView
 *
 * @return void
 */
	public function testAdminView() {
		//$this->Categories->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Categories->admin_view('first_category');
		$this->assertTrue(!empty($this->Categories->viewVars['category']));

		$this->Categories->admin_view('WRONG-ID');
		//$this->Categories->expectRedirect(array('action' => 'index'));
		$this->assertFlash('Invalid Category');
		//$this->Categories->expectExactRedirectCount();
	}

/**
 * testAdminDelete
 *
 * @return void
 */
	public function testAdminDelete() {
		//$this->Categories->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Categories->Auth
			->expects($this->any())
			->method('user')
			->will($this->returnValue('user-1'));
		$this->Categories->admin_delete('WRONG-ID');
		//$this->Categories->expectRedirect(array('action' => 'index')); //@todo what todo with redirects
		$this->assertFlash('Invalid Category');

		$this->Categories->admin_delete('category-1');
		$this->assertTrue(!empty($this->Categories->viewVars['category']));

		$this->Categories->request->data = array('Category' => array('confirmed' => 1));
		$this->Categories->admin_delete('category-1');
		//$this->Categories->expectRedirect(array('action' => 'index'));
		$this->assertFlash('Category deleted');
		//$this->Categories->expectExactRedirectCount();
	}
}
