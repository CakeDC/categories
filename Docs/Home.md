Home
====

The **Categories plugin** is for allowing users to organize any data into categories. It provides a basic admin interface to manage both tree and flat style categories.

Any item of data can be added to one or more categories. For this, you can use a hasMany or hasAndBelongsToMany (HABTM) association. The database structure provides a join table called `categorized` for implementation of HABTM associations in case the items belong to several categories.

Requirements
------------

* CakePHP 2.4+
* PHP 5.2.8+
* [CakeDC Utils plugin](http://github.com/CakeDC/utils)

Documentation
-------------

* [Installation](Documentation/Installation.md)
* [Usage](Documentation/Usage.md)
