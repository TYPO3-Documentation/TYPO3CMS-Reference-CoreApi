.. include:: /Includes.rst.txt

.. _database-connection:

==========
Connection
==========

An instance of class :php:`TYPO3\CMS\Core\Database\Connection` is retrieved from the
:ref:`ConnectionPool <database-connection-pool>` by calling `->getConnectionForTable()`
and handing over the table name a query should executed on.

The class extends the basic `Doctrine DBAL` `Doctrine\DBAL\Connection` class and is mainly
used internally within the `TYPO3 CMS` framework to establish, maintain and terminate
connections to single database endpoints. Those internal methods are not scope of this
documentation since an extension developer usually doesn't have to deal with that.

For an extension developer however, the class provides a list of "short-hand" methods
that allow dealing with "simple" query cases, without the complexity of the
:ref:`QueryBuilder <database-query-builder>`. Using those methods typically ends up in
rather short and easily readable code. The methods have in common that they support only
"equal" comparisons in `WHERE` conditions, that all fields and values are fully quoted
automatically and the created queries are executed right away.

.. note::

    The `Connection` object is designed to work on a single table only. If queries to multiple
    tables should be performed, the object must not be re-used. Instead, a single `Connection`
    instance should be retrieved via `ConnectionPool` per target table. However, it is allowed
    to use one `Connection` object for multiple queries to the same table.


insert()
========

Creates and executes an `INSERT INTO` statement. A (slightly simplified) example from the `Registry` API::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // INSERT INTO `sys_registry` (`entry_namespace`, `entry_key`, `entry_value`) VALUES ('aoeu', 'aoeu', 's:3:\"bar\";')
   GeneralUtility::makeInstance(ConnectionPool::class)
      ->getConnectionForTable('sys_registry')
      ->insert(
         'sys_registry',
         [
            'entry_namespace' => $namespace,
            'entry_key' => $key,
            'entry_value' => serialize($value)
         ]
      );


Well, that should be rather obvious: First argument is the table name to insert a row into, second argument is an
array of key/value pairs. All keys are quoted to field names and all values are quoted to string values.

It is possible to add another array as third argument to specify how single values are quoted. This is useful
if `date` or `numbers` or similar should be inserted. The example below quotes the first value to an integer
and the second one to a string::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Connection;
   // INSERT INTO `sys_log` (`userid`, `details`) VALUES (42, 'klaus')
   GeneralUtility::makeInstance(ConnectionPool::class)
      ->getConnectionForTable('sys_log')
      ->insert(
         'sys_log',
         [
            'userid' => (int)$userId,
            'details' => (string)$details,
         ],
         [
            Connection::PARAM_INT,
            Connection::PARAM_STR,
         ]
      );


`insert()` returns the number of affected rows. Guess what? That's the number `1` ... In case something
goes wrong a `\Doctrine\DBAL\DBALException` is raised.

.. note::

    A list of allowed field types for proper quoting can be found in the :php:`TYPO3\CMS\Core\Database\Connection`
    class and its base class :php:`\Doctrine\DBAL\Connection`


bulkInsert()
============

`INSERT` multiple rows at once::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   $connection = GeneralUtility::makeInstance(ConnectionPool::class)
      ->getConnectionForTable('sys_log');
   $connection->bulkInsert(
      'sys_log',
      [
         [(int)$userId, (string)$details1],
         [(int)$userId, (string)$details2],
      ],
      [
         'userid',
         'details',
      ],
      [
         Connection::PARAM_INT,
         Connection::PARAM_STR,
      ]
   );

First argument is the table to insert table into, second argument is an array of rows, third argument is the list
of field names. Similar to :php:`->insert()` it is optionally possible to add another argument to specify quoting details,
if omitted, everything will be quoted to strings.

.. note::

    `mysql` is rather forgiving when it comes to insufficient field quoting: Inserting a string to an `int` field will
    not raise an error and `mysql` will adapt internally. However, other `dbms` are not that relaxed and may raise
    errors. It is good practice to specify field types for each field, especially if they are not strings. Doing
    so right away will reduce the number of raised bugs if people run your extension an anything else than `mysql`.


.. _database-connection-update:

update()
========

Create and execute an `UPDATE` statement. The example from `FAL's` `ResourceStorage` sets a storage to offline::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Connection;
   // UPDATE `sys_file_storage` SET `is_online` = 0 WHERE `uid` = '42'
   GeneralUtility::makeInstance(ConnectionPool::class)
      ->getConnectionForTable('sys_file_storage')
      ->update(
         'sys_file_storage',
         ['is_online' => 0],
         ['uid' => (int)$this->getUid()],
         [Connection::PARAM_INT]
      );


First argument is the table an update should be executed on, the second argument is an array of key/value pairs to set,
the third argument is an array of "equal" where statements that are combined with `AND`, the (optional) fourth argument
specifies the type of values to be updated similar to :php:`->insert()` and :php:`bulkInsert()`.

Note the third argument ``WHERE `foo` = 'bar'`` only supports equal `=`. For more complex stuff the `QueryBuilder`
has to be used.

The method returns the number of affected rows.


delete()
========

Execute a `DELETE` query using `equal` conditions in `WHERE`, example from `BackendUtility` to mark
rows as no longer locked by a user::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Connection;
   // DELETE FROM `sys_lockedrecords` WHERE `userid` = 42
   GeneralUtility::makeInstance(ConnectionPool::class)
      ->getConnectionForTable('sys_lockedrecords')
      ->delete(
         'sys_lockedrecords',
         ['userid' => (int)42],
         [Connection::PARAM_INT]
       );


