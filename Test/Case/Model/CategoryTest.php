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

App::uses('Model', 'Model');

/**
 * Category model test cases
 *
 * @package 	categories
 * @subpackage	categories.tests.cases.models
 */
class CategoryTestCase extends CakeTestCase {

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
	public function setUp() {
		Configure::write('App.UserClass', null); 
		parent::setUp();
		//$this->Category = $this->getMock('Categories.Category');
		$this->Category = ClassRegistry::init('Categories.Category');
		$fixture = new CategoryFixture();
		$this->record = array('Category' => $fixture->records[0]);
	}

/**
 * End Test callback
 *
 * @param string $method
 * @return void
 */
	public function tearDown() {
		//parent::endTest($method);
		unset($this->Category);
		ClassRegistry::flush();
	}

/**
 * Test adding a Category 
 *
 * @return void
 */
	public function testAdd() {
		$userId = 'user-1';
		$data = $this->record;
		unset($data['Category']['id']);
		$result = $this->Category->add($userId, $data);
		$this->assertTrue($result);
		
		try {
			$data = $this->record;
			unset($data['Category']['id']);
			unset($data['Category']['name']);
			$result = $this->Category->add($userId, $data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			//$this->pass('Correct exception thrown');
		}
		
	}

/**
 * Test editing a Category 
 *
 * @return void
 */
	public function testEdit() {
		$userId = 'user-1';
		$result = $this->Category->edit('category-1', $userId, null);

		$expected = $this->Category->read(null, 'category-1');
		$this->assertEqual($result['Category'], $expected['Category']);

		// put invalidated data here
		$data = $this->record;
		$data['Category']['name'] = null;

		$result = $this->Category->edit('category-1', $userId, $data);
		$this->assertEqual($result, $data);

		$data = $this->record;

		$result = $this->Category->edit('category-1', $userId, $data);
		$this->assertTrue(!empty($result));

		$result = $this->Category->read(null, 'category-1');

		// put record specific asserts here for example
		// $this->assertEqual($result['Category']['title'], $data['Category']['title']);

		try {
			$this->Category->edit('wrong_id', $userId, $data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			//$this->pass('Correct exception thrown');
		}
	}

/**
 * Test viewing a single Category 
 *
 * @return void
 */
	public function testView() {
		$result = $this->Category->view('first_category');
		$this->assertTrue(isset($result['Category']));
		$this->assertEqual($result['Category']['id'], 'category-1');

		try {
			$result = $this->Category->view('wrong_id');
			$this->fail('No exception on wrong id');
		} catch (OutOfBoundsException $e) {
			//$this->pass('Correct exception thrown');
		}
	}

/**
 * Test ValidateAndDelete method for a Category 
 *
 * @return void
 */
	public function testValidateAndDelete() {
		$userId = 'user-1';
		try {
			$postData = array();
			$this->Category->validateAndDelete('invalidCategoryId', $userId, $postData);
		} catch (OutOfBoundsException $e) {
			$this->assertEqual($e->getMessage(), 'Invalid Category');
		}
		try {
			$postData = array(
				'Category' => array(
					'confirm' => 0));
			$result = $this->Category->validateAndDelete('category-1', $userId, $postData);
		} catch (Exception $e) {
			$this->assertEqual($e->getMessage(), 'You need to confirm to delete this Category');
		}

		$postData = array(
			'Category' => array(
				'confirm' => 1));
		$result = $this->Category->validateAndDelete('category-1', $userId, $postData);
		$this->assertTrue($result);
	}
}
