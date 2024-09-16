:navigation-title: Database
..  include:: /Includes.rst.txt
..  index:: ! Database
..  _database:

========================
Database (Doctrine DBAL)
========================

This chapter describes accessing the database on the level of the Doctrine
Database Abstraction Layer (DBAL).

The `Doctrine Database Abstraction Layer (DBAL) <https://www.doctrine-project.org/projects/dbal.html>`__ in TYPO3 provides developers
with a powerful and flexible way to interact with databases, allowing them to
perform database operations through an object-oriented API while ensuring
compatibility across different database systems.

Within the TYPO3 backend rows of database tables are usually represented as
:ref:`database-records` and configured in :ref:`database-records-tca`.

In Extbase based extensions tables are abstracted as
:ref:`Extbase models <extbase-model>`. Operations such as creating, updating and
deleting database records are usually performed from within a
:ref:`Extbase repository <extbase-repository>` with methods provided by Extbase
classes. However, Doctrine DBAL can also be used by extensions that use, for
example an :ref:`Extbase controller <extbase-controller>`.

..  toctree::
    :caption: Contents
    :titlesonly:

    Introduction/Index
    Configuration/Index
    DatabaseStructure/Index
    DatabaseUpgrade/Index
    BasicCrud/Index
    ClassOverview/Index
    ConnectionPool/Index
    QueryBuilder/Index
    Connection/Index
    ExpressionBuilder/Index
    RestrictionBuilder/Index
    Statement/Index
    Middleware/Index
    TipsAndTricks/Index
    Troubleshooting/Index
