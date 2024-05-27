.. _creating-database-model:

===================================
Creating a New Database Model
===================================

Create SQL Database Schema
---------------------------

* Add `example-extension/ext_tables.sql`
* Create database schema
  * Each entity is represented by one database table
    * Table name has the following structure: `tx_{extension key without underscores}_domain_model_{entity name}`
    * Each entity property is represented by one database column

.. code-block:: sql

    CREATE TABLE tx_exampleextension_domain_model_example (
        title       varchar(255)     DEFAULT ''  NOT NULL,
        description text             DEFAULT '',
        foo_foo     tinyint(1)       DEFAULT '1'
    );

Create TCA Configuration
-------------------------

* Add `./Configuration/TCA/{table name}.php`
  * In the example: `example-extension/Configuration/TCA/tx_exampleextension_domain_model_example.php`
* The TCA configures types, validation and backend-UI-related stuff for each entity property
  * See `Documentation <https://docs.typo3.org/m/typo3/reference-tca/main/en-us/>`_ for further information
* Add localization files
  * `./Resources/Private/Language/locallang_db.xlf`
  * `./Resources/Private/Language/de.locallang_db.xlf`
* Add table icon
  * `./Resources/Public/Icons/{entity name}.svg`
