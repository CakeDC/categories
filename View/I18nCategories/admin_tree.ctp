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
<h2><?php echo __d('categories', 'Categories');?></h2>
<?php 
	$this->Html->script(
		array(
			'/categories/js/jquery.treeview',
			'/categories/js/jquery.contextmenu',
			'/categories/js/views/categories/admin_tree'),
		array('inline' => false));
	$this->Html->css(
		array(
			'/categories/css/jquery.treeview',
			'/categories/css/jquery.contextmenu',
			'/categories/css/basic'), 
		null, 
		array('inline' => false));
	$this->Html->scriptBlock('App.pagesAdminIndex.init();');
?>

<div id="category-menu">
	<?php if (empty($categories)) : ?>
	<p class="error-message">
	<?php 
		echo String::insert(
			__d('categories', 'No categories were added yet. :add-a-new-one now!'),
			array('add-a-new-one' => $this->Html->link(__d('categories', 'Add a new one'), array('action' => 'add'))));
	?>
	</p>
	<?php else :
		echo $this->Tree->generate($categories, array('element' => 'categories/tree_item', 'class' => 'categorytree', 'id' => 'categorytree'));
	endif; ?>
	<ul class="actions">
		<li><?php echo $this->Html->link(__d('categories', 'Add category'), array('action' => 'add')); ?></li>
	</ul>
</div>

<div id="placeholder"></div>

<ul id="actions-list" class="contextMenu">
	<li class="view"><?php echo $this->Html->link(__d('categories', 'View'), array('action' => 'view', 'admin' => true)); ?></li>
	<li class="add separator"><?php echo $this->Html->link(__d('categories', 'Add a child'), array('action' => 'add')); ?></li>
	<li class="edit"><?php echo $this->Html->link(__d('categories', 'Edit'), array('action' => 'edit')); ?></li>
	<li class="delete separator"><?php echo $this->Html->link(__d('categories', 'Delete'), array('action' => 'delete')); ?></li>
</ul> 