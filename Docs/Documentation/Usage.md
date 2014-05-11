Usage
=====

Using the categories plugins is as simple as adding a new association to your the models you want to categorize. The following example will categorize the articles having a category_id field on the table:

```php
class Articles extends AppModel {
	public $belongsTo = array(
		'Category' => array(
			'className' => 'Categories.Category',
			'foreignKey' => 'category_id'
		)
	);
}
```

If your application demands multiple categories for each item, you would need to do the binding as follows:

```php
class Articles extends AppModel {
	public $hasAndBelongsToMany = array(
		'Category' => array(
			'className' => 'Categories.Category',
			'foreignKey' => 'foreign_key',
			'associationForeignKey' => 'category_id',
			'with' => 'Categories.Categorized'
		)
	);
}
```

For this second case you need to provide a model name for each time you categorize an item. This is a possible method to categorize articles and save the association correctly:

```php
class Articles extends AppModel {
	public function categorize($articleId, $categoryId) {
		$this->Categorized->save(array(
			'category_id' => $categoryId,
			'foreign_key' => $articleId,
			'model' => $this->alias
		));
	}
}
```

Internationalized categories introduced
---------------------------------------

Implemented I18nCategory model that togather with tranlation behavior and i18n plugin allow to implement multilanguage categories support.

For set of tranlated languages in admin interface used language settings from i18n plugin: constant DEFAULT_LANGUAGE and configure storage parameter 'Config.languages'.

The administrative section
--------------------------

This plugin provides a very simple administrative section where you can list, create, edit and delete categories for your application. To access this section make sure you have the "admin" routing prefix enable as described in the installation instructions, also this plugin makes use of the Auth Component, to restrict access to this actions.

To access this section just point your browser to  `example.com/admin/categories/categories` changing your host or app install folder accordingly. This page will show you a flat list of created categories.

Going to `example.com/admin/categories/categories/tree` will show you the same list of categories but in a tree structure.
