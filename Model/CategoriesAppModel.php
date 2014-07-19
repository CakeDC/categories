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

App::uses('AppModel', 'Model');

/**
 * Categories AppModel
 *
 * @package Categories
 * @subpackage Categories.Model
 */
class CategoriesAppModel extends AppModel {

/**
 * Setup available plugins
 *
 * This checks for the existence of certain plugins, and if available, uses them.
 *
 * @return void
 * @link https://github.com/CakeDC/utils
 */
	protected function _setupBehaviors() {
		if (CakePlugin::loaded('Utils') && class_exists('SluggableBehavior') && !$this->Behaviors->loaded('Sluggable')) {
			$this->Behaviors->load('Utils.Sluggable', array_merge(array(
				'label' => 'name'
				), (array)Configure::read('Category.sluggable')
			));
		}
	}
}