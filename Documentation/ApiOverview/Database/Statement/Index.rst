.. include:: /Includes.rst.txt
.. index::
   Database; Statement
   QueryBuilder
.. _database-statement:

=========
Statement
=========

A `Statement` object is returned by :php:`QueryBuilder->execute()` for :php:`->select()` and :php:`->count()`
query types and by :php:`Connection->select()` and :php:`Connection->count()` calls.

.. todo: remove this note after requirement to doctrine/dbal 3, probably TYPO3 v12

.. note::

   The functions :php:`->fetch()`, :php:`->fetchAll()` and :php:`fetchColumn()` were
   `deprecated in doctrine/dbal 2.13 <https://www.doctrine-project.org/2021/03/29/dbal-2.13.html>`__
   and will be removed in DBAL3. It is recommended to use
   :php:`->fetchAssociative()`, :php:`->fetchAllAssociative()` or
   :php:`fetchOne()` respectively.


The object represents a query result set and comes with methods to fetch single rows
with :php:`->fetch()` or to fetch all rows with :php:`->fetchAllAssociative()`.
Additionally, it can also be used to execute a single prepared
statement with different values multiple times. This part is however not widely used within
the TYPO3 Core yet, and thus not fully documented here.

.. note::

   The name "Statement" instead of "Result" can be puzzling at first glance: The class
   represents a *prepared statement* that can be executed multiple times with different
   values and then returns multiple different result sets. From this point of view
   "Statement" fits much better than "Result".


.. warning::

   The return type of single field values is NOT type safe! If selecting a value from a field that is
   defined as `int`, the `Statement` result may very well return that as `PHP` :php:`string`. This is
   true for other database column types like `FLOAT`, `DOUBLE` and others.
   This is an issue with the database drivers used below, it may happen that `MySQL` returns an integer
   value for an `int` field, while `MSSQL` returns a string.
   In general, the application must take care of an according type cast on their own to reach maximum
   `DBMS` compatibility.


fetchAssociative()
==================

Fetch next row from the result. Usually used in :php:`while()` loops.
This is the recommended way of accessing the result in most use cases.

Typical example:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // Fetch all records from tt_content on page 42
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $statement = $queryBuilder
      ->select('uid', 'bodytext')
      ->from('tt_content')
      ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT)))
      ->execute();
   while ($row = $statement->fetchAssociative()) {
      // Do something useful with that single $row
   }


:php:`->fetchAssociative()` returns arrays with single field / values pairs until the end of the result set is reached
which then returns false and thus breaks the while loop.


fetchAllAssociative()
=====================

Returns an array containing all of the result set rows by implementing the same while loop as above internally.
Using that method saves some precious code characters but is more memory intensive if the result set is large
with lots of rows and lot of data since big arrays are carried around in PHP:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // Fetch all records from tt_content on page 42
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $rows = $queryBuilder
      ->select('uid', 'bodytext')
      ->from('tt_content')
      ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT)))
      ->execute()
      ->fetchAllAssociative();


fetchOne()
==========

Returns a single column from the next row of a result set, other columns from that result row are discarded.
This method is especially handy for :php:`QueryBuilder->count()` queries.

The :php:`Connection->count()` implementation does exactly that to return the
number of rows directly:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // Get the number of tt_content records on pid 42 into variable $numberOfRecords
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $numberOfRecords = $queryBuilder
      ->count('uid')
      ->from('tt_content')
      ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT)))
      ->execute()
      ->fetchOne();


rowCount()
==========

Returns the number of rows affected by the last execution of this statement. Use that method
instead of counting the number of records in a :php:`->fetchAssociative()` loop manually.

.. warning::

   :php:`->rowCount()` works well with `DELETE`, `UPDATE` and `INSERT` queries. However, it does NOT
   return a valid number for `SELECT` queries on some `DBMS`. Never use :php:`->rowCount()` on `SELECT`
   queries. This may work with MySOL, but fails with other databases like SQLite.


Re-use Prepared Statement()
===========================

Doctrine usually prepares a statement first, and then executes it with given parameters. Implementing
prepared statements depends on the given driver. A driver
not properly implementing prepared statements fall back to a direct execution of given query.

The following code example is probably outdated:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

    // use TYPO3\CMS\Core\Utility\GeneralUtility;
    // use TYPO3\CMS\Core\Database\ConnectionPool;
    $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');
    $queryBuilder = $connection->createQueryBuilder();
    $queryBuilder->getRestrictions()->removeAll();
    $sqlStatement = $queryBuilder->select('uid')
        ->from('pages')
        ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createPositionalParameter(0, \PDO::PARAM_INT)))
        ->getSQL();
    $statement = $connection->executeQuery($sqlStatement, [ 24 ]);
    $result1 = $statement->fetchAssociative();
    $statement->closeCursor(); // free the resources for this result
    $statement->bindValue(1, 25);
    $statement->execute();
    $result2 = $statement->fetchAssociative();
    $statement->closeCursor(); // free the resources for this result


Looking at a mysql debug log:

.. code-block:: none

    Prepare SELECT `uid` FROM `pages` WHERE `uid` = ?
    Execute SELECT `uid` FROM `pages` WHERE `uid` = '24'
    Execute SELECT `uid` FROM `pages` WHERE `uid` = '25'


The log shows one statement preparation with two executions.
