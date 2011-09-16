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
 * CakePHP Categories Plugin
 *
 * @package 	categories
 * @subpackage	categories.config.migrations
 */
class Caa9bc72d1cc4476fbccp1e4beba7b4jk extends CakeMigration {
/**
 * Dependency array. Define what minimum version required for other part of db schema
 *
 * Migration defined like 'app.31' or 'plugin.PluginName.12'
 *
 * @var array $dependendOf
 */
	public $dependendOf = array();

/**
 * Migration array
 * 
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'categories' => array(
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
						//'UNIQUE_USER_CATEGORY' => array('column' => array('user_id', 'name'), 'unique' => 1)
					)
				),
				'categorized' => array(
					'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
					'category_id' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36),
					'foreign_key' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36),
					'model' => array('type'=>'string', 'null' => false, 'default' => NULL),
					'record_count' => array('type'=>'integer', 'null' => true, 'default' => 0),
					'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'UNIQUE_CATEGORY_CONTENT' => array('column' => array('category_id', 'foreign_key', 'model'), 'unique' => 1)
					)
				)
			),
		),
		'down' => array(
			'drop_table' => array(
				'categories', 'categorized'),
		)
	);
/**
 * before migration callback
 *
 * @param string $direction, up or down direction of migration process
 */
	public function before($direction) {
		return true;
	}

/**
 * after migration callback
 *
 * @param string $direction, up or down direction of migration process
 */
	public function after($direction) {
		return true;
	}

}
