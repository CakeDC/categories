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
?>
<?php echo $this->Form->create('Category', array('url' => array('action' => 'delete', $category['Category']['id'])));?>
	<fieldset>
 		<legend><?php echo sprintf(__d('categories', 'Delete category "%s"?', true), h($category['Category']['name'])); ?></legend>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->input('confirm', array(
			'type' => 'checkbox'));
	?>
	</fieldset>
<?php echo $this->Form->end(__d('categories', 'Submit', true));?>