.. include:: ../../../Includes.txt

.. _database-query-builder:

============
QueryBuilder
============

The `QueryBuilder` is a rather huge class that takes care of the main query dealing.

An instance can get hold of by calling the :php:`ConnectionPool->getQueryBuilderForTable()` and handing
over the table. Never instantiate and initialize the `QueryBuilder` directly via :php:`makeInstance()`! ::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('aTable');


This documentation does not mention every single available method but sticks to those
used in casual queries and normal code flow. There are a couple of not mentioned methods,
most of them are either very seldom used or marked as internal. Extension authors typically
don't have to deal with anything not mentioned here.

.. warning::

   From security point of view, the documentation of
   :ref:`->createNamedParameter() <database-query-builder-create-named-parameter>` and
   :ref:`->quoteIdentifier() <database-query-builder-quote-identifier>` are an absolute **must read and follow** section.
   Make very sure this is understood and use this for **each and every query** to prevent SQL injections!


The `QueryBuilder` comes with a happy little list of small methods:

   * Set type of query: :php:`->select()`, :php:`->count()`, :php:`->update()`, :php:`->insert()` and :php:`delete()`

   * Prepare `WHERE` conditions

   * Manipulate default `WHERE` restrictions added by TYPO3 for :php:`->select()`

   * Add `LIMIT`, `GROUP BY` and other SQL stuff

   * :php:`->execute()` a query and retrieve a `Statement` (a query result) object

Most methods of the `QueryBuilder` return `$this` and can be chained::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Connection;
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages')->createQueryBuilder();
   $queryBuilder->select('uid')->from('pages');

.. note::

   The QueryBuilder holds internal state and should not be re-used for different queries: Use one
   query builder per query. Get a fresh one by calling :php:`$connection->createQueryBuilder()` if the
   same table is affected, or use :php:`$connectionPool->getQueryBuilderForTable()` for a query
   on to a different table. Don't worry, creating those object instances is rather quick.


.. _database-query-builder-select:

select() and addSelect()
========================

Create a `SELECT` query.

Select all fields::


   // SELECT *
   $queryBuilder->select('*')


:php:`->select()` and a number of other methods of the `QueryBuilder` are `variadic <https://en.wikipedia.org/wiki/Variadic_function>`__
and can handle any number of arguments. For :php:`->select()`, every argument is interpreted as a single field name to select::

   // SELECT `uid`, `pid`, `aField`
   $queryBuilder->select('uid', 'pid', 'aField');


Argument unpacking can be used if the list of fields is available as array already::

   $fields = ['uid', 'pid', 'aField', 'anotherField'];
   $queryBuilder->select(...$fields);


:php:`->select()` supports `AS` and quotes identifiers automatically. This can become especially handy in join() operations::

   // SELECT `tt_content`.`bodytext` AS `t1`.`text`
   $queryBuilder->select('tt_content.bodytext AS t1.text')


:php:`->select()` sets the list of fields that should be selected and :php:`->addSelect()` can add further items
to an existing list.

Mind that :php:`->select()` *replaces* any formerly registered list instead of appending. Thus, it usually doesn't
make much sense to call :php:`select()` twice in a code flow, or to call it *after* an :php:`->addSelect()`. The methods
:php:`->where()` and :php:`->andWhere()` share the same behavior: :php:`->where()` replaces all formerly registered
constraints, :php:`->andWhere()` appends additional constraints.

A useful combination of :php:`->select()` and :php:`->addSelect()` can be::

   $queryBuilder->select(...$defaultList);
   if ($needAdditionalFields) {
      $queryBuilder->addSelect(...$additionalFields);
   }

Calling :php:`->execute()` on a :php:`->select()` query returns a `Statement` object. To receive single rows a :php:`->fetch()`
loop on that object is used, or :php:`->fetchAll()` to return a single array with all rows. A typical code flow
of a `SELECT` query looks like::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $statement = $queryBuilder
      ->select('uid', 'header', 'bodytext')
      ->from('tt_content')
      ->where(
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus'))
      )
      ->execute();
   while ($row = $statement->fetch()) {
      // Do something with that single row
      debug($row);
   }

.. _database-query-builder-select-restrictions:

Default Restrictions
--------------------

.. note::

   `->select()` and `->count()` queries trigger TYPO3 CMS magic that adds further default where
   clauses if the queried table is also registered via `$GLOBALS['TCA']`. See the
   :ref:`RestrictionBuilder <database-restriction-builder>` section for details on that topic.


