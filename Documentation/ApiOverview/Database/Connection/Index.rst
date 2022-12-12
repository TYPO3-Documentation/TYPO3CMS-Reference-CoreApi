.. include:: /Includes.rst.txt

.. _database-connection:

==========
Connection
==========

.. contents:: **Table of Contents**
   :local:


.. _database-connection-introduction:

Introduction
============

The :php:`TYPO3\CMS\Core\Database\Connection` class extends the basic Doctrine
DBAL :php:`Doctrine\DBAL\Connection` class and is mainly used internally in
TYPO3 to establish, maintain and terminate connections to single database
endpoints. These internal methods are not the scope of this documentation, since
an extension developer usually does not have to deal with them.

However, for an extension developer, the class provides a list of short-hand
methods that allow you to deal with query cases without the complexity
of the :ref:`query builder <database-query-builder>`. Using these methods
usually ends up in rather short and easy-to-read code. The methods have in common
that they only support "equal" comparisons in :sql:`WHERE` conditions, that all
fields and values are automatically fully quoted, and that the created queries
are executed right away.

..  note::
    The :php:`Connection` object is designed to work on a single table only. If
    queries are performed on multiple tables, the object must not be reused.
    Instead, a single :php:`Connection` instance per target table should be
    retrieved via :ref:`ConnectionPool <database-connection-pool>`. However, it
    is allowed to use one :php:`Connection` object for multiple queries on the
    same table.


.. _database-connection-instantiation:

Instantiation
=============

Using the connection pool
-------------------------

An instance of the :php:`TYPO3\CMS\Core\Database\Connection` class is retrieved
from the :ref:`ConnectionPool <database-connection-pool>` by calling
:php:`->getConnectionForTable()` and passing the table name for which a query
should be executed. The :php:`ConnectionPool` can be injected via constructor:

..  literalinclude:: _MyTableRepositoryWithConnectionPool.php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Via dependency injection
------------------------

Another way is to inject the :php:`Connection` object directly via
:ref:`dependency injection <DependencyInjection>` if you only use one table.

..  rst-class:: bignums-xxl

#.  Configure the concrete connection as a service

    To make a concrete :php:`Connection` object available as a service, use
    the factory option in the service configuration:

    ..  code-block:: yaml
        :caption: EXT:my_extension/Configuration/Services.yaml
        :emphasize-lines: 10-18

        services:
          _defaults:
            autowire: true
            autoconfigure: true
            public: false

          MyVendor\MyExtension\:
            resource: '../Classes/*'

          connection.tx_myextension_domain_model_mytable:
            class: 'TYPO3\CMS\Core\Database\Connection'
            factory: ['@TYPO3\CMS\Core\Database\ConnectionPool', 'getConnectionForTable']
            arguments:
              - 'tx_myextension_domain_model_mytable'

          MyVendor\MyExtension\Domain\Repository\MyTableRepository:
            arguments:
              - '@connection.tx_myextension_domain_model_mytable'

#.  Use constructor injection in your class

    Now the :php:`Connection` object for a specific table can be injected via
    the constructor:

    ..  literalinclude:: _MyTableRepositoryWithConnection.php
        :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php


.. _database-connection-insert:

insert()
========

The :php:`insert()` method creates and executes an :sql:`INSERT INTO` statement.
A (slightly simplified) example from the Registry API:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // INSERT
    //     INTO `sys_registry` (`entry_namespace`, `entry_key`, `entry_value`)
    //     VALUES ('aoeu', 'aoeu', 's:3:\"bar\";')
    $this->connectionPool
        ->getConnectionForTable('sys_registry')
        ->insert(
            'sys_registry',
            [
                'entry_namespace' => $namespace,
                'entry_key' => $key,
                'entry_value' => serialize($value)
            ]
        );

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

Arguments of the :php:`insert()` method:

1.  The name of the table the row should be inserted. Required.
2.  An associative array containing field/value pairs. The key is a field name,
    the value is the value to be inserted. All keys are quoted to field names
    and all values are quoted to string values. Required.
3.  Specify how single values are quoted. This is useful if a date, number or
    similar should be inserted. Optional.

    The example below quotes the first value to an integer and the second one to
    a string:

    ..  code-block:: php
        :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

        // use TYPO3\CMS\Core\Database\Connection;
        // INSERT INTO `sys_log` (`userid`, `details`) VALUES (42, 'lorem')
        $this->connectionPool
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

    Read :ref:`how to instantiate <database-connection-instantiation>` a
    connection with the connection pool.

:php:`insert()` returns the number of affected rows. Guess what? That is the
number `1` ... If something goes wrong, a :php:`\Doctrine\DBAL\DBALException` is
thrown.

..  note::
    A list of allowed field types for proper quoting can be found in the
    :php:`TYPO3\CMS\Core\Database\Connection` class.


.. _database-connection-bulk-insert:

bulkInsert()
============

This method insert multiple rows at once:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    $connection = $this->connectionPool->getConnectionForTable('sys_log');
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

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

Arguments of the :php:`bulkInsert()` method:

