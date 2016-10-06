.. include:: ../../Includes.txt

.. _database-statement:

Statement
---------

A `Statement` object is returned by `QueryBuilder->execute()` for `->select()` and `->count()`
query types and by `Connection->select()` and `Connection->count()` calls.

The object represents a query result set and comes with methods to `->fetch()` single rows
or to `->fetchAll()` of them. Additionally, it can also be used to execute a single prepared
statement with different values multiple times. This part is however not widely used within
the `TYPO3 CMS` core yet, and thus not fully documented here.


fetch()
^^^^^^^

Fetch next row from a result statement. Usually used in while() loops. Typical example:

.. code-block:: php

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


`->fetch()` returns arrays with single field / values pairs until the end of the result set is reached
which then returns false and thus breaks the while loop.


fetchAll()
^^^^^^^^^^

Returns an array containing all of the result set rows by implementing the same while loop as above internally.
Using that method saves some precious code characters but is more memory intensive if the result set is large
with lots of rows and lot of data since big arrays are carried around in `PHP`.

.. code-block:: php

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
This method is especially handy for `QueryBuilder->count()` queries. The `Connection->count()` implementation
does exactly that to return the number of rows directly:

.. code-block:: php

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
instead of counting the number of records in a `->fetch()` loop manually ...