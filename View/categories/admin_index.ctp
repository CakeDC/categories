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
<h2><?php __d('categories', 'Categories');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __d('categories', 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('category_id');?></th>
	<th><?php echo $this->Paginator->sort('user_id');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('description');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th class="actions"><?php __d('categories', 'Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($categories as $category):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($category['ParentCategory']['name'], array('controller'=> 'categories', 'action'=>'view', $category['ParentCategory']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($category['User']['id'], array('controller'=> 'users', 'action'=>'view', $category['User']['id'])); ?>
		</td>
		<td>
			<?php echo $category['Category']['name']; ?>
		</td>
		<td>
			<?php echo $category['Category']['description']; ?>
		</td>
		<td>
			<?php echo $category['Category']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__d('categories', 'View', true), array('action'=>'view', $category['Category']['id'])); ?>
			<?php echo $this->Html->link(__d('categories', 'Edit', true), array('action'=>'edit', $category['Category']['id'])); ?>
			<?php echo $this->Html->link(__d('categories', 'Delete', true), array('action'=>'delete', $category['Category']['id']), null, sprintf(__d('categories', 'Are you sure you want to delete # %s?', true), $category['Category']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->element('paging');?>