1.  The name of the table the row should be inserted. Required.
2.  An array of the values to be inserted. Required.
3.  An array containing the column names of the data which should be inserted.
    Optional.
4.  Specify how single values are quoted. Similar to :ref:`insert()
    <database-connection-insert>`; if omitted, everything will be quoted
    to strings. Optional.

The number of inserted rows are returned. If something goes wrong, a
:php:`\Doctrine\DBAL\DBALException` is thrown.

..  note::
    MySQL is quite forgiving when it comes to insufficient field quoting:
    Inserting a string into an :sql:`int` field does not cause an error and
    MySQL adjusts internally. However, other :abbr:`DBMSes (Database management
    systems)` are not that relaxed and may raise errors. It is good practice to
    specify field types for each field, especially if they are not strings.
    Doing this immediately will reduce the number of bugs that occur when people
    run your extension an anything else than MySQL.


.. _database-connection-update:

update()
========

Create an :sql:`UPDATE` statement and execute it. The example from FAL's
:php:`ResourceStorage` sets a storage to offline:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    // UPDATE `sys_file_storage` SET `is_online` = 0 WHERE `uid` = '42'
    $this->connectionPool
        ->getConnectionForTable('sys_file_storage')
        ->update(
            'sys_file_storage',
            ['is_online' => 0],
            ['uid' => (int)$this->getUid()],
            [Connection::PARAM_INT]
        );

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

Arguments of the :php:`update()` method:

1.  The name of the table to update. Required.
2.  An associative array containing field/value pairs to be updated. The key is
    a field name, the value is the value. In SQL they are mapped to the
    :sql:`SET` keyword. Required.
3.  The update criteria as an array of key/value pairs. The key is the field
    name, the value is the value. In SQL they are mapped in a :sql:`WHERE`
    keyword combined with :sql:`AND`. Required.
4.  Specify how single values are quoted. Similar to :ref:`insert()
    <database-connection-insert>`; if omitted, everything will be quoted
    to strings. Optional.

The method returns the number of updated rows. If something goes wrong, a
:php:`\Doctrine\DBAL\DBALException` is thrown.

..  note::
    The third argument ``WHERE `foo` = 'bar'`` supports only equal `=`. For more
    complex stuff the :ref:`query builder <database-query-builder>` must be used.


.. _database-connection-delete:

delete()
========

Execute a :sql:`DELETE` query using `equal` conditions in :sql:`WHERE`, example
from :php:`BackendUtility`, to mark rows as no longer locked by a user:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    // DELETE FROM `sys_lockedrecords` WHERE `userid` = 42
    $this->connectionPool
        ->getConnectionForTable('sys_lockedrecords')
        ->delete(
            'sys_lockedrecords',
            ['userid' => (int)42],
            [Connection::PARAM_INT]
        );

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

Arguments of the :php:`delete()` method:

1.  The name of the table. Required.
2.  The delete criteria as an array of key/value pairs. The key is the field
    name, the value is the value. In SQL they are mapped in a :sql:`WHERE`
    keyword combined with :sql:`AND`. Required.
3.  Specify how single values are quoted. Similar to :ref:`insert()
    <database-connection-insert>`; if omitted, everything will be quoted
    to strings. Optional.

The method returns the number of deleted rows. If something goes wrong, a
:php:`\Doctrine\DBAL\DBALException` is thrown.

..  note::
    TYPO3 uses a ":ref:`soft delete <t3tca:ctrl-reference-delete>`" approach for
    many tables. Instead of deleting a  row directly in the database, a field -
    often called :sql:`deleted` - is set from 0 to 1. Executing a :sql:`DELETE`
    query circumvents this and really removes rows from a table. For most
    tables, it is better to use the :ref:`DataHandler <tce-database-basics>` API
    to handle deletions instead of executing such low-level queries directly.


.. _database-connection-truncate:

truncate()
==========

This method empties a table, removing all rows. It is usually much faster than
a :ref:`delete() <database-connection-delete>` of all rows. This typically
resets "auto increment primary keys" to zero. Use with care:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // TRUNCATE `cache_treelist`
    $this->connectionPool
        ->getConnectionForTable('cache_treelist')
        ->truncate('cache_treelist');

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

The argument is the name of the table to be truncated. If something goes wrong,
a :php:`\Doctrine\DBAL\DBALException` is thrown.


.. _database-connection-count:

count()
=======

This method executes a :sql:`COUNT` query. Again, this becomes useful when very
simple :sql:`COUNT` statements are to be executed. The example below returns the
number of active rows from the table :sql:`tt_content` whose :sql:`bodytext`
field set to `lorem`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // SELECT COUNT(*)
    // FROM `tt_content`
    // WHERE
    //     (`bodytext` = 'lorem')
    //     AND (
    //         (`tt_content`.`deleted` = 0)
    //         AND (`tt_content`.`hidden` = 0)
    //         AND (`tt_content`.`starttime` <= 1475621940)
    //         AND ((`tt_content`.`endtime` = 0) OR (`tt_content`.`endtime` > 1475621940))
    //     )
    $connection = $this->connectionPool->getConnectionForTable('tt_content');
    $rowCount = $connection->count(
        '*',
        'tt_content',
        ['bodytext' => 'lorem']
    );

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

