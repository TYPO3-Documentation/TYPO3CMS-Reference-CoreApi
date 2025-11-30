..  include:: /Includes.rst.txt

..  _database-query-builder:

=============
Query builder
=============

..  contents:: Table of Contents
    :depth: 1
    :local:

The query builder provides a set of methods to create queries
programmatically.

This chapter provides examples of the most common queries.

..  warning::
    From a security point of view, the documentation of
    :ref:`->createNamedParameter() <database-query-builder-create-named-parameter>`
    and :ref:`->quoteIdentifier() <database-query-builder-quote-identifier>` are
    an absolute **must read and follow** section. Make very sure you understand
    this and use it for **each and every query** to prevent SQL
    injections!


The query builder comes with a happy little list of small methods:

*   Set type of query: :php:`->select()`, :php:`->count()`, :php:`->update()`,
    :php:`->insert()` and :php:`->delete()`

*   Prepare :sql:`WHERE` conditions

*   Manipulate default :sql:`WHERE` restrictions added by TYPO3 for
    :php:`->select()`

*   Add :sql:`LIMIT`, :sql:`GROUP BY` and other SQL functions

*   :php:`executeQuery()` executes a :sql:`SELECT` query and returns a result,
    a :php:`\Doctrine\DBAL\Result` object

*   :php:`executeStatement()` executes an :sql:`INSERT`, :sql:`UPDATE` or
    :sql:`DELETE` statement and returns the number of affected rows.


Most of the query builder methods provide a fluent interface, return
an instance of the current query builder itself, and can be chained:

..  code-block:: php

    $queryBuilder
        ->select('uid')
        ->from('pages');


..  _database-query-builder-instantiation:

Instantiation
=============

To create an instance of the query builder, call
:php:`ConnectionPool::getQueryBuilderForTable()` and pass the table as an
argument. The :ref:`ConnectionPool <database-connection-pool>` object can be
injected via :ref:`dependency injection <DependencyInjection>`.

..  literalinclude:: _MyRepository.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

..  attention::
    Never instantiate and initialize the query builder manually using
    dependency injection or :php:`GeneralUtility::makeInstance()`, otherwise you
    will miss essential dependencies and runtime setup.

..  warning::
    The QueryBuilder holds internal state and must not be reused for
    different queries. In addition, a reuse comes with a
    `significant performance penalty and memory consumption`_.
    **Use one query builder per query.** Get a fresh one by calling
    :php:`$connection->createQueryBuilder()` if the same table is
    involved, or use :php:`$connectionPool->getQueryBuilderForTable()` for a
    query to a different table. Do not worry, creating those object instances
    is quite fast.

..  _significant performance penalty and memory consumption: https://www.derhansen.de/2023/10/the-pitfalls-of-reusing-typo3-querybuilder-analyzing-a-performance-bottleneck.html

..  _database-query-builder-select:

select() and addSelect()
========================

Create a :sql:`SELECT` query.

Select all fields:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // SELECT *
    $queryBuilder->select('*')


:php:`->select()` and a number of other methods of the query builder
are `variadic <https://en.wikipedia.org/wiki/Variadic_function>`__
and can handle any number of arguments. In :php:`->select()` each argument
is interpreted as a single field name to be selected:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // SELECT `uid`, `pid`, `aField`
    $queryBuilder->select('uid', 'pid', 'aField');

Argument unpacking can be used if the list of fields already is available as
array:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // SELECT `uid`, `pid`, `aField`, `anotherField`
    $fields = ['uid', 'pid', 'aField', 'anotherField'];
    $queryBuilder->select(...$fields);


:php:`->select()` automatically supports :sql:`AS` and quotes identifiers. This
can be especially useful for :php:`join()` operations:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // SELECT `tt_content`.`bodytext` AS `t1`.`text`
    $queryBuilder->select('tt_content.bodytext AS t1.text')


With :php:`->select()` the list of fields to be selected is specified, and with
:php:`->addSelect()` further elements can be added to an existing list.

Mind that :php:`->select()` **replaces** any formerly registered list instead of
appending it. Thus, it is not very useful to call :php:`select()` twice in a
code flow or **after** an :php:`->addSelect()`. The methods :php:`->where()` and
:php:`->andWhere()` share the same behavior: :php:`->where()` replaces all
formerly registered constraints, :php:`->andWhere()` appends additional
constraints.

A useful combination of :php:`->select()` and :php:`->addSelect()` can be:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    $queryBuilder->select(...$defaultList);
    if ($needAdditionalFields) {
        $queryBuilder->addSelect(...$additionalFields);
    }

Calling the :php:`executeQuery()` function on a :php:`->select()` query returns
a result object of type :php:`\Doctrine\DBAL\Result`. To receive single rows, a
:php:`->fetchAssociative()` loop is used on that object, or
:php:`->fetchAllAssociative()` to return a single array with all rows. A typical
code flow of a :sql:`SELECT` query looks like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $result = $queryBuilder
        ->select('uid', 'header', 'bodytext')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('lorem', Connection::PARAM_STR))
        )
        ->executeQuery();

    while ($row = $result->fetchAssociative()) {
        // Do something with that single row
        debug($row);
    }

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

..  _database-query-builder-select-restrictions:
..  _database-query-builder-default-restrictions:

Default Restrictions
--------------------

..  note::
    :php:`->select()` and :php:`->count()` queries trigger TYPO3 magic that adds
    default :php:`where` clauses to queries if they are defined as
    :ref:`enableColumns <t3tca:ctrl-enablecolumns>` in the table's TCA ctrl section.
    See the :ref:`RestrictionBuilder <database-restriction-builder>` section for
    further details.

