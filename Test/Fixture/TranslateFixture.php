<?php
class TranslateFixture extends CakeTestFixture {

/**
 * name property
 *
 * @var string 'Translate'
 * @access public
 */
	var $name = 'Translate';

/**
 * table property
 *
 * @var string 'i18n'
 * @access public
 */
	var $table = 'i18n';

/**
 * fields property
 *
 * @var array
 * @access public
 */
	var $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'locale' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 3, 'key' => 'index'),
		'model' => array('type'=>'string', 'null' => false, 'default' => NULL, 'key' => 'index', 'length' => 64),
		'foreign_key' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'field' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 64),
		'content' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'I18N_LOCALE_FIELD' => array('column' => array('locale', 'model', 'foreign_key', 'field'), 'unique' => 1),
			'I18N_LOCALE_ROW' => array('column' => array('locale', 'model', 'foreign_key'), 'unique' => 0),
			'I18N_LOCALE_MODEL' => array('column' => array('locale', 'model'), 'unique' => 0),
			'I18N_FIELD' => array('column' => array('model', 'foreign_key', 'field'), 'unique' => 0),
			'I18N_ROW' => array('column' => array('model', 'foreign_key'), 'unique' => 0)), 
	);

/**
 * records property
 *
 * @var array
 * @access public
 */
	var $records = array(
		array(
			'id' => 'i18n-1',
			'locale' => 'eng',
			'model' => 'I18nCategory',
			'foreign_key' => 'category-1',
			'field' => 'name',
			'content' => 'Company News'),
		array(
			'id' => 'i18n-2',
			'locale' => 'eng',
			'model' => 'I18nCategory',
			'foreign_key' => 'category-2',
			'field' => 'name',
			'content' => 'Uncategorized'),
	);
}