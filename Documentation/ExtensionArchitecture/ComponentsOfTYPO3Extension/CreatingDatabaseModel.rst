..  include:: /Includes.rst.txt
.. _creating-database-model:

=============================
Creating a new database model
=============================

Create SQL database schema
---------------------------

* Add `example-extension/ext_tables.sql`
* Insert your SQL database schema definition into that file
  * Each entity is represented by one database table
    * Table name has the following structure: `tx_{extension key without underscores}_domain_model_{entity name}`
    * Each entity property is represented by one database column

.. code-block:: sql

    CREATE TABLE tx_exampleextension_domain_model_example (
        title       varchar(255)     DEFAULT ''  NOT NULL,
        description text             DEFAULT '',
        foo_foo     tinyint(1)       DEFAULT '1'
    );

Create TCA configuration
-------------------------

* Add `example-extension/Configuration/TCA/{table name}.php`
  * In the example: `example-extension/Configuration/TCA/tx_exampleextension_domain_model_example.php`
* The TCA defines types, validation and backend-UI-related parameters for each entity property
  * See :ref:`TCA Reference <t3tca:start>` for further information
* Add localization files according to :ref:`Language <t3coreapi:extension-Resources-Private-Language>`
  * `example-extension/Resources/Private/Language/locallang_db.xlf`
  * `example-extension/Resources/Private/Language/de.locallang_db.xlf`
* Add table icon
  * `example-extension/Resources/Public/Icons/{entity name}.svg`