..  _database-query-builder-count:

count()
=======

Create a :sql:`COUNT` query. Typical usage:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    // SELECT COUNT(`uid`) FROM `tt_content` WHERE (`bodytext` = 'lorem')
    //     AND ((`tt_content`.`deleted` = 0) AND (`tt_content`.`hidden` = 0)
    //     AND (`tt_content`.`starttime` <= 1669885410)
    //     AND ((`tt_content`.`endtime` = 0) OR (`tt_content`.`endtime` > 1669885410)))
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $count = $queryBuilder
        ->count('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('lorem', Connection::PARAM_STR))
        )
        ->executeQuery()
        ->fetchOne();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

Remarks:

*   see :ref:`Default Restrictions <database-query-builder-default-restrictions>`

*   Similar to the :php:`->select()` query type, :php:`->count()`
    triggers :ref:`RestrictionBuilder <database-restriction-builder>`
    magic that adds default restrictions such as
    :sql:`deleted`, :sql:`hidden`, :sql:`starttime` and :sql:`endtime` if
    they are defined in the TCA.

*   Similar to :php:`->select()` query types, :php:`->executeQuery()` with
    :php:`->count()` returns a result object of type :php:`\Doctrine\DBAL\Result`.
    To fetch the number of rows directly, use :php:`->fetchOne()`, which
    returns a numeric value of the first column of the resulting row.

*   The first argument to :php:`->count()` is required, typically
    :php:`->count(*)` or :php:`->count('uid')` is used, the field name is
    automatically quoted.

*   There is no support for :sql:`DISTINCT`, instead a :php:`->groupBy()` has to
    be used, for example:

    ..  code-block:: php

        // Equivalent to:
        // SELECT DISTINCT some_field, another_field FROM my_table

        $queryBuilder
            ->select('some_field', 'another_field')
            ->from('my_table')
            ->groupBy('some_field')
            ->addGroupBy('another_field');

*   If :php:`->count()` is combined with :php:`->groupBy()`, the result may
    return multiple rows. The order of those rows depends on the used
    :abbr:`DBMS (Database management system)`. Therefore, to ensure the same
    order of result rows on multiple different databases, a :php:`->groupBy()`
    should always be combined with an :php:`->orderBy()`.

.. _database-query-builder-delete:

delete()
========

Create a :sql:`DELETE FROM` query. The method requires the table name from which
data is to be deleted. Classic usage:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    // DELETE FROM `tt_content` WHERE `bodytext` = 'lorem'
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $affectedRows = $queryBuilder
        ->delete('tt_content')
        ->where(
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('lorem', Connection::PARAM_STR))
        )
        ->executeStatement();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

Remarks:

*   For simple cases it is often easier to write and read using the
    :php:`->delete()` method of the :ref:`Connection <database-connection>`
    object.

*   In contrast to :php:`->select()`, :php:`->delete()` does **not**
    automatically add :sql:`WHERE` restrictions like ``AND `deleted` = 0``.

*   :php:`->delete()` does **not** magically transform a
    ``DELETE FROM `tt_content` WHERE `uid` = 4711`` into something like
    ``UPDATE `tt_content` SET `deleted` = 1 WHERE `uid` = 4711`` internally.
    A soft-delete must be handled at application level with a dedicated
    lookup in :php:`$GLOBALS['TCA']['theTable']['ctrl']['delete']` to check if
    a specific table can handle the soft-delete, together with an
    :php:`->update()` instead.

*   Deleting from multiple tables at once is **not** supported:
    ``DELETE FROM `table1`, `table2``` can not be created.

*   :php:`->delete()` ignores :php:`->join()`

*   :php:`->delete()` ignores :php:`setMaxResults()`: :sql:`DELETE` with
    :sql:`LIMIT` does not work.


.. _database-query-builder-update-set:

update() and set()
==================

Create an :sql:`UPDATE` query. Typical usage:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    // UPDATE `tt_content` SET `bodytext` = 'dolor' WHERE `bodytext` = 'lorem'
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->update('tt_content')
        ->where(
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('lorem', Connection::PARAM_STR))
        )
        ->set('bodytext', 'dolor')
        ->executeStatement();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

:php:`->update()` requires the table to update as the first argument and a table
alias (for example, :sql:`t`) as optional second argument. The table alias can
then be used in :php:`->set()` and :php:`->where()` expressions:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    // UPDATE `tt_content` `t` SET `t`.`bodytext` = 'dolor' WHERE `t`.`bodytext` = 'lorem'
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->update('tt_content', 't')
        ->where(
            $queryBuilder->expr()->eq('t.bodytext', $queryBuilder->createNamedParameter('lorem', Connection::PARAM_STR))
        )
        ->set('t.bodytext', 'dolor')
        ->executeStatement();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

:php:`->set()` requires a field name as the first argument and automatically
quotes it internally. The second mandatory argument is the value to set a field
to. **The value is automatically transformed to a named parameter of a prepared
statement**. This way, :php:`->set()` key/value pairs are **automatically SQL
protected from injection by default**.

If a field should be set to the value of another field from the row, quoting
must be turned off and :php:`->quoteIdentifier()` and :php:`false` have to
be used:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    // UPDATE `tt_content` SET `bodytext` = `header` WHERE `bodytext` = 'lorem'
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->update('tt_content')
        ->where(
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('lorem', Connection::PARAM_STR))
        )
        ->set('bodytext', $queryBuilder->quoteIdentifier('header'), false)
        ->executeStatement();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

