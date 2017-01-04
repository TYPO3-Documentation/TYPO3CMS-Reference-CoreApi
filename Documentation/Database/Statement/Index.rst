.. include:: ../../Includes.txt

.. _database-statement:

Statement
---------

A `Statement` object is returned by :php:`QueryBuilder->execute()` for :php:`->select()` and :php:`->count()`
query types and by :php:`Connection->select()` and :php:`Connection->count()` calls.

The object represents a query result set and comes with methods to :php:`->fetch()` single rows
or to :php:`->fetchAll()` of them. Additionally, it can also be used to execute a single prepared
statement with different values multiple times. This part is however not widely used within
the `TYPO3 CMS` core yet, and thus not fully documented here.

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


fetch()
^^^^^^^

Fetch next row from a result statement. Usually used in while() loops. Typical example::

   // Fetch all records from tt_content on page 42
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $statement = $queryBuilder
      ->select('uid', 'bodytext')
      ->from('tt_content')
      ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT)))
      ->execute();
   while ($row = $statement->fetch()) {
      // Do something useful with that single $row
   }


:php:`->fetch()` returns arrays with single field / values pairs until the end of the result set is reached
which then returns false and thus breaks the while loop.


fetchAll()
^^^^^^^^^^

Returns an array containing all of the result set rows by implementing the same while loop as above internally.
Using that method saves some precious code characters but is more memory intensive if the result set is large
with lots of rows and lot of data since big arrays are carried around in `PHP`::

   // Fetch all records from tt_content on page 42
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $rows = $queryBuilder
      ->select('uid', 'bodytext')
      ->from('tt_content')
      ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT)))
      ->execute()
      ->fetchAll();


fetchColumn()
^^^^^^^^^^^^^

Returns a single column from the next row of a result set, other columns from that result row are discarded.
This method is especially handy for :php:`QueryBuilder->count()` queries. The :php:`Connection->count()` implementation
does exactly that to return the number of rows directly::

   // Get the number of tt_content records on pid 42 into variable $numberOfRecords
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $numberOfRecords = $queryBuilder
      ->count('uid')
      ->from('tt_content')
      ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT)))
      ->execute()
      ->fetchColumn(0);


rowCount()
^^^^^^^^^^

Returns the number of rows affected by the last execution of this statement. Use that method
instead of counting the number of records in a :php:`->fetch()` loop manually.

.. warning::

   :php:`->rowCount()` works well with `DELETE`, `UPDATE` and `INSERT` queries. However, it does NOT
   return a valid number for `SELECT` queries on some `DBMS`. Never use :php:`->rowCount()` on `SELECT`
   queries. This may work with MySOL, but fails with other databases like SQLite.
