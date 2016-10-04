.. include:: ../../Includes.txt

.. _database-connection-pool:

ConnectionPool
--------------

TYPO3`s interface to execute queries via `doctrine-dbal` typically starts by asking
the `ConnectionPool` for a `QueryBuilder` or a `Connection` object, handing over the table name to be queried:

.. code-block:: php

    // Get a query builder for a table
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_myext_comments');
    // or
    // Get a connection for a table
    $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_myext_comments');


The `QueryBuilder` is the default workhorse object used by extension authors to express complex queries,
while a `Connection` instance can be used as shortcut to deal with some simple query cases and little written down code.


Pooling
^^^^^^^

TYPO3 can handle multiple connections to different database endpoints at the same time. This
can be configured on a per-table basis in `TYPO3_CONF_VARS`. It allows running tables
on different databases, without an extension developer taking care of that.

The `ConnectionPool` implements this feature: It looks up a configured table-to-database
mapping and can return a `Connection` or a `QueryBuilder` instance for that specific connection.
Those objects internally know which target connection they are dealing with and will
for instance quote field names accordingly.

The transparency of tables to different database endpoints is limited, though:

Executing a table JOIN between two tables that point to different connections will throw an exception.
This restriction may in practice create implicit "groups" of tables that need to point to one connection
at once if an extension or the TYPO3 core joins those tables.

This can turn out as a headache if multiple different extensions use for instance the core category or
collection API with their mm table joins between core internal tables and their extension's counterparts.

That situation is not easy to deal with. At the time of this writing the core development will
eventually implement some non-join fallbacks for typical cases that would be good to decouple, though.

.. note::

   In case joins cannot be decoupled but still affected tables must run on different databases,
   and if the code can not be easily adapted, some DBMS like `PostgreSQL` allow executing those
   queries by having own connection handlers to different other endpoints on its own.