Remarks:

*   For simple cases it is often easier to use the :php:`->update()` method of
    the :ref:`Connection <database-connection>` object.

*   :php:`->set()` can be called multiple times if multiple fields should be
    updated.

*   :php:`->set()` requires a field name as the first argument and automatically
    quotes it internally.

*   :php:`->set()` requires the value to which a field is to be set as the
    second parameter.

*   :php:`->update()` ignores :php:`->join()` and :php:`->setMaxResults()`.

*   :php:`->executeStatement()` returns the number of affected rows.

*   The API does not magically add `deleted = 0` or other restrictions, as is
    currently the case with :ref:`select
    <database-query-builder-default-restrictions>`.
    (See also :ref:`RestrictionBuilder <database-restriction-builder>`).

.. _database-query-builder-insert-values:

insert() and values()
=====================

Create an :sql:`INSERT` query. Typical usage:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // INSERT INTO `tt_content` (`bodytext`, `header`) VALUES ('lorem', 'dolor')
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $affectedRows = $queryBuilder
        ->insert('tt_content')
        ->values([
            'bodytext' => 'lorem',
            'header' => 'dolor',
        ])
        ->executeStatement();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

Remarks:

*   The `uid` of the created database row can be fetched from the connection
    by using :ref:`$queryBuilder->getConnection()->lastInsertId() <database-connection-last-insert-id>`.

*   :php:`->values()` expects an array of key/value pairs. Both **keys** (field
    names / identifiers) and **values** are automatically quoted. In rare cases,
    quoting of values can be turned off by setting the second argument to
    :php:`false`. Then quoting must be done manually, typically by using
    :php:`->createNamedParameter()` on the values.

*   :php:`->executeStatement()` after :php:`->insert()` returns the number of
    inserted rows, which is typically `1`.

*   An alternative to using the query builder for inserting data is using the
    :ref:`Connection <database-connection>` object with its :php:`->insert()`
    method.

*   The query builder does **not provide** a method for inserting multiple rows
    at once, use :php:`->bulkInsert()` of the :ref:`Connection <database-connection>`
    object instead to achieve that.

.. _database-query-builder-from:

from()
======

:php:`->from()` is essential for :php:`->select()` and :php:`->count()` query
types. :php:`->from()` requires a table name and an optional alias name. The
method is usually called once per query creation and the table name is usually
the same as the one passed to :php:`->getQueryBuilderForTable()`. If the query
joins multiple tables, the argument should be the name of the first table within
the :php:`->join()` chain:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // FROM `myTable`
    $queryBuilder->from('myTable');

    // FROM `myTable` AS `anAlias`
    $queryBuilder->from('myTable', 'anAlias');


:php:`->from()` can be called multiple times and will create the Cartesian
product of tables if not constrained by a respective :php:`->where()` or
:php:`->andWhere()` expression. In general, it is a good idea to use
:php:`->from()` only once per query and instead model the selection of multiple
tables with an explicit :php:`->join()`.

.. _database-query-builder-where:

where(), andWhere() and orWhere()
=================================

These three methods create :sql:`WHERE` restrictions for :sql:`SELECT`,
:sql:`COUNT`, :sql:`UPDATE` and :sql:`DELETE` query types. Each argument is
usually an :ref:`ExpressionBuilder <database-expression-builder>` object that
is converted to a string on :php:`->executeQuery()` or
:php:`->executeStatement()`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    // SELECT `uid`, `header`, `bodytext`
    // FROM `tt_content`
    // WHERE
    //    (
    //       ((`bodytext` = 'lorem') AND (`header` = 'a name'))
    //       OR (`bodytext` = 'dolor') OR (`bodytext` = 'hans')
    //    )
    //    AND (`pid` = 42)
    //    AND ... RestrictionBuilder TCA restrictions ...
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $result = $queryBuilder
        ->select('uid', 'header', 'bodytext')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('lorem', Connection::PARAM_STR)),
            $queryBuilder->expr()->eq('header', $queryBuilder->createNamedParameter('a name', Connection::PARAM_STR))
        )
        ->orWhere(
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('dolor')),
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('hans'))
        )
        ->andWhere(
            $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(42, Connection::PARAM_INT))
        )
        ->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

..  note::
    The commented out section in the code above demonstrates how including an
    :php:`->andWhere()` leads to nesting of the :php:`->where()` and
    :php:`->orWhere()` clauses.


Argument unpacking is useful as shown in the following methods:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    $whereExpressions = [
        $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('lorem', Connection::PARAM_STR)),
        $queryBuilder->expr()->eq('header', $queryBuilder->createNamedParameter('a name', Connection::PARAM_STR))
    ];
    if ($needsAdditionalExpression) {
        $whereExpressions[] = $someAdditionalExpression;
    }
    $queryBuilder->where(...$whereExpressions);

See available :ref:`parameter types <database-connection-parameter-types>`.

Remarks:

*   The three methods are `variadic <https://en.wikipedia.org/wiki/Variadic_function>`__.
    They can handle any number of arguments. For instance, if :php:`->where()`
    receives four arguments, they are handled as single expressions, all
    combined with :sql:`AND`.

*   :ref:`createNamedParameter <database-query-builder-create-named-parameter>`
    is used to create a placeholder for a field value of a prepared statement.
    **Always** use this when dealing with user input in expressions to protect
    the statement from SQL injections.

