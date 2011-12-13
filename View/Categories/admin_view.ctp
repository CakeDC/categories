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
<h2><?php  echo __d('categories', 'Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('categories', 'Parent Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($category['ParentCategory']['name'], array('controller'=> 'categories', 'action'=>'view', $category['ParentCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('categories', 'User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($category['User']['id'], array('controller'=> 'users', 'action'=>'view', $category['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('categories', 'Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category[$modelName]['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('categories', 'Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category[$modelName]['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('categories', 'Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category[$modelName]['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('categories', 'Edit Category'), array('action'=>'edit', $category[$modelName]['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('categories', 'Delete Category'), array('action'=>'delete', $category[$modelName]['id']), null, sprintf(__d('categories', 'Are you sure you want to delete # %s?'), $category[$modelName]['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('categories', 'List Categories'), array('action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('categories', 'New Category'), array('action'=>'add')); ?> </li>
	</ul>
</div>
