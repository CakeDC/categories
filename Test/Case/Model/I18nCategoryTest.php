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
class I18nCategoryTestCase extends CakeTestCase {

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
	public function startTest($method) {
		Configure::write('App.UserClass', null); 
		Configure::write('Config.language', 'eng');
		Configure::write('Config.languages', array('eng', 'deu', 'rus'));
		parent::startTest($method);
		$this->I18nCategory = ClassRegistry::init('Categories.I18nCategory');
		$fixture = new CategoryFixture();
		$this->record = array('I18nCategory' => $fixture->records[0]);
	}

/**
 * End Test callback
 *
 * @param string $method
 * @return void
 */
	public function endTest($method) {
		parent::endTest($method);
		unset($this->I18nCategory);
		ClassRegistry::flush();
	}

/**
 * Test adding a I18nCategory 
 *
 * @return void
 */
	public function testAdd() {
		$userId = 'user-1';
		$data = $this->record;
		unset($data['I18nCategory']['id']);
		$result = $this->I18nCategory->add($userId, $data);
		$this->assertTrue($result);
		
		try {
			$data = $this->record;
			unset($data['I18nCategory']['id']);
			unset($data['I18nCategory']['name']);
			$result = $this->I18nCategory->add($userId, $data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			//$this->pass('Correct exception thrown');
		}
		
	}

/**
 * Test editing a I18nCategory 
 *
 * @return void
 */
	public function testEdit() {
		$userId = 'user-1';
		$result = $this->I18nCategory->edit('category-1', $userId, null);

		$expected = $this->I18nCategory->read(null, 'category-1');
		$this->assertEqual($result['I18nCategory']['name_translation'], array('eng' => 'Company News'));
		unset($result['I18nCategory']['name_translation']);
		$this->assertEqual($result['I18nCategory'], $expected['I18nCategory']);

		// put invalidated data here
		$data = $this->record;
		$data['I18nCategory']['name'] = null;

		$result = $this->I18nCategory->edit('category-1', $userId, $data);
		$this->assertEqual($result, $data);

		$data = $this->record;

		$result = $this->I18nCategory->edit('category-1', $userId, $data);
		$this->assertTrue(!empty($result));

		$result = $this->I18nCategory->read(null, 'category-1');

		try {
			$this->I18nCategory->edit('wrong_id', $userId, $data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			//$this->pass('Correct exception thrown');
		}
	}

	public function testEditMultilanguage() {
		$userId = 'user-1';
		$translations = array(
			'eng' => 'Company News', 
			'fre' => 'French tranlation');
		Configure::write('Config.languages', array('eng', 'fre'));
		$data = $this->record;
		$data['I18nCategory']['name_translation'] = $translations;

		$result = $this->I18nCategory->edit('category-1', $userId, $data);
		$this->assertTrue(!empty($result));

		$category = $this->I18nCategory->edit('category-1', $userId, null);
		$this->assertEqual($category['I18nCategory']['name_translation'], $translations);
	}

/**
 * Test viewing a single I18nCategory 
 *
 * @return void
 */
	public function testView() {
		$result = $this->I18nCategory->view('first_category');
		$this->assertTrue(isset($result['I18nCategory']));
		$this->assertEqual($result['I18nCategory']['id'], 'category-1');

		try {
			$result = $this->I18nCategory->view('wrong_id');
			$this->fail('No exception on wrong id');
		} catch (OutOfBoundsException $e) {
			//$this->pass('Correct exception thrown');
		}
	}

/**
 * Test ValidateAndDelete method for a I18nCategory 
 *
 * @return void
 */
	public function testValidateAndDelete() {
		$userId = 'user-1';
		try {
			$postData = array();
			$this->I18nCategory->validateAndDelete('invalidI18nCategoryId', $userId, $postData);
		} catch (OutOfBoundsException $e) {
			$this->assertEqual($e->getMessage(), 'Invalid Category');
		}
		try {
			$postData = array(
				'I18nCategory' => array(
					'confirm' => 0));
			$result = $this->I18nCategory->validateAndDelete('category-1', $userId, $postData);
		} catch (Exception $e) {
			$this->assertEqual($e->getMessage(), 'You need to confirm to delete this Category');
		}

		$postData = array(
			'I18nCategory' => array(
				'confirm' => 1));
		$result = $this->I18nCategory->validateAndDelete('category-1', $userId, $postData);
		$this->assertTrue($result);
	}
}