*   :php:`->where()` replaces all previously set :php:`->where()`,
    :php:`->andWhere()` and :php:`->orWhere()` expressions. It should therefore
    be called only once and at the beginning of a query to prevent unwanted behavior.

*   When creating complex :sql:`WHERE` restrictions, :php:`->getSQL()` and
    :php:`->getParameters()` are helpful debugging tools to verify parenthesis
    and single query parts.

*   If only :php:`->eq()` expressions are used, it is often easier to switch to
    the according method of the :ref:`Connection <database-connection>` object
    to simplify quoting and improve readability.

*   It is possible to feed the methods directly with strings, but this is
    discouraged and usually used only in rare cases where expression strings
    are created in a different place that can not be easily resolved.

..  dbal-join
.. _database-query-builder-join:

join(), innerJoin(), rightJoin() and leftJoin()
===============================================

Joining multiple tables in a :php:`->select()` or :php:`->count()` query is done
with one of these methods. Multiple joins are supported by calling the methods
more than once. All methods require four arguments: The name of the table on the
left (or its alias), the name of the table on the right, an alias for the name
of the table on the right, and the join restriction as fourth argument:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

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
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('sys_language')
    $result = $queryBuilder
       ->select('sys_language.uid', 'sys_language.title')
       ->from('sys_language')
       ->join(
           'sys_language',
           'pages',
           'p',
           $queryBuilder->expr()->eq('p.sys_language_uid', $queryBuilder->quoteIdentifier('sys_language.uid'))
       )
       ->where(
           $queryBuilder->expr()->eq('p.uid', $queryBuilder->createNamedParameter(42, Connection::PARAM_INT))
       )
       ->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

Notes to the example above:

*   The query operates with the :sql:`sys_language` table as the main table,
    this table name is given to :php:`getQueryBuilderForTable()`.

*   The query joins the :sql:`pages` table as :sql:`INNER JOIN` and gives it the
    alias :sql:`p`.

*   The join condition is ```p`.`sys_language_uid` = `sys_language`.`uid```. It
    would have been identical to swap the expression arguments of the fourth
    :php:`->join()` argument
    :php:`->eq('sys_language.uid', $queryBuilder->quoteIdentifier('p.sys_language_uid'))`.

