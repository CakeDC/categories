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
 * Element displaying a category item in a tree list
 * 
 * @param array $data
 * @param int $depth => $depth ? $depth : count($stack),
 * @param boolean $hasChildren
 * @param int $numberOfDirectChildren
 * @param int $numberOfTotalChildren
 * @param array $firstChild
 * @param array $lastChild
 * @param boolean $hasVisibleChildren
 */
$link = $this->Html->link($data[$modelName]['name'], array('action' => 'edit', $data[$modelName]['id']));
echo '<span id="' . $data[$modelName]['id'] . '">' . $link . '</span>';
?>