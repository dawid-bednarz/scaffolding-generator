scaffolding-generator
=====================

very useful genearator CRUD – Create Update Delete.

Install
=====================
~~~ go
„require”: {

   "dawid-daweb/scaffolding-generator": "dev-master"
}
~~~

Use
=====================

**\<vendor_path>/dawid-daweb/scaffolding-generator/crud.php  \<command>/\<param>**

Allowed Commands
=====================

* **create/\<name_table>** - create scaffolding
* **back** - delete last created crud file
* **change/config** - change config file 
* **help** – show allowed commands

How it works?
=====================

Module retrieves info on the table columns based on  collected info are created class with query(selct, insert, delete, update) in PDO handle PDO is always put to constructor class, check [default generated CRUD file](https://github.com/dawid-daweb/scaffolding-generator/example/User.php)  . You can change template generated file.

Create CRUD
=====================

it simple only  nedd to use command

**\<vendor_path>/dawid-daweb/scaffolding-generator/crud.php  create/\<name_table>**

- replace  „\<name_table>” to real name

Change generated template CRUD
=====================

when you need change template you must create template class instanceof daweb\crud\scaffoldingTemplate and pass name your new template with namespaces to config file.

Change config
=====================

**\<vendor_path>/dawid-daweb/scaffolding-generator/crud.php  change/config**

- this command will return path to config file edit him in your favorite file editor

Delete last created CRUD file 
=====================

**\<vendor_path>/dawid-daweb/scaffolding-generator/crud.php  back**
