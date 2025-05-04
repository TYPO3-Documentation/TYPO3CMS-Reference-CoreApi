..  include:: /Includes.rst.txt
..  index::
    Database; Result
    QueryBuilder
..  _database-statement:
..  _database-result:

======
Result
======

A :php:`\Doctrine\DBAL\Result` object is returned by
:php:`QueryBuilder->executeQuery()` for :ref:`->select()
<database-query-builder-select>` and :ref:`->count() <database-query-builder-count>`
query types, and by :ref:`Connection->select() <database-connection-select>`
and :ref:`Connection->count() <database-connection-count>` calls.

The object represents a query result set and has methods to fetch single rows
with :ref:`->fetchAssociative() <database-result-fetch-associative>` or to fetch
all rows as an array with :ref:`->fetchAllAssociative()
<database-result-fetch-all-associative>`.

..  warning::
    The return type of single field values is **not** type safe! If you select a
    value from a field that is defined as :sql:`INT`, the :php:`Result` result
    may very well return that value as a PHP :php:`string`. This is also true
    for other database column types like :sql:`FLOAT`, :sql:`DOUBLE` and others.
    This is an issue with the database drivers used underneath. It may happen
    that MySQL returns an integer value for an :sql:`INT` field, while others
    may return a string. In general, the application itself must take care of an
    according type cast to achieve maximum :abbr:`DBMS (Database management
    system)` compatibility.


..  _database-result-fetch-associative:

fetchAssociative()
==================

This method fetched the next row from the result. It is usually used in
:php:`while()` loops. This is the recommended way of accessing the result in
most use cases.

Typical example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection
    // Fetch all records from tt_content on page 42
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $result = $queryBuilder
        ->select('uid', 'bodytext')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq(
                'pid',
                $queryBuilder->createNamedParameter(42, Connection::PARAM_INT)
            )
        )
      ->executeQuery();

    while ($row = $result->fetchAssociative()) {
        // Do something useful with that single $row
    }

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

:php:`->fetchAssociative()` returns an array reflecting one result row with
field/value pairs in one call and retrieves the next row with the next call.
It returns :php:`false` when no more rows can be found.


..  _database-result-fetch-all-associative:

fetchAllAssociative()
=====================

This method returns an array containing all rows of the result set by internally
implementing the same while loop as above. Using that method saves some precious
code characters, but is more memory intensive if the result set is large and
contains many rows and data, since large arrays are carried around in PHP:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    // Fetch all records from tt_content on page 42
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $rows = $queryBuilder
        ->select('uid', 'bodytext')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq(
                'pid',
                $queryBuilder->createNamedParameter(42, Connection::PARAM_INT)
            )
        )
        ->executeQuery()
        ->fetchAllAssociative();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.


..  _database-result-fetch-one:

fetchOne()
==========

The method returns a single column from the next row of a result set, other
columns from this result row are discarded. It is especially handy for
:ref:`QueryBuilder->count() <database-query-builder-count>` queries:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    // Get the number of tt_content records on pid 42 into variable $numberOfRecords
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $numberOfRecords = $queryBuilder
        ->count('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq(
                'pid',
                $queryBuilder->createNamedParameter(42, Connection::PARAM_INT)
            )
        )
        ->executeQuery()
        ->fetchOne();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

..  note::
    The :ref:`Connection->count() <database-connection-count>` implementation
    does exactly that to return the number of rows directly.


..  _database-result-row-count:

rowCount()
==========

This method returns the number of rows affected by the last execution of this
statement. Use this method instead of counting the number of records in a
:ref:`->fetchAssociative() <database-result-fetch-associative>` loop manually.

..  warning::
    :php:`->rowCount()` works well with :sql:`DELETE`, :sql:`UPDATE` and
    :sql:`INSERT` queries. However, it does **not** return a valid number for
    :sql:`SELECT` queries on some :abbr:`DBMSes (Database management systems)`.
    Never use :php:`->rowCount()` on :sql:`SELECT` queries. This may work with
    MySQL, but will fail with other databases like SQLite.


Reuse prepared statement
========================

Doctrine DBAL usually prepares a statement first and then executes it with the
given parameters. The implementation of prepared statements depends on the
particular database driver. A driver that does not implement prepared
statements properly falls back to a direct execution of a given query.

There is an API that allows to make real use of prepared statements. This is
handy when the same query is executed over and over again with different
arguments. The example below prepares a statement for the :sql:`pages` table
and executes it twice with different arguments.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('pages');
    $statement = $queryBuilder
        ->select('uid')
        ->from('pages')
        ->where(
            $queryBuilder->expr()->eq(
                'uid',
                $queryBuilder->createPositionalParameter(0, Connection::PARAM_INT)
            )
        )
        ->prepare();

    $pages = [];
    foreach ([24, 25] as $pageId) {
        // Bind $pageId value to the first (and in this case only) positional parameter
	    $statement->bindValue(1, $pageId, Connection::PARAM_INT);
	    $result = $statement->executeQuery();
        $pages[] = $result->fetchAssociative();
        $result->free(); // free the resources for this result
    }

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

Looking at a MySQL debug log:

..  code-block:: none

    Prepare SELECT `uid` FROM `pages` WHERE `uid` = ?
    Execute SELECT `uid` FROM `pages` WHERE `uid` = '24'
    Execute SELECT `uid` FROM `pages` WHERE `uid` = '25'


The log shows one statement preparation with two executions.
