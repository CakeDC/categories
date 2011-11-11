# Categories Plugin for CakePHP #

The categories plugin is for allowing users to organize any data into categories.

It provides a basic admin interface to manage both tree and flat style categories.

Any item of data can be added to one or more categories. For this, you can use a hasMany or hasAndBelongsToMany (HABTM) association. The database structure provides a join table called `categorized` for implementation of HABTM associations in case the items belong to several categories.

### Installation ##

1. Place the problems folder into any of your plugin directories for your app (for example app/plugins or cake/plugins)

2. Create database tables using either the schema shell or the [CakeDC Migrations plugin](http://github.com/CakeDC/migrations):
	`cake schema create -plugin categories -name categories`
	or
	`cake migration run all -plugin categories`

3. As this plugin depends on the [CakeDC Utils plugin](http://github.com/CakeDC/utils), you need to get it too and follow it's installation instructions (for this plugin dropping it into the plugins folder will be enough)

4. For the categories administrative section you will need to activate the admin routing prefix in your core.php file located in the config folder of your app. 
	`Configure::write('Routing.prefixes', array('admin'));`

5. Optionally, if the model class representing your users in your application is not called User, you can specify what class should be used by adding this configuration option to any loaded configuration file as bootstrap.php:
	`Configure::write('App.UserClass', 'MyAppUser');`

## Usage ##

Using the categories plugins is as simple as adding a new association to your the models you want to categorize. The following example will categorize the articles having a category_id field on the table:

	class Articles extends AppModel {
		public $belongsTo = array(
			'Category' => array(
				'className' => 'Categories.Category',
				'foreignKey' => 'category_id'
			)
		);
	}

If your application demands multiple categories for each item, you would need to do the binding as follows:

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

For this second case you need to provide a model name for each time you categorize an item. This is a possible method to categorize articles and save the association correctly:

	class Articles extends AppModel {
		...

		public function categorize($articleId, $categoryId) {
			$this->Categorized->save(array(
				'category_id' => $categoryId,
				'foreign_key' => $articleId,
				'model' => $this->alias
			));
		}
	}

### Internationalized categories introduced

	Implemented I18nCategory model that togather with tranlation behavior and i18n plugin allow to implement 
multilanguage categories support.

	For set of tranlated languages in admin interface used language settings from i18n plugin:	
constant DEFAULT_LANGUAGE and configure storage parameter 'Config.languages'.	
	
### The administrative section ###

This plugin provides a very simple administrative section where you can list, create, edit and delete categories for your application. To access this section make sure you have the "admin" routing prefix enable as described in the installation instructions, also this plugin makes use of the Auth Component, to restrict access to this actions.

To access this section just point your browser to  `example.com/admin/categories/categories` changing your host or app install folder accordingly. This page will show you a flat list of created categories.

Going to `example.com/admin/categories/categories/tree` will show you the same list of categories but in a tree structure.

## Requirements ##

* PHP version: PHP 5.2+
* CakePHP version: Cakephp 1.3 Stable
* [CakeDC Utils plugin](http://github.com/CakeDC/utils)

## Support ##

For support and feature request, please visit the [Categories Plugin Support Site](http://cakedc.lighthouseapp.com/projects/59968-categories-plugin/).

For more information about our Professional CakePHP Services please visit the [Cake Development Corporation website](http://cakedc.com).

## License ##

Copyright 2009-2010, [Cake Development Corporation](http://cakedc.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)<br/>
Redistributions of files must retain the above copyright notice.

## Copyright ###

Copyright 2009-2010<br/>
[Cake Development Corporation](http://cakedc.com)<br/>
1785 E. Sahara Avenue, Suite 490-423<br/>
Las Vegas, Nevada 89104<br/>
http://cakedc.com<br/>
