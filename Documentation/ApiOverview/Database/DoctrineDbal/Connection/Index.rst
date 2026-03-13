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
DBAL :php:`Doctrine\DBAL\Connection` class and used internally in
TYPO3 to establish, maintain and terminate connections to single database
endpoints. These internal methods are not the scope of this documentation, since
an extension developer usually does not have to deal with them.

However, the class provides extension developers with a list of short-hand
methods for queries, delete and update statements
without having to deal with the complexity of :ref:`query builder <database-query-builder>`.
Using these methods will usually result in short and easy-to-read code.
The methods only support **equal** comparison operators
in ANDed :sql:`WHERE` conditions.
All fields and values are automatically fully quoted, and the created queries
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

    ..  literalinclude:: _Services.yaml
        :language: yaml
        :caption: EXT:my_extension/Configuration/Services.yaml
        :emphasize-lines: 10-18

#.  Use constructor injection in your class

    Now the :php:`Connection` object for a specific table can be injected via
    the constructor:

    ..  literalinclude:: _MyTableRepositoryWithConnection.php
        :language: php
        :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php


.. _database-connection-parameter-types:

Parameter types
===============

The parameter types are used in various places to bind values to types, for
example, when using named parameters in the
:ref:`query builder <database-query-builder>`:

..  code-block:: php

    // use TYPO3\CMS\Core\Database\Connection;

    $queryBuilder->createNamedParameter(42, Connection::PARAM_INT);

The following parameter types are available:

:php:`\TYPO3\CMS\Core\Database\Connection::PARAM_NULL`
    Represents an SQL :sql:`NULL` data type.

:php:`\TYPO3\CMS\Core\Database\Connection::PARAM_INT`
    Represents an SQL :sql:`INTEGER` data type.

:php:`\TYPO3\CMS\Core\Database\Connection::PARAM_STR`
    Represents an SQL :sql:`CHAR` or `VARCHAR` data type.

:php:`\TYPO3\CMS\Core\Database\Connection::PARAM_LOB`
    Represents an SQL large object data type.

:php:`\TYPO3\CMS\Core\Database\Connection::PARAM_BOOL`
    Represents a boolean data type.

:php:`\TYPO3\CMS\Core\Database\Connection::PARAM_INT_ARRAY`
    Represents an array of integer values.

:php:`\TYPO3\CMS\Core\Database\Connection::PARAM_STR_ARRAY`
    Represents an array of string values.

The default parameter type is :php:`Connection::PARAM_STR`, if this argument
is omitted.

Internally, these parameter types are mapped to the types Doctrine DBAL expects.


.. _database-connection-insert:

insert()
========

The :php:`insert()` method creates and executes an :sql:`INSERT INTO` statement.
Example:

..  literalinclude:: _MyTableRepository_insert.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

This method supports the native database field declaration :sql:`json`,
see :ref:`json_database_type`.

Arguments of the :php:`insert()` method:

1.  The name of the table the row should be inserted. Required.
2.  An associative array containing field/value pairs. The key is a field name,
    the value is the value to be inserted. All keys are quoted to field names
    and all values are quoted to string values. Required.
3.  Specify how single values are quoted. This is useful if a date, number or
    similar should be inserted. Optional.

    The example below quotes the first value to an integer and the second one to
    a string:

    ..  literalinclude:: _MyTableRepository_insert_types.php
        :language: php
        :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    Read :ref:`how to instantiate <database-connection-instantiation>` a
    connection with the connection pool.
    See available :ref:`parameter types <database-connection-parameter-types>`.

:php:`insert()` returns the number of affected rows. Guess what? That is the
number `1` ... If something goes wrong, a :php:`\Doctrine\DBAL\Exception` is
thrown.

..  note::
    A list of allowed field types for proper quoting can be found in the
    :php:`TYPO3\CMS\Core\Database\Connection` class.


.. _database-connection-bulk-insert:

bulkInsert()
============

This method insert multiple rows at once:

..  literalinclude:: _MyTableRepository_bulkinsert.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

Arguments of the :php:`bulkInsert()` method:

1.  The name of the table the row should be inserted. Required.
2.  An array of the values to be inserted. Required.
3.  An array containing the column names of the data which should be inserted.
    Optional.
4.  Specify how single values are quoted. Similar to :ref:`insert()
    <database-connection-insert>`; if omitted, everything will be quoted
    to strings. Optional.

The number of inserted rows are returned. If something goes wrong, a
:php:`\Doctrine\DBAL\Exception` is thrown.

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

