Categories Plugin for CakePHP
=============================

The **Categories plugin** is for allowing users to organize any data into categories. It provides a basic admin interface to manage both tree and flat style categories.

Any item of data can be added to one or more categories. For this, you can use a hasMany or hasAndBelongsToMany (HABTM) association. The database structure provides a join table called `categorized` for implementation of HABTM associations in case the items belong to several categories.

Requirements
------------

* CakePHP 2.4+
* PHP 5.2.8+
* [CakeDC Utils plugin](http://github.com/CakeDC/utils)

Documentation
-------------

For documentation, as well as tutorials, see the [Docs](Docs/Home.md) directory of this repository.

Support
-------

For bugs and feature requests, please use the [issues](https://github.com/CakeDC/categories/issues) section of this repository.

Commercial support is also available, [contact us](http://cakedc.com/contact) for more information.

Contributing
------------

This repository follows the [CakeDC Plugin Standard](http://cakedc.com/plugin-standard). If you'd like to contribute new features, enhancements or bug fixes to the plugin, please read our [Contribution Guidelines](http://cakedc.com/contribution-guidelines) for detailed instructions.

License
-------

Copyright 2007-2014 Cake Development Corporation (CakeDC). All rights reserved.

Licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.