count()
=======

Create a `COUNT` query, a typical usage::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT COUNT(`uid`) FROM `tt_content` WHERE (`bodytext` = 'klaus')
   //     AND ((`tt_content`.`deleted` = 0) AND (`tt_content`.`hidden` = 0)
   //     AND (`tt_content`.`starttime` <= 1475580240)
   //     AND ((`tt_content`.`endtime` = 0) OR (`tt_content`.`endtime` > 1475580240)))
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $count = $queryBuilder
      ->count('uid')
      ->from('tt_content')
      ->where(
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus'))
       )
      ->execute()
      ->fetchColumn(0);


Remarks:

* Similar to the :php:`->select()` query type, :php:`->count()` automatically triggers `RestrictionBuilder` magic
  that adds default `deleted`, `hidden`, `starttime` and `endtime` restrictions if that is
  defined in `TCA`.

* Similar to :php:`->select()` query types, :php:`->execute()` with :php:`->count()` returns a `Statement` object. To
  fetch the number of rows directly, use :php:`->fetchColumn(0)`.

* First argument to :php:`->count()` is required, typically :php:`->count(*)` or :php:`->count('uid')` is used, the field
  name is automatically quoted.

* There is no support for `DISTINCT`, a :php:`->groupBy()` has to be used instead.

* If combining :php:`->count()` with a :php:`->groupBy()`, the result may return multiple rows. The order of
  those rows depends on the used `DBMS`. To ensure same order of result rows on multiple different databases,
  a :php:`->groupBy()` should thus always be combined with a :php:`->orderBy()`.


delete()
========

Create a `DELETE FROM` query. The method requires the table name to drop data from. Classic usage::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // DELETE FROM `tt_content` WHERE `bodytext` = 'klaus'
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $affectedRows = $queryBuilder
      ->delete('tt_content')
      ->where(
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus'))
      )
      ->execute();


Remarks:

* For simple cases, it is often easier to write and read if using the :php:`->delete()` method of the
  `Connection` object.

* In contrast to :php:`->select()`, :php:`->delete()` does *not* add `WHERE` restrictions like ``AND `deleted` = 0``
  automatically.

* :php:`->delete()` does *not* magically transform a ``DELETE FROM `tt_content` WHERE `uid` = 4711`` to something like
  ``UPDATE `tt_content` SET `deleted` = 1 WHERE `uid` = 4711`` internally. A soft-delete must be handled on application
  level code with a dedicated lookup in :php:`$GLOBALS['TCA']['theTable']['ctrl']['deleted']` to check if
  a specific table can handle the soft-delete, together with an :php:`->update()` instead.

* Multi-table delete is *not* supported: ``DELETE FROM `table1`, `table2``` can not be created.

* :php:`->delete()` ignores :php:`->join()`

* :php:`->delete()` ignores :php:`setMaxResults()`: `DELETE` with `LIMIT` does not work.


.. _database-query-builder-update-set:

update() and set()
==================

Create an `UPDATE` query. Typical usage::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // UPDATE `tt_content` SET `bodytext` = 'peter' WHERE `bodytext` = 'klaus'

   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder
      ->update('tt_content')
      ->where(
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus'))
      )
      ->set('bodytext', 'peter')
      ->execute();


:php:`->update()` requires the table to update as first argument and a table alias (e.g. 't') as optional second argument.
The table alias can then be used in :php:`->set()` and :php:`->where()` expressions::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // UPDATE `tt_content` `t` SET `t`.`bodytext` = 'peter' WHERE `t`.`bodytext` = 'klaus'
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder
      ->update('tt_content', 't')
      ->where(
         $queryBuilder->expr()->eq('t.bodytext', $queryBuilder->createNamedParameter('klaus'))
      )
      ->set('t.bodytext', 'peter')
      ->execute();

:php:`->set()` requires a field name as first argument and automatically quotes it internally. The second mandatory
argument is the value a field should be set to, **the value is automatically transformed to a named parameter
of a prepared statement**. This way, :php:`->set()` key/value pairs are **automatically SQL injection safe by default**.

If a field should be set to the value of another field from the row, the quoting needs to be turned off and
:php:`->quoteIdentifier()` and :php:`false` have to be used::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // UPDATE `tt_content` SET `bodytext` = `header` WHERE `bodytext` = 'klaus'
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder
      ->update('tt_content')
      ->where(
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus'))
      )
      ->set('bodytext', $queryBuilder->quoteIdentifier('header'), false)
      ->execute();

