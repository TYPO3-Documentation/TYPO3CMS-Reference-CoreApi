.. include:: /Includes.rst.txt

.. index:: Extbase; Persistence
.. _extbase-Persistence:

================
Persistence
================

It is possible to define models that are not persisted to database. However in
the most common use cases you want to save your model to the database and load
it from there.

Connecting the model to the database
====================================

The SQL structure for the database needs to be defined in the file
:ref:`EXT:{ext_key}/ext_tables.sql <ext_tables-sql>`. An Extbase model requires that
there is valid TCA for the table that should be used as base for the model.
Therefore you have to create a TCA definition in file
:file:`EXT:{ext_key}/Configuration/TCA/tx_{extkey}_domain_model_{mymodel}.php`.

It is recommended to stick to the following naming scheme for the table:

.. code-block:: none
   :caption: Recommended naming scheme for table names

   tx_{extkey}_domain_model_{mymodel}

   tx_blogexample_domain_model_info

The SQL table for the model can be defined like this:

.. code-block:: sql
   :caption: EXT:blog_example/ext_tables.sql

   CREATE TABLE tx_blogexample_domain_model_info (
      name varchar(255) DEFAULT '' NOT NULL,
      post int(11) DEFAULT '0' NOT NULL
   );

The according TCA definition could look like that:

.. include:: /CodeSnippets/Extbase/Persistence/TCA.rst.txt

Use arbitrary database tables with an Extbase model
---------------------------------------------------

It is possible to use tables that do not convey to the naming scheme mentioned
in the last section. In this case you have to define the connection between
the database table and the file
:ref:`EXT:{ext_key}/Configuration/Extbase/Persistence/Classes.php <extension-configuration-extbase-persistence>`.

In the following example, the table :sql:`fe_users` provided by the system
extension `frontend` is used as persistence table for the model
:php:`Administrator`. Additionally the table :sql:`fe_groups` is used to persist
the model :php:`FrontendUserGroup`.

.. include:: /CodeSnippets/Extbase/Persistence/ExtbasePersistenceClasses.rst.txt

The key :php:`recordType` makes sure that the defined model is only used if the
:ref:`type of the record <t3tca:types>` is set to
:php:`\FriendsOfTYPO3\BlogExample\Domain\Model\Administrator`. This way the
class will only be used for administrators but not plain frontend users.

The array stored in :php:`properties` to match properties to database field
names if the names do not match.