*   The second argument of the join expression instructs the
    :ref:`ExpressionBuilder <database-expression-builder>` to quote the value as
    a field identifier (a field name, here a combination of table and field
    name). Using :ref:`createNamedParameter <database-query-builder-create-named-parameter>`
    would lead in quoting as value (`'` instead of ````` in MySQL) and the query
    would fail.

*   The alias :sql:`p` - the third argument of the :php:`->join()` call - does
    not necessarily have to be set to a different name than the table name
    itself here. It is sufficient to use :php:`pages` as third argument and not
    to specify any other name. Aliases are mostly useful when a join to the same
    table is needed:
    ``SELECT `something` FROM `tt_content` JOIN `tt_content` `content2` ON ...``.
    Aliases are also useful to increase the readability of `->where()`
    expressions.

*   The :ref:`RestrictionBuilder <database-restriction-builder>` has added
    additional :sql:`WHERE` conditions for both tables involved! The
    :sql:`sys_language` table obviously only specifies a
    :php:`'disabled' => 'hidden'` as :php:`enableColumns` in its
    :ref:`TCA ctrl <t3tca:ctrl>` section, while the :sql:`pages` table
    specifies the fields :sql:`deleted`, :sql:`hidden`, :sql:`starttime` and
    :sql:`stoptime`.


A more complex example with two joins. The first join points to the first table,
again using an alias to resolve a language overlay scenario. The second join
uses the alias of the first join target as left side:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

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
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('sys_language')
    $constraints = [
        $queryBuilder->expr()->eq('tt_content.colPos', $queryBuilder->createNamedParameter(1, Connection::PARAM_INT)),
        $queryBuilder->expr()->eq('tt_content.pid', $queryBuilder->createNamedParameter(42, Connection::PARAM_INT)),
        $queryBuilder->expr()->eq('tt_content.sys_language_uid', $queryBuilder->createNamedParameter(2, Connection::PARAM_INT)),
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
        ->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

Further remarks:

*   :php:`->join()` and `innerJoin` are identical. They create an
    :sql:`INNER JOIN` query, this is identical to a :sql:`JOIN` query.

*   :php:`->leftJoin()` creates a :sql:`LEFT JOIN` query, this is identical to
    a :sql:`LEFT OUTER JOIN` query.

*   :php:`->rightJoin()` creates a :sql:`RIGHT JOIN` query, this is identical to
    a :sql:`RIGHT OUTER JOIN` query.

*   Calls to :php:`join()` methods are only considered for :php:`->select()` and
    :php:`->count()` type queries. :php:`->delete()`, :php:`->insert()`
    and :php:`update()` do not support joins, these query parts are ignored and
    do not end up in the final statement.

*   The argument of :php:`->getQueryBuilderForTable()` should be the leftmost
    main table.

*   Joining two tables that are configured to different connections will throw
    an exception. This restricts the tables that can be configured for different
    database endpoints. It is possible to test the connection objects of the
    involved tables for equality and implement a fallback logic in PHP if they
    are different.

*   Doctrine DBAL does not support the use of join methods in combination with
    :php:`->update()`, :php:`->insert()` and :php:`->delete()` methods, because
    such a statement is not cross-platform compatible.

*   Multiple join condition expressions can be resolved as strings like:

    ..  code-block:: php

        $joinConditionExpression = $queryBuilder->expr()->and(
            $queryBuilder->expr()->eq(
                'tt_content_orig.sys_language_uid',
                $queryBuilder->quoteIdentifier('sys_language.uid')
            ),
            $queryBuilder->expr()->eq(
                'tt_content_orig.sys_language_uid',
                $queryBuilder->quoteIdentifier('sys_language.uid')
            ),
        );
        $queryBuilder->leftJoin(
            'tt_content_orig',
            'sys_language',
            'sys_language',
            (string)$joinConditionExpression
        );

.. _database-query-builder-orderby:

orderBy() and addOrderBy()
==========================

Add :sql:`ORDER BY` to a :php:`->select()` statement. Both :php:`->orderBy()` and
:php:`->addOrderBy()` require a field name as first argument:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // SELECT * FROM `sys_language` ORDER BY `sorting` ASC
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('sys_language');
    $queryBuilder->getRestrictions()->removeAll();
    $languageRecords = $queryBuilder
        ->select('*')
        ->from('sys_language')
        ->orderBy('sorting')
        ->executeQuery()
        ->fetchAllAssociative();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

Remarks:

*   :php:`->orderBy()` resets all previously specified orders. It makes no sense
    to call this function again after a previous :php:`->orderBy()` or
    :php:`->addOrderBy()`.

*   Both methods need a field name or a :sql:`table.fieldName` or a
    :sql:`tableAlias.fieldName` as first argument. In the example above the call
    to :php:`->orderBy('sys_language.sorting')` would have been identical. All
    identifiers are quoted automatically.

*   The second, optional argument of both methods specifies the sort order. The
    two allowed values are :php:`'ASC'` and :php:`'DESC'`, where :php:`'ASC'`
    is default and can be omitted.

*   To create a chain of orders, use :php:`->orderBy()` and then multiple
    :php:`->addOrderBy()` calls. The call to
    :php:`->orderBy('header')->addOrderBy('bodytext')->addOrderBy('uid', 'DESC')`
    creates ``ORDER BY `header` ASC, `bodytext` ASC, `uid` DESC``

*   To achieve more complex sortings, which can't be created with QueryBuilder,
    you can fall back on the underlying raw Doctrine QueryBuilder. This is
    accessible with :php:`->getConcreteQueryBuilder()`. It doesn't do any
    quoting, so you can do something like
    :php:`$concreteQueryBuilder->orderBy('FIELD(eventtype, 0, 4, 1, 2, 3)');`.
    Make sure to quote properly as this is entirely your responsibility with the
    Doctrine QueryBuilder!

.. _database-query-builder-groupby:

groupBy() and addGroupBy()
==========================

Add :sql:`GROUP BY` to a :php:`->select()` statement. Each argument of the
methods is a single identifier:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // GROUP BY `pages`.`sys_language_uid`, `sys_language`.`uid`
    ->groupBy('pages.sys_language_uid', 'sys_language.uid');

Remarks:

*   Similar to :php:`->select()` and :php:`->where()`, both methods are variadic
    and take any number of arguments, argument unpacking is supported:
    :php:`->groupBy(...$myGroupArray)`

*   Each argument is either a direct field name ``GROUP BY `bodytext```,
    a :sql:`table.fieldName` or a :sql:`tableAlias.fieldName` and is properly
    quoted.

*   :php:`->groupBy()` resets all previously defined group specification and
    should only be called once per statement.

*   For more complex statements you can use the raw Doctrine QueryBuilder.
    See remarks for :ref:`orderBy() <database-query-builder-orderby>`

..  _database-query-builder-union:

union() and addUnion()
======================

Method `union()` provides a streamlined way to combine result sets from multiple
queries.

:php:`union(string|QueryBuilder $part)`
    Creates the initial :sql:`UNION` query part by accepting either a raw SQL
    string or a `QueryBuilder` instance. Calling `union()` resets all previous
    union definitions, it should therefore only be called once, using `addUnion()`
    to add subsequent union parts.

:php:`addUnion(string|QueryBuilder $part, UnionType $type = UnionType::DISTINCT)`
    Adds additional :sql:`UNION` parts to the query. The `$type` parameter accepts:

    `UnionType::DISTINCT`
        Combines results while eliminating duplicates.
    `UnionType::ALL`
        Combines results and retains all duplicates. Not removing duplicates can
        be a performance improvement.

..  note::
    Although it is technically possible, it is not recommended to send direct SQL queries
    as strings to the `union()` and `addUnion()` methods. We recommend using a
    query builder.

    If you decide to do so you **must** take care of quoting, escaping, and
    valid SQL Syntax for the database system in question. The `Default Restrictions <https://docs.typo3.org/permalink/t3coreapi:database-query-builder-default-restrictions>`_
    are **not applied** on that part.

Named placeholders, such as created by :php:`QueryBuilder::createNamedParameter()`
**must** be created on the outer most QueryBuilder See the example below.

..  seealso::
    *   `W3School: SQL UNION Operator <https://www.w3schools.com/sql/sql_union.asp>`_
    *   For technical details see the changelog entry `Feature: #104631 - Add
        UNION Clause support to the QueryBuilder <https://docs.typo3.org/permalink/changelog:feature-104631-1723714985>`_.

..  _database-query-builder-union-db-support:

Database provider support of union() and addUnion()
---------------------------------------------------

:php-short:`\TYPO3\CMS\Core\Database\Query\QueryBuilder` can be used create
:sql:`UNION` clause queries not compatible with all database providers,
for example using :sql:`LIMIT/OFFSET` in each part query or other stuff.

When building functional tests, run them on all database types that should
be supported.

..  _database-query-builder-union-example-querybuilder:

Example using `union()` on two QueryBuilders
--------------------------------------------

..  literalinclude:: _UnionExample.php
    :caption: packages/my_extension/classes/Service/MyService.php

Line 18
    All query parts **must** share the same connection.
Line 19
    The outer most QueryBuilder is responsible for the union, it **must** be
    used to create named parameters and build expressions within the sub queries.
Line 22-23
    We therefore pass the central QueryBuilder responsible for the :sql:`UNION`
    to all subqueries. Same with the ExpressionBuilder.
Line 25-30
    We start building the `union()` on the first sub query, then add the
    second sub query using `addUnion()`
Line 41
    Only use the ExpressionBuilder of the sql:`UNION` within the subqueries.
Line 50
    Named parameters must also be called on the outer most union query builder.

The `Default Restrictions <https://docs.typo3.org/permalink/t3coreapi:database-query-builder-default-restrictions>`_
are applied to each subquery automatically.

..  _database-query-builder-setMaxResults:

setMaxResults() and setFirstResult()
====================================

Add :sql:`LIMIT` to restrict the number of records and :sql:`OFFSET` for
pagination of query parts. Both methods should be called only once per
statement:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // SELECT * FROM `sys_language` LIMIT 2 OFFSET 4
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('sys_language');
    $queryBuilder
        ->select('*')
        ->from('sys_language')
        ->setMaxResults(2)
        ->setFirstResult(4)
        ->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

Remarks:

*   It is allowed to call :php:`->setMaxResults()` without calling
    :php:`->setFirstResult()`.

*   It is possible to call :php:`->setFirstResult()` without calling
    :php:`setMaxResults()`: This is equivalent to "Fetch everything, but leave
    out the first n records". Internally, :sql:`LIMIT` will be added by
    Doctrine DBAL and set to a very high value.

*   :php:`->setMaxResults(null)` can be used to retrieve all results.
    If an unlimited result set is needed, and no
    reset of previous instructions is required, this method call should best
    be omitted for best compatibility.

..  versionchanged:: 13.0
    Starting with TYPO3 13 `null` instead of argument `0` (integer)
    must be used in :php:`->setMaxResults()` to return
    the complete result set without any :sql:`LIMIT`.

.. _database-query-builder-add:

add()
=====

..  versionchanged:: 13.0
    With the upgrade to Doctrine DBAL version 4 this method has been removed.

**Migration:** use the direct methods instead:

..  csv-table:: Replacements
    :header: "Before", "After"

    ":php:`->add('select', $array)`", ":php:`->select(...$array)`"
    ":php:`->add('where', $constraints)`", ":php:`->where(...$constraints)`"
    ":php:`->add('having', $havings)`", ":php:`->having(...$havings)`"
    ":php:`->add('orderBy', $orderBy)`", ":php:`->orderBy($orderByField, $orderByDirection)->addOrderBy($orderByField2)`"
    ":php:`->add('groupBy', $groupBy)`", ":php:`->groupBy($groupField)->addGroupBy($groupField2)`"


.. _database-query-builder-get-sql:

getSQL()
========

The :php:`->getSQL()` method returns the created query statement as string. It
is incredibly useful during development to verify that the final statement is
executed exactly as a developer expects:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('sys_language');
    $queryBuilder
        ->select('*')
        ->from('sys_language');
    debug($queryBuilder->getSQL());
    $result = $queryBuilder->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

Remarks:

*   This is debugging code. Take proper actions to ensure that these calls do
    not end up in production!

*   The method is usually called directly before :php:`->executeQuery()` or
    :php:`->executeStatement()` to output the final statement.

*   Casting a query builder object to :php:`(string)` has the same effect as
    calling :php:`->getSQL()`, but the explicit call using the method should be
    preferred to simplify a search operation for this kind of debugging
    statements.

*   The method is a simple way to see what restrictions the
    :ref:`RestrictionBuilder <database-restriction-builder>` has added.

*   Doctrine DBAL always creates prepared statements: Each value added via
    :ref:`createNamedParameter <database-query-builder-create-named-parameter>`
    creates a placeholder that is later replaced when the real query is
    triggered via :php:`->executeQuery()` or :php:`->executeStatement()`.
    :php:`->getSQL()` does not show these values, instead it displays the
    placeholder names, usually with a string like `:dcValue1`. There is no
    simple solution to show the fully replaced query within the framework, but
    you can use :ref:`getParameters <database-query-builder-get-parameters>` to
    see the array of parameters used to replace these placeholders within the
    query. On the frontend, the queries and parameters are available in the
    admin panel.


..  _database-query-builder-get-parameters:

getParameters()
===============

The :php:`->getParameters()` method returns the values for the placeholders of
the prepared statement in an array. This is incredibly useful during development
to verify that the final statement is executed as a developer expects:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('sys_language');
    $queryBuilder
        ->select('*')
        ->from('sys_language');
    debug($queryBuilder->getParameters());
    $statement = $queryBuilder->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

Remarks:

*   This is debugging code. Take proper actions to ensure that these calls do
    not end up in production!

*   The method is usually called directly before :php:`->executeQuery()` or
    :php:`->executeStatement()` to output the final statement.

*   Doctrine DBAL always creates prepared statements: Each value added via
    :ref:`createNamedParameter <database-query-builder-create-named-parameter>`
    creates a placeholder that is later replaced when the real query is
    triggered via :php:`->executeQuery()` or :php:`->executeStatement()`.
    :php:`->getParameters()` does not show the statement or the placeholders,
    instead the values are displayed, usually an array using keys like
    `:dcValue1`. There is no simple solution to show the fully replaced query
    within the framework, but you can use :ref:`getSql
    <database-query-builder-get-sql>` to see the string with placeholders, which
    is used as a prepared statement.


..  _database-query-builder-execute:

executeQuery() and executeStatement()
=====================================

..  versionchanged:: 13.0
    The :php:`->execute()` method has been removed. Use

    *   :php:`->executeQuery()` returning a :php:`\Doctrine\DBAL\Result` instead
        of a :php:`\Doctrine\DBAL\Statement` (like the :php:`->execute()`
        method returned) and

    *   :php:`->executeStatement()` returning the number of affected rows.

..  _database-query-builder-execute-query:

executeQuery()
--------------

This method compiles and fires the final query statement. This is usually the
last call on a query builder object. It can be called for :sql:`SELECT` and
:sql:`COUNT` queries.

On success, it returns a result object of type :php:`\Doctrine\DBAL\Result`
representing the result set. The :php:`Result` object can then be used by
:php:`fetchAssociative()`, :php:`fetchAllAssociative()` and :php:`fetchOne()`.
:php:`executeQuery()` returns a :php:`\Doctrine\DBAL\Result` and not a
:php:`\Doctrine\DBAL\Statement` anymore.

..  note::
    It is not possible to rebind placeholder values on the result and execute
    another query, as was sometimes done with the :php:`Statement` returned by
    :php:`execute()`.

If the query fails for some reason (for instance, if the database connection
was lost or if the query contains a syntax error), an
:php:`\Doctrine\DBAL\Exception` is thrown. It is usually bad habit to catch and
suppress this exception, as it indicates a runtime error a program error. Both
should bubble up. For more information on proper exception handling, see the
:ref:`coding guidelines <cgl-working-with-exceptions>`.

..  _database-query-builder-execute-statement:

executeStatement()
------------------

The :php:`executeStatement()` method can be used for :sql:`INSERT`,
:sql:`UPDATE` and :sql:`DELETE` statements. It returns the number of affected
rows as an integer.

.. _database-query-builder-expr:

expr()
======

This method returns an instance of the :ref:`ExpressionBuilder
<database-expression-builder>`. It is used to create complex :sql:`WHERE` query
parts and :sql:`JOIN` expressions:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    // SELECT `uid` FROM `tt_content` WHERE (`uid` > 42)
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->gt(
                'uid',
                $queryBuilder->createNamedParameter(42, Connection::PARAM_INT)
            )
        )
        ->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