..  literalinclude:: _MyTableRepository_update.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

This method supports the native database field declaration :sql:`json`,
see :ref:`json_database_type`.

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

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
:php:`\Doctrine\DBAL\Exception` is thrown.

..  note::
    The third argument ``WHERE `foo` = 'bar'`` supports only equal `=`. For more
    complex stuff the :ref:`query builder <database-query-builder>` must be used.


.. _database-connection-delete:

delete()
========

Execute a :sql:`DELETE` query using `equal` conditions in :sql:`WHERE`, example
from :php:`BackendUtility`, to mark rows as no longer locked by a user:

..  literalinclude:: _MyTableRepository_delete.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

Arguments of the :php:`delete()` method:

1.  The name of the table. Required.
2.  The delete criteria as an array of key/value pairs. The key is the field
    name, the value is the value. In SQL they are mapped in a :sql:`WHERE`
    keyword combined with :sql:`AND`. Required.
3.  Specify how single values are quoted. Similar to :ref:`insert()
    <database-connection-insert>`; if omitted, everything will be quoted
    to strings. Optional.

The method returns the number of deleted rows. If something goes wrong, a
:php:`\Doctrine\DBAL\Exception` is thrown.

..  note::
    TYPO3 uses a ":ref:`soft delete <t3tca:ctrl-reference-delete>`" approach for
    many tables. Instead of deleting a  row directly in the database, a field -
    often called :sql:`deleted` - is set from 0 to 1. Executing a :sql:`DELETE`
    query circumvents this and really removes rows from a table. For most
    tables, it is better to use the :ref:`DataHandler <datahandler-basics>` API
    to handle deletions instead of executing such low-level queries directly.


.. _database-connection-truncate:

truncate()
==========

This method empties a table, removing all rows. It is usually much faster than
a :ref:`delete() <database-connection-delete>` of all rows. This typically
resets "auto increment primary keys" to zero. Use with care:

..  literalinclude:: _MyCacheRepository_truncate.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

The argument is the name of the table to be truncated. If something goes wrong,
a :php:`\Doctrine\DBAL\Exception` is thrown.


.. _database-connection-count:

count()
=======

This method executes a :sql:`COUNT` query. Again, this becomes useful when very
simple :sql:`COUNT` statements are to be executed. The example below returns the
number of active rows (not hidden or deleted or disabled by time) from the
table :sql:`tx_myextension_mytable` whose
field :sql:`some_value` field set to :php:`$something`:

..  literalinclude:: _MyTableRepository_count.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

Arguments of the :php:`count()` method:

1.  The field to count, usually :sql:`*` or :sql:`uid`. Required.
2.  The name of the table. Required.
3.  An array of key/value pairs corresponding to the :sql:`WHERE` part of an SQL
    statement (and :sql:`AND` if there is more than one array entry). The key is
    the name of the database field. Required.

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

..  literalinclude:: _MyTableRepository_select.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

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

..  versionchanged:: 13.0
    The method no longer accepts the table name as first argument and the
    name of the auto-increment field as second argument.

This method returns the :sql:`uid` of the last :ref:`insert()
<database-connection-insert>` statement. This is useful if the ID is to be used
directly afterwards:

..  literalinclude:: _MyTableRepository_lastinsertId.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

Remarks:

*   The last inserted ID needs to be retrieved directly before inserting a
    record to another table. That should be the usual workflow used in the wild
    - but be aware of this.


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

..  literalinclude:: _MyTableRepository_queryBuilder.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to instantiate <database-connection-instantiation>` a connection
with the connection pool.

..  _json_database_type:

Native JSON database field type support
=======================================

JSON-like objects or arrays are automatically serialized during writing a
dataset to the database, when the native JSON type was used in the database
schema definition.

By using the native database field declaration `json` in :file:`ext_tables.sql`
file within an extension, TYPO3 converts arrays or objects of type
:php:`\JsonSerializable` into a serialized JSON value in the database when
persisting such values via :php:`Connection->insert()` or
:php:`Connection->update()` if no explicit DB types are handed in as additional
method argument.

TYPO3 now utilizes the native type mapping of Doctrine to convert special types
such as JSON database field types automatically for writing.

Example:

..  literalinclude:: _ext_tables.sql
    :language: php
    :caption: EXT:my_extension/ext_tables.sql

..  literalinclude:: _MyTableRepository_insert.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

..  note::

    When reading a record from the database via QueryBuilder, it is still necessary
    though to transfer the serialized value to an array or object doing custom
    serialization.
