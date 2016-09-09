.. include:: ../../Includes.txt

.. _database-api-entry-points:

API main entry points
---------------------

TYPO3`s interface to execute queries via `doctrine-dbal` always starts by asking
the `ConnectionPool` for either a `Connection` or a `QueryBuilder` object, handing
over the table name to be queried:

.. code-block:: php

    // Get a query builder for a table
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_myext_comments');
    // or
    // Get a connection for a table
    $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_myext_comments');


For both methods, `ConnectionPool` looks up which connection is mapped to this table in `TYPO3_CONF_VARS` ...

The main entry point for extension developers to submit queries through a configured
database connection to a table is the connection object ...