Remarks:

*   This object is stateless and can be called and worked on as often as needed.
    However, it is bound to the specific connection for which a statement is
    created and therefore only available through the query builder, which is
    specific to a connection.

*   Never reuse the :ref:`ExpressionBuilder <database-expression-builder>`,
    especially not between multiple query builder objects, but always get an
    instance of the expression builder by calling :php:`->expr()`.


.. _database-query-builder-create-named-parameter:

createNamedParameter()
======================

..  versionchanged:: 13.0
    Doctrine DBAL v4 dropped the support for using the :php:`\PDO::PARAM_*`
    constants in favor of the enum types. Be aware of this and use
    :php:`\TYPO3\CMS\Core\Database\Connection::PARAM_*`, which can already be
    used in TYPO3 v12 and v11.

This method creates a placeholder for a field value of a prepared statement.
**Always** use this when dealing with user input in expressions to protect the
statement from SQL injections:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // SELECT * FROM `tt_content` WHERE (`bodytext` = 'kl\'aus')
    $searchWord = "kl'aus"; // $searchWord retrieved from the PSR-7 request
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder->getRestrictions()->removeAll();
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq(
                'bodytext',
                $queryBuilder->createNamedParameter($searchWord, Connection::PARAM_STR)
            )
        )
        ->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