First argument is the table name, second argument is a list of `AND` combined `WHERE` conditions as array, third
argument specifies the quoting of `WHERE` values. There is a pattern ;)

.. note::

    `TYPO3 CMS` uses a "soft delete" approach for many tables. Instead of directly deleting a rows in the database,
    a field - often called `deleted` - is set from 0 to 1. Executing a `DELETE` query circumvents this and really
    removes rows from a table. For most tables, it is better to use the :ref:`DataHandler <tce-database-basics>` API
    to handle deletes instead of executing such low level queries directly.


truncate()
==========

Empty a table, removing all rows. Usually much quicker than a :php:`->delete()` of all rows. This typically
resets "auto increment primary keys" to zero. Use with care::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // TRUNCATE `cache_treelist`
   GeneralUtility::makeInstance(ConnectionPool::class)
      ->getConnectionForTable('cache_treelist')
      ->truncate('cache_treelist');


count()
=======

A `COUNT` query. Again, this methods becomes handy if very simple `COUNT` statements are to be executed, the example
returns tha number of active rows from table `tt_content` that have their `bodytext` field set to `klaus`::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT COUNT(*)
   // FROM `tt_content`
   // WHERE
   //     (`bodytext` = 'klaus')
   //     AND (
   //         (`tt_content`.`deleted` = 0)
   //         AND (`tt_content`.`hidden` = 0)
   //         AND (`tt_content`.`starttime` <= 1475621940)
   //         AND ((`tt_content`.`endtime` = 0) OR (`tt_content`.`endtime` > 1475621940))
   //     )
   $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content');
   $rowCount = $connection->count(
      '*',
      'tt_content',
      ['bodytext' => 'klaus']
   );


First argument is the field to count on, usually `*` or `uid`. Second argument is the table name, third argument
is an array of `WHERE` equal conditions combined with `AND`.

Remarks:

* :php:`->count()` of `Connection` returns the number directly as integer, in contrast to the method of the `QueryBuilder`,
  there is no need to call :php:`->fetchColumns(0)` or similar.

* The third argument expects all `WHERE` values to be strings, each single expression is combined with `AND`.

* The :ref:`RestrictionBuilder <database-restriction-builder>` kicks in and adds additional `WHERE` conditions
  based on `TCA` settings.

* Field names and values are quoted automatically.

* If anything more complex than a simple `equal` condition on `WHERE` is needed, the `QueryBuilder` methods
  are a better choice: Next to :php:`->select()`, the :php:`->count()` query is often the least useful method of the
  `Connection` object.


select()
========

Creates and executes a simple `SELECT` query based on `equal` conditions. Its usage is limited, the
:ref:`RestrictionBuilder <database-restriction-builder>` kicks in and key/value pairs are automatically
quoted::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT `entry_key`, `entry_value` FROM `sys_registry` WHERE `entry_namespace` = 'my_extension'
   $resultRows = GeneralUtility::makeInstance(ConnectionPool::class)
      ->getConnectionForTable('sys_registry')
      ->select(
         ['entry_key', 'entry_value'],
         'sys_registry',
         ['entry_namespace' => 'my_extension']
      );


Remarks:

* In contrast to the other short-hand methods, :php:`->select()` returns a :ref:`Statement <database-statement>` object
  ready to :php:`->fetch()` single rows or to :php:`->fetchAll()`

* The method accepts a series of further arguments to specify `GROUP BY`, `ORDER BY`, `LIMIT` and `OFFSET` query parts.

* For non-trivial `SELECT` queries, it is often better to switch to the according method of the
  :ref:`QueryBuilder <database-query-builder>` object.

* The :ref:`RestrictionBuilder <database-restriction-builder>` adds default `WHERE` restrictions. If those restrictions
  do not apply to the query needs, it is required to switch to the `QueryBuilder->select()` method for fine-grained
  `WHERE` manipulation.


lastInsertId()
==============

Returns the `uid` of the last :php:`->insert()` statement. Useful if this id needs to be used afterwards directly::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Connection;
   $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
   $databaseConnectionForPages = $connectionPool->getConnectionForTable('myTable');
   $databaseConnectionForPages->insert(
      'myTable',
      [
         'pid' => 0,
         'title' => 'Home',
      ]
   );
   $pageUid = (int)$databaseConnectionForPages->lastInsertId('pages');

Remarks:

* :php:`->lastInsertId($tableName)` needs the table name as first argument. While this is optional, you should always
  supply the table name for DBAL compatibility with engines like postgres.

* If the auto increment field name is not `uid`, the second argument with the name of this field must be supplied.
  For casual TYPO3 tables, `uid` is ok and the argument can be left out.


createQueryBuilder()
====================

The :ref:`QueryBuilder <database-query-builder>` should not be re-used for multiple different queries. However,
it sometimes becomes handy to first fetch a `Connection` object for a specific table and to execute a simple
query, and to create a `QueryBuilder` for a more complex query from this connection object later. The methods
usefulness is limited however and no good example within the core can be found at the time of this writing.

The method can be helpful in loops to save some precious code characters, too::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($myTable);
   foreach ($someList as $aListValue) {
      $myResult = $connection->createQueryBuilder
         ->select('something')
         ->from('whatever')
         ->where(...)
         ->execute()
         ->fetchAll();
   }
