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
 * Categorized model test cases
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