The above example shows the importance of using :php:`->createNamedParameter()`:
The search word ``kl'aus`` is "tainted" and would break the query if not
channeled through :php:`->createNamedParameter()`, which quotes the backtick and
makes the value SQL injection-safe.

Not convinced? Suppose the code would look like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // NEVER EVER DO THIS!
    $_POST['searchword'] = "'foo' UNION SELECT username FROM be_users";
    $searchWord = $request->getParsedBody()['searchword']);
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder->getRestrictions()->removeAll();
     this fails with syntax error to prevent copy and paste
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            // MASSIVE SECURITY ISSUE DEMONSTRATED HERE
            // USE ->createNamedParameter() ON $searchWord!
            $queryBuilder->expr()->eq('bodytext', $searchWord)
        );

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

Mind the missing :php:`->createNamedParameter()` method call in the
:php:`->eq()` expression for a given value! This code would happily execute
the statement
``SELECT uid FROM `tt_content` WHERE `bodytext` = 'foo' UNION SELECT username FROM be_users;``
returning a list of backend user names!

..  note::
    :php:`->set()` automatically converts the second mandatory parameter into
    a named parameter of a prepared statement. If the second parameter is
    wrapped in a :php:`->createNamedParameter()` call, this will result in an
    error during execution. This behaviour can be disabled by passing
    :php:`false` as third parameter to :php:`->set()`.

More examples
-------------

