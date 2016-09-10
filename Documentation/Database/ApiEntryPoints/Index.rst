.. include:: ../../Includes.txt

.. _database-api-entry-points:

API main entry points
---------------------

ConnectionPool
^^^^^^^^^^^^^^

TYPO3`s interface to execute queries via `doctrine-dbal` typically starts by asking
the `ConnectionPool` for a `QueryBuilder` object, handing over the table name to be queried:

.. code-block:: php

    // Get a query builder for a table
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_myext_comments');
    // or
    // Get a connection for a table
    $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_myext_comments');


The `QueryBuilder` is the default workhorse object used by extension authors to express complex queries,
while a `Connection` instance can be used as shortcut to deal with some simple query cases and little written down code.


Pooling
%%%%%%%

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


QueryBuilder
^^^^^^^^^^^^

The `QueryBuilder` is a rather huge class that takes care of the main query dealing
with a happy little list of small methods:

   * Set type of query: `select()`, `insert()`, `update()` and `delete()` and friends

   * Prepare `WHERE` expressions

   * Manipulate default `WHERE` restrictions added by TYPO3 for `select()`

   * Handle `LIMIT`, `GROUP BY` and other SQL stuff

   * `execute()` a query and retrieve a `Statement` (a query result) object

Most methods of the `QueryBuilder` return `$this` and can be chained:

.. code-block:: php

   $queryBuilder->select('uid')->from('pages');

.. note::

   The QueryBuilder holds internal state and should not be re-used for different queries: Use one
   query builder per query. Get a fresh one by calling `$connection->createQueryBuilder()` if the
   same table is affected, or use `$connectionPool->getQueryBuilderForTable()` for a query
   on to a different table. No worries, creating those object instances is rather quick.


select() and andSelect()
%%%%%%%%%%%%%%%%%%%%%%%%

Create a `SELECT` query.

Select all fields:

.. code-block:: php

   // SELECT *
   $queryBuilder->select('*')


`select()` and a number of other methods of the `QueryBuilder` are `variadic <https://en.wikipedia.org/wiki/Variadic_function>`__
and can handle any number of arguments, for `select()`, every argument is interpreted as a single field name to select:

.. code-block:: php

   // SELECT `uid`, `pid`, `aField`
   $queryBuilder->select('uid', 'pid', 'aField');


Argument unpacking can be used if the list of fields is available as array already:

.. code-block:: php

   $fields = ['uid', 'pid', 'aField', 'anotherField'];
   $queryBuilder->select(...$fields);


`select()` supports `AS` and quotes identifiers automatically. This can become especially handy in join() operations.

.. code-block:: php

   // SELECT `tt_content`.`bodytext` AS `t1`.`text`
   $queryBuilder->select('tt_content.bodytext AS t1.text')


`select()` sets the list of fields that should be selected and `addSelect()` can add further items
to an existing list.

Mind that `select()` *resets* any formerly registered list and does not append. Thus, It usually doesn't
make much sense to call `select()` twice in a code flow, or to call it *after* an `addSelect()`. The methods
`where()` and `andWhere()` share the same behavior.

A useful combination of `select()` and `addSelect()` can be:

.. code-block:: php

    $queryBuilder->select(...$defaultList);
    if ($needAdditionalFields) {
        $queryBuilder->addSelect(...$additionalFields);
    }


.. note::

   `select()` and `count()` queries trigger TYPO3 CMS magic that adds further default where
   clauses if the queried table is also registered via `$GLOBALS['TCA']`. Follow to the `RestrictionBuilder`
   for details on that topic.


delete()
%%%%%%%%

Create a `DELETE FROM` query. The methods requires the table name to drop data from. Classic usage:

.. code-block:: php

   // DELETE FROM `tt_content` WHERE `bodytext` = 'klaus'
   $affectedRows = $queryBuilder
       ->delete('tt_content')
       ->where(
           $queryBuilder->expr()->eq('bodytext', $this->createNamedParameter('klaus'))
        )
       ->execute();


Remarks:

* In contrast to `select()`, `delete()` does *not* add `WHERE` restrictions like `AND \`deleted\` = 0`
  automatically.

* `delete()` does *not* magically transform a `DELETE FROM \`tt_content\` WHERE \`uid\` = 4711` to something like
  `UPDATE \`tt_content\` SET \`deleted\` = 1 WHERE \`uid\` = 4711` internally. A soft-delete must be handled on application
  level code with a dedicated lookup in `$GLOBALS['TCA']['theTable']['ctrl']['deleted']` to check if
  a specific table can handle the soft-delete, together with an `update()` instead.

* Multi-table delete is *not* supported: `DELETE FROM \`table1\`, \`table2\`` can not be created.

* `delete()` ignores `join()`

* `delete()` ignores `setMaxResults()`, `DELETE` with `LIMIT` does not work.




update() and set()
%%%%%%%%%%%%%%%%%%


from()
%%%%%%

`from()` needs a table name and an optional alias name. The method is typically called once per query build
and the table name is typically the same as what was given to `getQueryBuilderForTable()`. If the query joins
multiple tables, the argument should be the name of the first table within the `join()` chain.

.. code-block:: php

   // FROM `myTable`
   $queryBuilder->from('myTable');

   // FROM `myTable` AS `anAlias`
   $queryBuilder->from('myTable', 'anAlias');


`from()` can be called multiple times and will create the cartesian product of
tables if not restricted by an according `where()` or `andWhere()` expression. In general,
it is a good idea to use `from()` only once per query and model multi-table selection
with an explicit `join()` instead.
