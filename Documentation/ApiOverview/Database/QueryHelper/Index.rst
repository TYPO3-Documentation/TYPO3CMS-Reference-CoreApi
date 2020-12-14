.. include:: /Includes.rst.txt

.. _database-query-helper:

===========
QueryHelper
===========

The class contains miscellaneous helper methods to build syntactically valid
SQL queries.

Most helper methods are required to deal with legacy data where the format of
the input is not strict enough to reliably use the SQL parts in queries directly.

The whole class is marked as `@internal`, **should not be used by extension
authors** and may - if things go wrong - change at will. The class will hopefully
vanish mid-term. However, there may be situations when the class methods can become
handy if extension authors :ref:`migrate <database-migration>` their own extensions away
from `TYPO3_DB` to Doctrine DBAL. In practice, the core will *most likely* add proper
deprecations to single methods if they are target of removal later.

Extension developers may keep this class in mind for migration, but **must not** use
methods for new code created from scratch. Apart from that, as can be seen below, using
those methods often ends up in rather ugly code.

The migration benefits are the only reason the methods are documented here.

.. warning::

    Using those methods raise the risk of SQL injections, especially for methods like
    :php:`->stripLogicalOperatorPrefix()` since its input string tends to come from user
    supplied input and is sometimes added as `WHERE` expression without further quoting.
    Keep a special eye on those scenarios!


parseOrderBy()
==============

Some parts of the core framework allow string definitions like `ORDER BY sorting` for instance
in `TCA` and `TypoScript`. The method rips those strings apart and prepares them to be fed
to :php:`QueryBuilder->orderBy()`::

   // 'ORDER BY aField ASC,anotherField, aThirdField DESC'
   // ->
   // [ ['aField', 'ASC'], ['anotherField', null], ['aThirdField', 'DESC'] ]
   $uglyOrderBy = 'ORDER BY aField ASC,anotherField, aThirdField DESC'
   foreach (QueryHelper::parseOrderBy((string)$uglyOrderBy) as $orderPair) {
      list($fieldName, $order) = $orderPair;
      $queryBuilder->addOrderBy($fieldName, $order);
   }


parseGroupBy()
==============

Parses `GROUP BY` strings ready to be added via :php:`QueryBuilder->groupBy()`,
similar to :php:`->parseOrderBy()`::

   // 'GROUP BY be_groups.title, anotherField'
   // ->
   // ['be_groups.title', 'anotherField']
   $uglyGroupBy = 'GROUP BY be_groups.title, anotherField';
   $queryBuilder->groupBy(QueryHelper::parseGroupBy($uglyGroupBy));


parseTableList()
================

Parse a table list, possibly prefixed with FROM, and explode it into and array of arrays where
each item consists of a tableName and an optional alias name,
ready to be put into :php:`QueryBuilder->from()`::

   // 'FROM aTable a,anotherTable, aThirdTable AS c',
   // ->
   // [ ['aTable', 'a'], ['anotherTable', null], ['aThirdTable', 'c'] ]
   $uglyTableString = 'FROM aTable a,anotherTable, aThirdTable AS c;
   foreach (QueryHelper::parseTableList($uglyTableString) as $tableNameAndAlias) {
      list($tableName, $tableAlias) = $tableNameAndAlias;
      $queryBuilder->from($tableName, $tableAlias);
   }


parseJoin()
===========

Split a JOIN SQL fragment into table name, alias and join conditions::

   // 'aTable AS `anAlias` ON anAlias.uid = anotherTable.uid_foreign'
   // ->
   // [
   //     'tableName' => 'aTable',
   //     'tableAlias' => 'anAlias',
   //     'joinCondition' => 'anAlias.uid = anotherTable.uid_foreign'
   // ],
   $uglyJoinString = 'aTable AS `anAlias` ON anAlias.uid = anotherTable.uid_foreign';
   $joinParts = QueryHelper::parseJoin($uglyJoinString);
   $queryBuilder->join(
      $leftTable,
      $joinParts['tableName'],
      $joinParts['tableAlias'],
      $joinParts['joinCondition']
   );


stripLogicalOperatorPrefix()
============================

Removes the prefixes `AND` / `OR` from an input string.

Those prefixes are added in Doctrine DBAL via :php:`QueryBuilder->where()`, :php:`QueryBuilder->orWhere()`,
:php:`ExpressionBuilder->andX()` and friends. Some parts of the `TYPO3` framework however carry SQL fragments
prefixed with `AND` or `OR` around and it's not always possible to easily get rid of those. The method
helps by killing those prefixes before they are handed over to the `doctrine` API::

   // 'AND 1=1'
   // ->
   // '1=1'
   $uglyWherePart = 'AND 1=1'
   $queryBuilder->where(
      // WARNING: High risk of possible SQL injection here, take additional actions!
      QueryHelper::stripLogicalOperatorPrefix($uglyWherePart)
   );


getDateTimeFormats()
====================

Just a left over method from the old `TYPO3_DB` `DatabaseConnection` class. Of little to no use
for extension authors. This one is hopefully one of the first methods to vanish from the class.


.. _database-query-helper-quoteDatabaseIdentifiers:

quoteDatabaseIdentifiers()
==========================

This helper method is used especially in `TCA` and `TypoScript` at places where SQL fragments are specified to
correctly quote table and field names for the specific database platform. It for example
substitutes :php:`{#aIdentifier}` to ```aIdentifier``` if using MySQL or to `"aIdentifier"`
if using PostgreSQL. Let's suppose a simple `TCA` columns select field like this::

    'aSelectFieldWithForeignTableWhere' => [
        'label' => 'some label',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tx_some_foreign_table_name',
            'foreign_table_where' => 'AND {#tx_some_foreign_table_name}.{#pid} = 42',
        ],
    ],

Method :php:`quoteDatabaseIdentifiers()` is called for :php:`foreign_table_where`, and if using
MySQL, this fragment will be substituted to::

    AND `tx_some_foreign_table_name`.`pid` = 42

The core had to come up with this special syntax since the core API contains various places
where SQL fragments can be specified by extension developers who do not know and should not
restrict on which actual platform a query is performed.

As an extension developer it is important to use this :php:`{#...}` syntax in order to make
extensions database platform agnostic. The TCA reference and TypoScript reference contains
hints at the according properties that need this, in general the core calls this helper
method whenever SQL fragments can be specified in `TCA` and `TypoScript`.