Use integer, integer array:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    // SELECT * FROM `tt_content`
    //     WHERE `bodytext` = 'kl\'aus'
    //     AND   sys_language_uid = 0
    //     AND   pid in (2, 42,13333)
    $searchWord = "kl'aus"; // $searchWord retrieved from the PSR-7 request
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder->getRestrictions()->removeAll();
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq(
                'bodytext',
                $queryBuilder->createNamedParameter($searchWord)
            ),
            $queryBuilder->expr()->eq(
                'sys_language_uid',
                $queryBuilder->createNamedParameter($language, Connection::PARAM_INT)
            ),
            $queryBuilder->expr()->in(
                'pid',
                $queryBuilder->createNamedParameter($pageIds, Connection::PARAM_INT_ARRAY)
            )
        )
        ->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

Rules
-----

*   **Always** use :php:`->createNamedParameter()` for **any** input, no matter
    where it comes from.

*   The second argument of :php:`->expr()` is **always** either a call to
    :php:`->createNamedParameter()` or :php:`->quoteIdentifier()`.

*   The second argument of :php:`->createNamedParameter()` specifies the type of
    input. For string, this can be omitted, but it is good practice to add
    `\TYPO3\CMS\Core\Database\Connection::PARAM_INT` for integers or similar for
    other field types. This is not strict rule currently, but if you follow it
    you will have fewer headaches in the future, especially with :abbr:`DBMSes
    (Database management systems)` that are not as relaxed as MySQL when it
    comes to field types. The :php:`Connection` constants can be used for simple
    types like `bool`, `string`, `null`, `lob` and `integer`. Additionally, the
    two constants `Connection::PARAM_INT_ARRAY` and `Connection::PARAM_STR_ARRAY`
    can be used when handling an array of strings or integers, for instance in
    an `IN()` expression.

*   Keep the :php:`->createNamedParameter()` method as close to the expression
    as possible. Do not structure your code in a way that it quotes something
    first and only later stuffs the already prepared names into the expression.
    Having :php:`->createNamedParameter()` directly within the created
    expression, is much less error-prone and easier to review. This is a general
    rule: Sanitizing input must be done as close as possible to the "sink" where
    a value is passed to a lower part of the framework. This paradigm should
    also be followed for other quote operations like :php:`htmlspecialchars()`
    or :php:`GeneralUtility::quoteJSvalue()`. Sanitization should be obvious
    directly at the very place where it is important:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    // DO
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder->getRestrictions()->removeAll();
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq(
                'bodytext',
                $queryBuilder->createNamedParameter($searchWord, Connection::PARAM_STR)
            )
        )

    // DON'T DO, this is much harder to track:
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $myValue = $queryBuilder->createNamedParameter($searchWord);
    // Imagine much more code here
    $queryBuilder->getRestrictions()->removeAll();
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq('bodytext', $myValue)
        )

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

.. _database-query-builder-quote-identifier:

quoteIdentifier() and quoteIdentifiers()
========================================

:php:`->quoteIdentifier()` must be used when not a value but a field name is
handled. The quoting is different in those cases and typically ends up with
backticks ````` instead of ticks ``'``:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // SELECT `uid` FROM `tt_content` WHERE (`header` = `bodytext`)
    // Return list of rows where header and bodytext values are identical
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq(
                'header',
                $queryBuilder->quoteIdentifier('bodytext')
            )
        );

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

The method quotes single field names or combinations of table names or table
aliases with field names:

..  code-block:: none
    :caption: Some quote examples

    // Single field name: `bodytext`
    ->quoteIdentifier('bodytext');

    // Table name and field name: `tt_content`.`bodytext`
    ->quoteIdentifier('tt_content.bodytext')

    // Table alias and field name: `foo`.`bodytext`
    ->from('tt_content', 'foo')->quoteIdentifier('foo.bodytext')

Remarks:

*   Similar to :ref:`->createNamedParameter()
    <database-query-builder-create-named-parameter>` this method is crucial to
    prevent SQL injections. The same rules apply here.

*   The :ref:`->set() <database-query-builder-update-set>` method for
    :sql:`UPDATE` statements expects its second argument to be a field value by
    default, and quotes it internally using :php:`->createNamedParameter()`. If
    a field should be set to the value of another field, this quoting can be
    turned off and an explicit call to :php:`->quoteIdentifier()` must be added.

*   Internally, :php:`->quoteIdentifier()` is automatically called on all method
    arguments that must be a field name. For instance, :php:`->quoteIdentifier()`
    is called for all arguments of :ref:`->select() <database-query-builder-select>`.

*   :php:`->quoteIdentifiers()` (mind the plural) can be used to quote multiple
    field names at once. While that method is "public" and thus exposed as an
    API method, this is mostly useful internally only.


.. _database-query-builder-escape-like-wildcards:

escapeLikeWildcards()
=====================

Helper method to quote `%` characters within a search string. This is helpful in
:php:`->like()` and :php:`->notLike()` expressions:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    // SELECT `uid` FROM `tt_content` WHERE (`bodytext` LIKE '%kl\\%aus%')
    $searchWord = 'kl%aus';
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->like(
                'bodytext',
                $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($searchWord) . '%', Connection::PARAM_STR)
            )
        );

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

..  warning::
    Even when using :php:`->escapeLikeWildcards()` the value must be
    encapsulated again in a :php:`->createNamedParameter()` call. Only calling
    :php:`->escapeLikeWildcards()` does **not** make the value SQL injection
    safe!

.. _database-query-builder-get-restrictions:

getRestrictions(), setRestrictions(), resetRestrictions()
=========================================================

`API` methods to deal with the :ref:`RestrictionBuilder <database-restriction-builder>`.