Remarks:

* For simple cases, it is often easier to use the :php:`->update()` method of the
  `Connection` object.

* :php:`->set()` can be called multiple times if multiple fields should be updated.

* :php:`->set()` requires a field name as first argument and automatically quotes it internally.

* :php:`->set()` requires the value a field should be set to as second parameter.

* :php:`->update()` ignores :php:`->join()` and :php:`->setMaxResults()`.

* The API does not magically add `deleted = 0` or other restrictions as is currently done
  for example on :ref:`select <database-query-builder-select-restrictions>`.
  (See also :ref:`RestrictionBuilder <database-restriction-builder>`).


insert() and values()
=====================

Create an `INSERT` query. Typical usage::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $affectedRows = $queryBuilder
      ->insert('tt_content')
      ->values([
         'bodytext' => 'klaus',
         'header' => 'peter',
      ])
      ->execute();


Remarks:

* It is often easier to use :php:`->insert()` or :php:`->bulkInsert()` of the `Connection` object.

* :php:`->values()` expects an array of key/value pairs. Both keys (field names / identifiers) and values are
  automatically quoted. In rare cases, quoting of values can be turned off by setting the second argument
  to :php:`false`. In those cases the quoting has to be done manually, typically by using :php:`->createNamedParameter()`
  on the values, use with care ...

* :php:`->execute()` after :php:`->insert()` returns the number of inserted rows, which is typically `1`.

* `QueryBuilder` does not contain a method to insert multiple rows at once, use :php:`->bulkInsert()` of `Connection`
  object instead to achieve that.


from()
======

:php:`->from()` is a must have call for :php:`->select()` and :php:`->count()` query types.
:php:`->from()` needs a table name and an optional alias name. The method is typically called once per query build
and the table name is typically the same as what was given to :php:`->getQueryBuilderForTable()`. If the query joins
multiple tables, the argument should be the name of the first table within the :php:`->join()` chain::

   // FROM `myTable`
   $queryBuilder->from('myTable');

   // FROM `myTable` AS `anAlias`
   $queryBuilder->from('myTable', 'anAlias');


:php:`->from()` can be called multiple times and will create the cartesian product of
tables if not restricted by an according :php:`->where()` or :php:`->andWhere()` expression. In general,
it is a good idea to use :php:`->from()` only once per query and model multi-table selection
with an explicit :php:`->join()` instead.


where(), andWhere() and orWhere()
=================================

The three methods are used to create `WHERE` restrictions for `SELECT`, `COUNT`, `UPDATE` and `DELETE` query types.
Each argument is typically an `ExpressionBuilder` object that will be cast to a string on :php:`->execute()`::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT `uid`, `header`, `bodytext`
   // FROM `tt_content`
   // WHERE
   //    (
   //       ((`bodytext` = 'klaus') AND (`header` = 'a name'))
   //       OR (`bodytext` = 'peter') OR (`bodytext` = 'hans')
   //    )
   //    AND (`pid` = 42)
   //    AND ... RestrictionBuilder TCA restrictions ...
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $statement = $queryBuilder
      ->select('uid', 'header', 'bodytext')
      ->from('tt_content')
      ->where(
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus')),
         $queryBuilder->expr()->eq('header', $queryBuilder->createNamedParameter('a name'))
      )
      ->orWhere(
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('peter')),
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('hans'))
      )
      ->andWhere(
         $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT))
      )
      ->execute();

Note the parenthesis of the above example: :php:`->andWhere()` encapsulates both :php:`->where()` and :php:`->orWhere()`
with an additional restriction.

Argument unpacking can become handy with these methods::

   $whereExpressions = [
      $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus')),
      $queryBuilder->expr()->eq('header', $queryBuilder->createNamedParameter('a name'))
   ];
   if ($needsAdditionalExpression) {
      $whereExpressions[] = $someAdditionalExpression;
   }
   $queryBuilder->where(...$whereExpressions);


Remarks:

* The three methods are `variadic <https://en.wikipedia.org/wiki/Variadic_function>`__. They can handle
  any number of arguments. If for instance :php:`->where()` receives four arguments, they are handled as single
  expressions, all of them combined with `AND`.

* :ref:`createNamedParameter <database-query-builder-create-named-parameter>`
  is used to create a placeholder for a prepared statement field value.
  **Always** use that when dealing with user input in expressions to make
  the statement SQL injection safe.

