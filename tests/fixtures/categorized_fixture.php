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

/**
 * Categorized fixture
 *
 * @package 	categories
 * @subpackage	categories.tests.fixtures
 */
class CategorizedFixture extends CakeTestFixture {

/**
 * Name
 *
 * @var string $name
 */
	public $name = 'Categorized';

/**
 * Table
 *
 * @var array $table
 */
	public $table = 'categorized';

/**
 * Fields
 *
 * @var array $fields
 */
	public $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'category_id' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'foreign_key' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'model' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'record_count' => array('type'=>'integer', 'null' => true, 'default' => 0),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'UNIQUE_CATEGORY_CONTENT' => array('column' => array('category_id', 'foreign_key', 'model'), 'unique' => 1)));

/**
 * Records
 *
 * @var array $records
 */
	public $records = array();
}