Arguments of the :php:`count()` method:

1.  The field to count, usually :sql:`*` or :sql:`uid`. Required.
2.  The name of the table. Required.
3.  The select criteria as an array of key/value pairs. The key is the field
    name, the value is the value. In SQL they are mapped in a :sql:`WHERE`
    keyword combined with :sql:`AND`. Required.

The method returns the counted rows.

Remarks:

*   :php:`Connection::count()` returns the number directly as an integer, unlike
    the method of the :ref:`query builder <database-query-builder>` it is not
    necessary to call :php:`->fetchColumns(0)` or similar.

*   The third argument expects all :sql:`WHERE` values to be strings, each
    single expression is combined with :sql:`AND`.

*   The :ref:`restriction builder <database-restriction-builder>` kicks in and
    adds additional :sql:`WHERE` conditions based on TCA settings.

*   Field names and values are quoted automatically.

*   If anything more complex than a simple `equal` condition on :sql:`WHERE` is
    needed, the :ref:`query builder <database-query-builder>` methods are the
    better choice: next to :ref:`select() <database-connection-select>`,
    the :php:`->count()` query is often the least useful method of the
    :php:`Connection` object.


.. _database-connection-select:

select()
========

This method creates and executes a simple :sql:`SELECT` query based on `equal`
conditions. Its usage is limited, the :ref:`restriction builder
<database-restriction-builder>` kicks in and key/value pairs are automatically
quoted:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // SELECT `entry_key`, `entry_value`
    //     FROM `sys_registry`
    //     WHERE `entry_namespace` = 'my_extension'
    $resultRows = $this->connectionPool
      ->getConnectionForTable('sys_registry')
      ->select(
         ['entry_key', 'entry_value'],
         'sys_registry',
         ['entry_namespace' => 'my_extension']
      );

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

Arguments of the :php:`select()` method:

1.  The columns of the table which to select as an array. Required.
2.  The name of the table. Required.
3.  The select criteria as an array of key/value pairs. The key is the field
    name, the value is the value. In SQL they are mapped in a :sql:`WHERE`
    keyword combined with :sql:`AND`. Optional.
4.  The columns to group the results by as an array. In SQL they are mapped
    in a :sql:`GROUP BY` keyword. Optional.
5.  An associative array of column name/sort directions pairs. In SQL they are
    mapped in an :sql:`ORDER BY` keyword. Optional.
6.  The maximum number of rows to return. In SQL it is mapped in a :sql:`LIMIT`
    keyword. Optional.
7.  The first result row to select (when used the maximum number of rows). In
    SQL it is mapped in an :sql:`OFFSET` keyword. Optional.

In contrast to the other short-hand methods, :php:`->select()` returns a
:ref:`Result <database-result>` object ready for :php:`->fetchAssociative()` to
get single rows or for :php:`->fetchAllAssociative()` to get all rows at once.

Remarks:

*   For non-trivial :sql:`SELECT` queries it is often better to switch to the
    according method of the :ref:`query builder <database-query-builder>`
    object.

*   The :ref:`restriction builder <database-restriction-builder>` adds default
    :sql:`WHERE` restrictions. If these restrictions do not match the query
    requirements, it is necessary to switch to the :php:`QueryBuilder->select()`
    method for fine-grained :sql:`WHERE` manipulation.


.. _database-connection-last-insert-id:

lastInsertId()
==============

This method returns the :sql:`uid` of the last :ref:`insert()
<database-connection-insert>` statement. This is useful if the id is to be used
directly afterwards:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    $connection = $this->connectionPool->getConnectionForTable('pages');
    $connection->insert(
        'pages',
        [
            'pid' => 0,
            'title' => 'Home',
        ]
    );
    $pageUid = (int)$connection->lastInsertId('pages');

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

Remarks:

*   :php:`->lastInsertId($tableName)` takes the table name as first argument.
    Although it is optional, you should always specify the table name for
    Doctrine DBAL compatibility with engines like PostgreSQL.

*   If the name of the auto increment field is not :sql:`uid`, the second
    argument must be specified with the name of that field. For simple TYPO3
    tables, :sql:`uid` is fine and the argument can be omitted.


.. _database-connection-create-query-builder:

createQueryBuilder()
====================

The :ref:`query builder <database-query-builder>` should not be reused for
multiple different queries. However, sometimes it is convenient to first fetch a
connection object for a specific table and execute a simple query, and later
create a query builder for a more complex query from that connection object. The
usefulness of this method is limited, however, and at the time of writing no
good example could be found in the Core.

The method can also be useful in loops to save some precious code characters:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    $connection = $this->connection->getConnectionForTable($myTable);
    foreach ($someList as $aListValue) {
        $myResult = $connection->createQueryBuilder
            ->select('something')
            ->from('whatever')
            ->where(...)
            ->executeQuery()
            ->fetchAllAssociative();
    }

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.
