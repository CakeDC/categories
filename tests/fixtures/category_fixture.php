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
 * Category fixture
 *
 * @package 	categories
 * @subpackage	categories.tests.fixtures
 */
class CategoryFixture extends CakeTestFixture {

/**
 * Name
 *
 * @var string $name
 */
	public $name = 'Category';

/**
 * Table
 *
 * @var array $table
 */
	public $table = 'categories';

/**
 * Fields
 *
 * @var array $fields
 */
	public $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'category_id' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'foreign_key' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'model' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'record_count' => array('type'=>'integer', 'null' => true, 'default' => 0),
		'user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index'),
		'lft' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'slug' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'description' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			// 'UNIQUE_USER_CATEGORY' => array('column' => array('user_id', 'name'), 'unique' => 1)
		)
	);

/**
 * Records
 *
 * @var array $records
 */
	public $records = array(
		array(
			'id'  => 'category-1',
			'category_id'  => null,
			'foreign_key' => '',
			'model' => 'Article',
			'user_id'  => 'user-1',
			'lft'  => 1,
			'rght'  => 4,
			'name'  => 'Company News',
			'slug' => 'first_category',
			'description'  => 'News about the company',
			'created'  => '2008-03-25 01:19:46',
			'modified'  => '2008-03-25 01:19:46'
		),
		array(
			'id'  => 'category-2',
			'category_id'  => 'category-1',
			'foreign_key' => '', 
			'model' => 'Article',
			'user_id'  => 'user-1', //phpnut
			'lft'  => 2,
			'rght'  => 3,
			'name'  => 'Uncategorized',
			'slug' => 'uncategorized',
			'description'  => 'Default category',
			'created'  => '2008-03-25 01:19:46',
			'modified'  => '2008-03-25 01:19:46'
		)
	);
}
