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

App::import('Model', 'Categories.Categorized');
App::import('Lib', 'Categories.AppTestCase');

/**
 * Categorized model test cases
 *
 * @package 	categories
 * @subpackage	categories.tests.cases.models
 */
class CategoryTestCase extends AppTestCase {

/**
 * Autoload entrypoint for fixtures dependecy solver
 *
 * @var string
 */
	public $plugin = 'categories';

/**
 * Test to run for the test case (e.g array('testFind', 'testView'))
 * If this attribute is not empty only the tests from the list will be executed
 *
 * @var array
 */
	protected $_testsToRun = array();

/**
 * startTest
 *
 * @return void
 */
	public function startTest() {
		$this->Categorized = ClassRegistry::init('Categories.Categorized');
	}

/**
 * endTest
 *
 * @return void
 */
	public function endTest() {
		unset($this->Categorized);
		ClassRegistry::flush();
	}

/**
 * testCategorizedInstance
 *
 * @return void
 */
	public function testCategorizedInstance() {
		$this->assertTrue(is_a($this->Categorized, 'Categorized'));
	}
}
