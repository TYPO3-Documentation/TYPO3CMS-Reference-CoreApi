:navigation-title: Persistence

..  include:: /Includes.rst.txt
..  index:: Extbase; Persistence
..  _extbase-persistence:

==================================================
Persistence: Saving Extbase models to the database
==================================================

It is possible to define models that are not persisted to the database. However, in
the most common use cases you will want to save your model to the database and load
it from there. If you want to extend an existing model you can also follow the
steps on this page. See also :ref:`Tutorial: Extending an Extbase model
<extending-extbase-model>`.

..  contents:: Table of contents
   :local:

..  _extbase-persistence-database-connection:

Connecting the model to the database
====================================

The SQL structure for the database needs to be defined in the file
:ref:`EXT:{ext_key}/ext_tables.sql <ext_tables-sql>`. An Extbase model requires
a valid TCA for the table that should be used as a base for the model.
Therefore you have to create a TCA definition in file
:file:`EXT:{ext_key}/Configuration/TCA/tx_{extkey}_domain_model_{mymodel}.php`.

It is recommended to stick to the following naming scheme for the table:

..  code-block:: none
    :caption: Recommended naming scheme for table names

    tx_{extkey}_domain_model_{mymodel}

    tx_blogexample_domain_model_info

The SQL table for the model can be defined like this:

..  code-block:: sql
    :caption: EXT:blog_example/ext_tables.sql

    CREATE TABLE tx_blogexample_domain_model_info (
      name varchar(255) DEFAULT '' NOT NULL,
      post int(11) DEFAULT '0' NOT NULL
    );

The according TCA definition could look like that:

..  include:: /CodeSnippets/Extbase/Persistence/TCA.rst.txt

..  _extbase_manual_mapping:

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

..  include:: /CodeSnippets/Extbase/Persistence/ExtbasePersistenceClasses.rst.txt

The key :php:`recordType` makes sure that the defined model is only used if the
:ref:`type of the record <t3tca:types>` is set to
:php:`\FriendsOfTYPO3\BlogExample\Domain\Model\Administrator`. This way the
class will only be used for administrators but not plain frontend users.

The array stored in :php:`properties` to match properties to database field
names if the names do not match.

..  _extbase-persistance-record-types:

Record types and persistence
============================

It is possible to use different models for the same database table.

A common use case are related domain objects that share common features and
should be handled by hierarchical model classes.


In this case the type of the model is stored in a field in the table, commonly
in a field called :sql:`record_type`. This field is then registered as
:php:`type` field in the :php:`ctrl` section of the TCA array:

..  code-block:: php
    :caption: EXT:my_extension/Configuration/TCA/tx_myextension_domain_model_something.php

    return [
        'ctrl' => [
            'title' => 'Something',
            'label' => 'title',
            'type' => 'record_type',
            // …
        ],
    ];

The relationship between record type and preferred model is then configured
in the :file:`Configuration/Extbase/Persistence/Classes.php` file.

..  code-block:: php
    :caption: EXT:my_extension/Configuration/Extbase/Persistence/Classes.php

    return [
        \MyVendor\MyExtension\Domain\Model\Something::class => [
            'tableName' => 'tx_myextension_domain_model_party',
            'recordType' => 'something',
            'subclasses' => [
                'oneSubClass' => \MyVendor\MyExtension\Domain\Model\SubClass1::class,
                'anotherSubClass' => MyVendor\MyExtension\Domain\Model\SubClass2::class,
            ],
        ],
    ];

It is then possible to have a general repository, :php:`SomethingRepository`
which returns both SubClass1 and SubClass2 objects depending on the value of
the :sql:`record_type` field. This way related domain objects can as one
in some contexts.

..  _extbase-persistence-custom-model:

Create a custom model for a Core table
======================================

This example adds a custom model for the :sql:`tt_content` table. Three steps
are required:

..  rst-class:: bignums

#.  Create a model

    In this example, we assume that we need the two fields :sql:`header` and
    :sql:`bodytext`, so only these two fields are available in the
    :ref:`model <extbase-model>` class.

    ..  literalinclude:: _Content.php
        :caption: EXT:my_extension/Classes/Domain/Model/Content.php

    ..  note::
        It is not necessary to define a property in the model for each field in
        the table. Define only the properties for the fields you need!

#.  Create the repository

    We need a :ref:`repository <extbase-repository>` to query the data from the
    table:

    ..  literalinclude:: _ContentRepository.php
        :caption: EXT:my_extension/Classes/Domain/Repository/ContentRepository.php

#.  Connect table with model

    Finally, we need to :ref:`connect the table to the model <extbase_manual_mapping>`:

    ..  literalinclude:: _Classes.php
        :caption: EXT:my_extension/Configuration/Extbase/Persistence/Classes.php

..  _extbase-persistence-events:

Events related to Extbase Persistence
=====================================

Some :ref:`PSR-14 events <EventDispatcher>` are available:

*   :ref:`EntityAddedToPersistenceEvent`
*   :ref:`EntityPersistedEvent`
*   :ref:`EntityRemovedFromPersistenceEvent`
*   :ref:`EntityUpdatedInPersistenceEvent`
*   :ref:`ModifyQueryBeforeFetchingObjectDataEvent`
*   :ref:`ModifyResultAfterFetchingObjectDataEvent`
