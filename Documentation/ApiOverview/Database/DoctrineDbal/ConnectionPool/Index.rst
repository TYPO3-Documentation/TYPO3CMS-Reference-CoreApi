..  include:: /Includes.rst.txt

..  _database-connection-pool:

==============
ConnectionPool
==============

TYPO3's interface for executing queries via Doctrine DBAL starts with
a request to the :php-short:`\TYPO3\CMS\Core\Database\ConnectionPool` for a
:php-short:`\TYPO3\CMS\Core\Database\Query\QueryBuilder` or a
:php-short:`\TYPO3\CMS\Core\Database\Connection` object and passing the table name to be queried:

..  literalinclude:: _MyTableRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

The :php:`QueryBuilder` is the default object used by extension
authors to express complex queries, while a :php:`Connection` instance can be
used as a shortcut to handle some simple query cases.

..  _database-connection-pool-pooling:

Pooling: multiple connections to different database endpoints
=============================================================

TYPO3 can handle multiple connections to different database endpoints at the
same time. This can be configured for each individual table in
:php:`$GLOBALS['TYPO3_CONF_VARS']` (see :ref:`database configuration
<database-configuration>` for details). This makes it possible to run tables on
different databases without an extension developer having to worry about it.

The :php-short:`\TYPO3\CMS\Core\Database\ConnectionPool`
implements this feature: It looks for configured
table-to-database mapping and can return a :php:`Connection` or a
:php-short:`\TYPO3\CMS\Core\Database\Query\QueryBuilder` instance
for that specific connection. These objects know
internally which target connection they are dealing with and will quote field
names accordingly, for instance.

..  _database-connection-pool-beware:

Beware
------

However, the transparency of tables for different database endpoints is limited.

Executing a table :sql:`JOIN` between two tables that reference different
connections will result in an exception. This restriction may in practice lead
to implicit "groups" of tables that must to point to a single connection when an
extension or the TYPO3 Core joins these tables.

This can be problematic when several different extensions use, for instance, the
Core category or collection API with their mm table joins between Core internal
tables and their extension counterparts.

That situation is not easy to deal with. At the time of writing the Core
development will implement eventually some non-join fallbacks for typical cases
that would be good to decouple, though.

..  tip::
    In the case joins cannot be decoupled, but still need to run affected tables
    on different databases, and when the code can not be easily adapted, some
    DBMS like PostgreSQL allow these queries to be executed by having their own
    connection handlers to various other endpoints.