* :php:`->where()` should be called only once per query and it resets any previously set :php:`->where()`, :php:`->andWhere()`
  and :php:`->orWhere()` expression. Having a :php:`->where()` call after a previous :php:`->where()`, :php:`->andWhere()` or :php:`->orWhere()`
  typically indicates a bug or a rather weird code flow. Doing so is discouraged.

* While creating complex `WHERE` restrictions, :php:`->getSQL()` and :php:`->getParameters()` are helpful debugging friends to verify parenthesis and single query parts.

* If using only :php:`->eq()` expressions, it is often easier to switch to the according `Connection` object method
  to simplify quoting and increase readability.

* It is possible to feed the methods with strings directly, but that is discouraged and typically only used
  in rare cases where expression strings are created at a different place that can not be resolved easily. In
  the core, those places are usually combined with :php:`QueryHelper::stripLogicalOperatorPrefix()` to remove leading
  `AND` or `OR` parts. Using this gives an additional risk of missing or wrong quoting and is a potential security
  issue. Use with care if ever.


join(), innerJoin(), rightJoin() and leftJoin()
===============================================

Joining multiple tables in a :php:`->select()` or :php:`->count()` query is done with one of these methods. Multiple joins
are supported by calling the methods more than once. All methods require four arguments: The name of the left side
table (or its alias), the name of the right side table, an alias for the right side table name and the join
restriction as fourth argument::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT `sys_language`.`uid`, `sys_language`.`title`
   // FROM `sys_language`
   // INNER JOIN `pages` `p`
   //     ON `p`.`sys_language_uid` = `sys_language`.`uid`
   // WHERE
   //     (`p`.`uid` = 42)
   //     AND (
   //          (`p`.`deleted` = 0)
   //          AND (
   //              (`sys_language`.`hidden` = 0) AND (`overlay`.`hidden` = 0)
   //          )
   //          AND (`p`.`starttime` <= 1475591280)
   //          AND ((`p`.`endtime` = 0) OR (`overlay`.`endtime` > 1475591280))
   //     )
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_language');
   $statement = $queryBuilder
      ->select('sys_language.uid', 'sys_language.title')
      ->from('sys_language')
      ->join(
         'sys_language',
         'pages',
         'p',
         $queryBuilder->expr()->eq('p.sys_language_uid', $queryBuilder->quoteIdentifier('sys_language.uid'))
      )
      ->where(
         $queryBuilder->expr()->eq('p.uid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT))
      )
      ->execute();


Notes to the above example:

* The query operates on table `sys_language` as main table, this table name is given to :php:`getQueryBuilderForTable()`.

* The query joins table `pages` as `INNER JOIN`, giving it the alias `p`.

* The join condition is ```p`.`sys_language_uid` = `sys_language`.`uid```. It would have been identical to
  swap the expression arguments of the fourth `->join()` argument
  :php:`->eq('sys_language.uid', $queryBuilder->quoteIdentifier('p.sys_language_uid'))`.

* The second argument of the join expression instructs the `ExpressionBuilder` to quote the value as a field
  identifier (a field name, here a table/field name combination). Using :php:`createNamedParameter()` would lead to
  a quoting as value (`'` instead of ````` in `mysql`) and the query would fail.

* The alias `p` - the third argument of the :php:`->join()` call - does not necessarily have to be set to a different
  name than the table name itself here. Using `pages` as third argument and not specifying
  a different name would do. Aliases are mostly useful if a join to the same table is needed:
  ``SELECT `something` FROM `tt_content` JOIN `tt_content` `content2` ON ...``. Aliases additionally become handy
  to increase readability of `->where()` expressions.

* The `RestrictionBuilder` added additional `WHERE` conditions for both involved tables! Table `sys_language` obviously
  only specifies a `'disabled' => 'hidden'` as `enableColumns` in its `TCA` `ctrl` section, while table
  `pages` specifies `deleted`, `hidden`, `starttime` and `stoptime` fields.


A more complex example with two joins. The first join points to the first table again using an alias to resolve
a language overlay scenario. The second join uses the alias name of the first join target as left side::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT `tt_content_orig`.`sys_language_uid`
   // FROM `tt_content`
   // INNER JOIN `tt_content` `tt_content_orig` ON `tt_content`.`t3_origuid` = `tt_content_orig`.`uid`
   // INNER JOIN `sys_language` `sys_language` ON `tt_content_orig`.`sys_language_uid` = `sys_language`.`uid`
   // WHERE
   //     (`tt_content`.`colPos` = 1)
   //     AND (`tt_content`.`pid` = 42)
   //     AND (`tt_content`.`sys_language_uid` = 2)
   //     AND ... RestrictionBuilder TCA restrictions for tables tt_content and sys_language ...
   // GROUP BY `tt_content_orig`.`sys_language_uid`
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $constraints = [
      $queryBuilder->expr()->eq('tt_content.colPos', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT)),
      $queryBuilder->expr()->eq('tt_content.pid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT)),
      $queryBuilder->expr()->eq('tt_content.sys_language_uid', $queryBuilder->createNamedParameter(2, \PDO::PARAM_INT)),
   ];
   $queryBuilder
      ->select('tt_content_orig.sys_language_uid')
      ->from('tt_content')
      ->join(
         'tt_content',
         'tt_content',
         'tt_content_orig',
         $queryBuilder->expr()->eq(
            'tt_content.t3_origuid',
            $queryBuilder->quoteIdentifier('tt_content_orig.uid')
         )
      )
      ->join(
         'tt_content_orig',
         'sys_language',
         'sys_language',
         $queryBuilder->expr()->eq(
            'tt_content_orig.sys_language_uid',
            $queryBuilder->quoteIdentifier('sys_language.uid')
         )
      )
      ->where(...$constraints)
      ->groupBy('tt_content_orig.sys_language_uid')
      ->execute();


Further remarks:

* :php:`->join()` and `innerJoin` are identical. They create an `INNER JOIN` query, this is identical to a `JOIN` query.

* :php:`->leftJoin()` creates a `LEFT JOIN` query, this is identical to a `LEFT OUTER JOIN` query.

* :php:`->rightJoin()` creates a `RIGHT JOIN` query, this is identical to a `RIGT OUTER JOIN` query.

* Calls on join() methods are only considered for :php:`->select()` and :php:`->count()` type queries. :php:`->delete()`, :php:`->insert()`
  and :php:`update()` do not support joins, those query parts are ignored and do not end up in the final statement.

* The argument of :php:`->getQueryBuilderForTable()` should be the left most main table.

* A join of two tables that are configured to different connections will throw an exception. This restricts which
  tables can be configured to different database endpoints. It is possible to test the connection objects of involved
  tables for equality and implement a fallback logic in `PHP` if they are different.


orderBy() and addOrderBy()
==========================

Add `ORDER BY` to a :php:`->select()` statement. Both :php:`->orderBy()` and :php:`->addOrderBy()` require a field name as first
argument::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT * FROM `sys_language` ORDER BY `sorting` ASC
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_language');
   $queryBuilder->getRestrictions()->removeAll();
   $languageRecords = $queryBuilder
      ->select('*')
      ->from('sys_language')
      ->orderBy('sorting')
      ->execute()
      ->fetchAll();


Remarks:

* :php:`->orderBy()` resets any previously specified orders. It doesn't make sense to call it after a previous :php:`->orderBy()`
  or :php:`->addOrderBy()` again.

* Both methods need a field name or a `table.fieldName` or a `tableAlias.fieldName` as first argument, in the above
  example calling :php:`->orderBy('sys_language.sorting')` would have been identical. All identifiers are quoted
  automatically.

* The second, optional argument of both methods specifies the sorting order. The two allowed values are `'ASC'` and `'DESC'`
  where `'ASC'` is default and can be omited.

* To create a chain of orders, use :php:`->orderBy()` and then multiple :php:`->addOrderBy()` calls. Calling
  :php:`->orderBy('header')->addOrderBy('bodytext')->addOrderBy('uid', 'DESC')` creates
  ``ORDER BY `header` ASC, `bodytext` ASC, `uid` DESC``

* To add more complex sorting, you can use :php:`->add('orderBy', 'FIELD(eventtype, 0, 4, 1, 2, 3)', true)`,
  remember to quote properly


groupBy() and addGroupBy()
==========================

Add `GROUP BY` to a :php:`->select()` statement. Each argument to the methods is a single identifier::

   // GROUP BY `pages`.`sys_language_uid`, `sys_language`.`uid`
   ->groupBy('pages.sys_language_uid', 'sys_language.uid');

Remarks:

* Similar to :php:`->select()` and :php:`->where()` both methods are variadic and take any number of arguments, argument
  unpacking is supported: :php:`->groupBy(...$myGroupArray)`

* Each argument is either a direct field name ``GROUP BY `bodytext```, a `table.fieldName` or a `tableAlias.fieldName`
  and will be properly quoted.

* :php:`->groupBy()` resets any previously set group specification and should be called only once per statement.

* For more complex statements you can use :php:`->add('groupBy', $sql, $append)`, remember to quote properly.


setMaxResults() and setFirstResult()
====================================

Add `LIMIT` to restrict number of records and `OFFSET` for pagination query parts. Both methods should be
called only once per statement::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT * FROM `sys_language` LIMIT 2 OFFSET 4
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_language');
   $queryBuilder
      ->select('*')
      ->from('sys_language')
      ->setMaxResults(2)
      ->setFirstResult(4)
      ->execute();

Remarks:

* It's allowed to call :php:`->setMaxResults()` but not to call :php:`->setFirstResult()`.

* It is possible to call :php:`->setFirstResult()` without calling :php:`setMaxResults()`: This equals to "Fetch everything, but
  leave out the first n records". Internally, `LIMIT` will be added by `doctrine-dbal` and set to a very high value.


.. _database-query-builder-add:

add()
=====

Method :php:`->add()` appends to or replaces a single, generic query part. It can be used as a low level call
if more specific calls don't give enough freedom to express parts of statments::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_language');
   $queryBuilder->select('*')->from('sys_language');
   $queryBuilder->add('orderBy', 'FIELD(eventtype, 0, 4, 1, 2, 3)');


Remarks:

* The first argument is the sql part. One of: `select`, `from`, `set`, `where`, `groupBy`, `having` or `orderBy`

* Second argument is the (properly quoted!) sql segment of this part

* Optional third boolean argument specifies if the sql fragment should be appended (true) or substitute
  an possibly existing sql part of this name (false, default).


.. _database-query-builder-get-sql:

getSQL()
========

Method :php:`->getSQL()` returns the created query statement as string. It is incredibly useful during development
to verify the final statement is executed just as a developer expects it::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_language');
   $queryBuilder->select('*')->from('sys_language');
   debug($queryBuilder->getSQL());
   $statement = $queryBuilder->execute();


Remarks:

* This is debugging code. Take proper actions to ensure those calls do not end up in production!

* The method is typically called directly before :php:`->execute()` to output the final statement.

* Casting a QueryBuilder object to :php:`(string)` has the same effect as calling :php:`->getSQL()`, the explicit call
  using the method should be preferred to simplify a search operation for this kind of debugging statements, though.

* The method is a simple way to see which restrictions the `RestrictionBuilder` added.

* `doctrine-dbal` always creates prepared statements: Any value that is added via :php:`->createNamedParameter()` creates
  a placeholder that is later substituted when the real query is fired via :php:`->execute()`. :php:`->getSQL()` does not show
  those values, instead the placeholder names are displayed, usually with a string like `:dcValue1`. There is no
  simple solution to show the fully replaced query from within the framework, but you can go for :php:`->getParameters()` to see the 
  array of parameters used to replace these placeholders within the query. In the frontend, the queries and parameters are shown 
  in the admin panel.


getParameters()
===============

Method :php:`->getParameters()` returns the values for the prepared statement placeholders in an array. It is incredibly useful during development to verify the final statement is executed just as a developer expects it::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_language');
   $queryBuilder->select('*')->from('sys_language');
   debug($queryBuilder->getParameters());
   $statement = $queryBuilder->execute();


Remarks:

* This is debugging code. Take proper actions to ensure those calls do not end up in production!

* The method is typically called directly before :php:`->execute()` to output the final values for the statement.

* `doctrine-dbal` always creates prepared statements: Any value that added via :php:`->createNamedParameter()` creates
  a placeholder that is later substituted when the real query is fired via :php:`->execute()`. :php:`->getparameters()` does not show
  the statement or those placeholders, instead the values are displayed, usually within an array using keys like `:dcValue1`. There is no simple solution to show the fully replaced query from within the framework, but you can go for :php:`->getSQL()` to see the string with placeholders used as a prepared statement.


execute()
=========

Compile and fire the final query statement. This is usually the last call on a `QueryBuilder` object. The method
has two possible return values: On success, it either returns a `Statement` object representing the result set of
`->select()` and `->count()` queries, or it returns an integer representing the number of affected rows for
`->insert()`, `->update()` and `->delete()` queries.

If the query fails for whatever reason (for instance if the database connection was lost or if the query contains a
syntax error), a `\Doctrine\DBAL\DBALException` is thrown. It is most often bad habit to catch and suppress this
exception since it indicates a runtime or a program error. Both should bubble up. See the
:ref:`coding guidelines <cgl-working-with-exceptions>`
for more information on proper exception handling.


expr()
======

Return an instance of the `ExpressionBuilder`. This object is used to create complex `WHERE` query parts and `JOIN`
expressions::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT `uid` FROM `tt_content` WHERE (`uid` > 42)
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder
      ->select('uid')
      ->from('tt_content')
      ->where(
         $queryBuilder->expr()->gt('uid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT))
      )
      ->execute();

Remarks:

* This object is stateless and can be called and worked on as often as needed. It however bound to the specific
  connection a statement is created for and is thus only available through the `QueryBuilder` which is specific for
  one connection, too.

* Never re-use the `ExpressionBuilder`, especially not between multiple `QueryBuilder` objects, always get an
  instance of the `ExpressionBuilder` by calling :php:`->expr()`.


.. _database-query-builder-create-named-parameter:

createNamedParameter()
======================

Create a placeholder for a prepared statement field value. **Always** use that when dealing with user input in
expressions to make the statement SQL injection safe::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // SELECT * FROM `tt_content` WHERE (`bodytext` = 'kl\'aus')
   $searchWord = "kl'aus"; // $searchWord = GeneralUtility::_GP('searchword');
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder->getRestrictions()->removeAll();
   $queryBuilder
      ->select('uid')
      ->from('tt_content')
      ->where(
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter($searchWord))
      )
      ->execute();

The above example shows the importance of using :php:`->createNamedParameter()`: The search word ``kl'aus`` is "tainted"
and would break the query if not channeled through :php:`->createNamedParameter()` which quotes the backtick and makes
the value SQL injection safe.

Not convinced? Suppose the code would look like this::

   // NEVER EVER DO THIS!
   $_POST['searchword'] = "'foo' UNION SELECT username FROM be_users";
   $searchWord = GeneralUtility::_GP('searchword');
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder->getRestrictions()->removeAll();
      this fails with syntax error to prevent copy and paste
   $queryBuilder
      ->select('uid')
      ->from('tt_content')
      ->where(
         // MASSIVE SECURITY ISSUE DEMONSTRATED HERE, USE ->createNamedParameter() ON $searchWord!
         $queryBuilder->expr()->eq('bodytext', $searchWord)
       );

Mind the missing :php:`->createNamedParameter()` in the :php:`->eq()` expression on given value! This code would happily execute
the statement ``SELECT uid FROM `tt_content` WHERE `bodytext` = 'foo' UNION SELECT username FROM be_users;`` returning
a list of backend user names!


.. note::

   :php:`->set()` automatically transforms the second mandatory parameter into a named parameter of a prepared statement.
   Wrapping the second parameter in a :php:`->createNamedParameter()` call will result in an error upon execution. This
   behaviour can be disabled by passing :php:`false` as a third parameter to :php:`->set()`.

More examples
-------------

Use integer, integer array::

    // use TYPO3\CMS\Core\Utility\GeneralUtility;
    // use TYPO3\CMS\Core\Database\ConnectionPool;
    // use TYPO3\CMS\Core\Database\Connection;
    // SELECT * FROM `tt_content`
    //     WHERE `bodytext` = 'kl\'aus'
    //     AND   sys_language_uid = 0
    //     AND   pid in (2, 42,13333)
    $searchWord = "kl'aus"; // $searchWord = GeneralUtility::_GP('searchword');
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
    $queryBuilder->getRestrictions()->removeAll();
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter($searchWord)),
            $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter($language, \PDO::PARAM_INT)),
            $queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter($pageIds, Connection::PARAM_INT_ARRAY))
        )
        ->execute();



Rules:
------

* **Always** use :php:`->createNamedParameter()` around **any** input, no matter where it comes from.

* The second argument of :php:`->expr()` is **always** either a call to :php:`->createNamedParameter()` or :php:`->quoteIdentifier()`.

* The second argument of :php:`->createNamedParameter()` specifies the type of input. For string, this can be omitted,
  but it is good practice to add `\PDO::PARAM_INT` for integers or similar for other field types. This is currently
  no strict rule, but following this will reduces headaches in the future, especially for `DBMS` that are not as
  relaxed as `mysql` when it comes to field types. The \PDO constants can be used for simple types like `bool`, `string`,
  `null`, `lob` and `integer`. Additionally, the two constants `Connection::PARAM_INT_ARRAY` and `Connection::PARAM_STR_ARRAY`
  can be used if an array of strings or integers is handled, for instance in an `IN()` expression.

* Keep the :php:`->createNamedParameter()` as close as possible to the expression. Do not structure your code in a way
  that it first quotes something and only later stuffs the already prepared names into the expression. Having
  :php:`->createNamedParameter()` directly within the created expression is much less error prone and easier to review.
  This is a general rule: Sanitizing input must be as close as possible to the "sink" where a value is submitted
  to a lower part of the framework. This paradigm should be followed for other quote operations like :php:`htmlspecialchars()`
  or :php:`GeneralUtility::quoteJSvalue()`, too. Sanitizing should be directly obvious at the very place where it is
  important::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // DO
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder->getRestrictions()->removeAll();
   $queryBuilder
      ->select('uid')
      ->from('tt_content')
      ->where(
          $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter($searchWord))
      )

   // DON'T DO, this is much harder to track:
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $myValue = $queryBuilder->createNamedParameter($searchWord);
   // Imagine much more code here
   $queryBuilder->getRestrictions()->removeAll();
   $queryBuilder
      ->select('uid')
      ->from('tt_content')
      ->where(
          $queryBuilder->expr()->eq('bodytext', $myValue)
      )


.. _database-query-builder-quote-identifier:

quoteIdentifier() and quoteIdentifiers()
========================================

:php:`->quoteIdentifier()` must be used if not a value is handled, but a field name. The quoting is different in those
cases and typically ends up with backticks ````` instead of ticks ``'``::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Connection;
   // SELECT `uid` FROM `tt_content` WHERE (`header` = `bodytext`)
   // Return list of rows where header and bodytext values are identical
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder
      ->select('uid')
      ->from('tt_content')
      ->where(
         $queryBuilder->expr()->eq('header', $queryBuilder->quoteIdentifier('bodytext'))
      );


The method quotes single field names or combinations of table names or table aliases with field names::

   // Single field name: `bodytext`
   ->quoteIdentifier('bodytext');
   // Table name and field name: `tt_content`.`bodytext`
   ->quoteIdentifier('tt_content.bodytext')
   // Table alias and field name: `foo`.`bodytext`
   ->from('tt_content', 'foo')->quoteIdentifier('foo.bodytext')

Remarks:

* Similar to :ref:`->createNamedParameter() <database-query-builder-create-named-parameter>` this method is
  crucial to prevent SQL injections. The same rules apply here.

* Method :ref:`->set() <database-query-builder-update-set>` for `UPDATE` statements expects their second argument
  to be a field value by default and quotes them using :php:`->createNamedParameter()` internally. In case a field should
  be set to the value of another field, this quoting can be turned off and an explicit call to :php:`->quoteIdentifier()`
  must be added.

* Internally, :php:`->quoteIdentifier()` is automatically called on all method arguments that must be a field name. For
  instance, :php:`->quoteIdentifier()` is called on all arguments given to :ref:`->select() <database-query-builder-select>`.

* :php:`->quoteIdentifiers()` (mind the plural) can be used to quote multiple field names at once. While that method is
  'public` and thus exposed as `API` method, this is mostly useful internally only.


.. _database-query-builder-escape-like-wildcards:

escapeLikeWildcards()
=====================

Helper method to quote `%` characters within a search string. This is helpful in :php:`->like()` and :php:`->notLike()`
expressions::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Connection;
   // SELECT `uid` FROM `tt_content` WHERE (`bodytext` LIKE '%kl\\%aus%')
   $searchWord = 'kl%aus';
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder
      ->select('uid')
      ->from('tt_content')
      ->where(
         $queryBuilder->expr()->like(
            'bodytext',
            $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($searchWord) . '%')
         )
      );


.. warning::

   Even with using :php:`->escapeLikeWildcards()`, the value must again be encapsulated in a
   :php:`->createNamedParameter()` call. Only calling :php:`->escapeLikeWildcards()` does **not** make the value
   SQL injection safe!


getRestrictions(), setRestrictions(), resetRestrictions()
=========================================================

`API` methods to deal with the :ref:`RestrictionBuilder <database-restriction-builder>`.
