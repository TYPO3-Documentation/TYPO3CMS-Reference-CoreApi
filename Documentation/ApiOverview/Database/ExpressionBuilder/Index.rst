.. include:: ../../../Includes.txt

.. _database-expression-builder:

ExpressionBuilder
-----------------

The `ExpressionBuilder` class is responsible to dynamically create SQL query parts
for `WHERE` and `JOIN ON` conditions, functions like :php:`->min()` may also be used in
`SELECT` parts.

It takes care of building query conditions while ensuring table and column names
are quoted within the created expressions / SQL fragments. It is a facade to
the actual `doctrine-dbal` `ExpressionBuilder`.

The `ExpressionBuilder` is used within the context of the :ref:`QueryBuilder <database-query-builder>`
to ensure queries are being build based on the requirements of the database platform in use.

An instance of the `ExpressionBuilder` is retrieved from the `QueryBuilder` object::

   $expressionBuilder = $queryBuilder->expr();

It is good practice to not assign an instance of the `ExpressionBuilder` to a variable but
to use it within the code flow of the `QueryBuilder` context directly::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   $rows = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content')
      ->select('uid', 'header', 'bodytext')
      ->from('tt_content')
      ->where(
         // `bodytext` = 'klaus' AND `header` = 'peter'
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus')),
         $queryBuilder->expr()->eq('header', $queryBuilder->createNamedParameter('peter'))
      )
      ->execute()
      ->fetchAll();

.. warning::

   It is crucially important to quote values correctly to not introduce SQL injection attack
   vectors to your application. See the
   :ref:`section of the QueryBuilder <database-query-builder-create-named-parameter>` for details.


Junctions
^^^^^^^^^

* :php:`->andX()` conjunction

* :php:`->orX()` disjunction


Combine multiple single expressions with `AND` or `OR`. Nesting is possible, both methods are variadic and
take any number of argument which are all combined. It usually doesn't make much sense to hand over
zero or only one argument, though.

A core example to find a sys_domain record::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // WHERE
   //     (`sys_domain`.`pid` = `pages`.`uid`)
   //     AND (
   //        (`sys_domain`.`domainName` = 'example.com')
   //        OR
   //        (`sys_domain`.`domainName` = 'example.com/')
   //     )
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder->where(
      $queryBuilder->expr()->eq('sys_domain.pid', $queryBuilder->createNamedParameter('pages.uid', \PDO::PARAM_INT)),
      $queryBuilder->expr()->orX(
         $queryBuilder->expr()->eq('sys_domain.domainName', $queryBuilder->createNamedParameter($domain)),
         $queryBuilder->expr()->eq('sys_domain.domainName', $queryBuilder->createNamedParameter($domain . '/'))
      )
   )


Comparisons
^^^^^^^^^^^

A set of methods to create various comparison expressions or SQL functions:

* :php:`->eq($fieldName, $value)` "equal" comparison `=`

* :php:`->neq($fieldName, $value)` "not equal" comparison `!=`

* :php:`->lt($fieldName, $value)` "less than" comparison `<`

* :php:`->lte($fieldName, $value)` "less than or equal" comparison `<=`

* :php:`->gt($fieldName, $value)` "greater than" comparison `>`

* :php:`->gte($fieldName, $value)` "greater than or equal" comparison `>=`

* :php:`->isNull($fieldName)` "IS NULL" comparison

* :php:`->isNotNull($fieldName)` "IS NOT NULL" comparison

* :php:`->like($fieldName, $value)` "LIKE" comparison

* :php:`->notLike($fieldName, $value)` "NOT LIKE" comparison

* :php:`->in($fieldName, $valueArray)` "IN ()" comparison

* :php:`->notIn($fieldName, $valueArray)` "NOT IN ()" comparison

* :php:`->inSet($fieldName, $value)` "FIND_IN_SET('42', `aField`)" Find a value in a comma separated list of values

* :php:`->bitAnd($fieldName, $value)` A bitwise AND operation `&`


Remarks and warnings:

* The first argument :php:`$fieldName` is always quoted automatically.

* All methods that have a :php:`$value` or :php:`$valueList` as second argument **must** be quoted, usually by calling
  :ref:`$queryBuilder->createNamedParameter() <database-query-builder-create-named-parameter>` or
  :ref:`$queryBuilder->quoteIdentifier() <database-query-builder-quote-identifier>`. **Failing to do so will end
  up in SQL injections!**

* :php:`->like()` and :php:`->notLike()` values **must** be **additionally** quoted with a call to
  :ref:`$queryBuilder->escapeLikeWildcards($value) <database-query-builder-escape-like-wildcards>` to
  suppress the special meaning of `%` characters from `$value`.


Examples::


   // `bodytext` = 'foo' - string comparison
   ->eq('bodytext', $queryBuilder->createNamedParameter('foo'))

   // `tt_content`.`bodytext` = 'foo'
   ->eq('tt_content.bodytext', $queryBuilder->createNamedParameter('foo'))

   // `aTableAlias`.`bodytext` = 'foo'
   ->eq('aTableAlias.bodytext', $queryBuilder->createNamedParameter('foo'))

   // `uid` = 42 - integer comparison
   ->eq('uid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT))

   // `uid` >= 42
   ->gte('uid', $queryBuilder->createNamedParameter(42, \PDO::PARAM_INT))

   // `bodytext` LIKE 'klaus'
   ->like(
      'bodytext',
      $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards('klaus'))
   )

   // `bodytext` LIKE '%klaus%'
   ->like(
      'bodytext',
      $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('klaus') . '%')
   )

   // use TYPO3\CMS\Core\Database\Connection;
   // `uid` IN (42, 0, 44) - properly sanitized, mind the intExplode and PARAM_INT_ARRAY
   ->in(
      'uid',
      $queryBuilder->createNamedParameter(
         GeneralUtility::intExplode(',', '42, karl, 44', true),
         Connection::PARAM_INT_ARRAY
      )
   )

   // use TYPO3\CMS\Core\Database\Connection;
   // `CType` IN ('media', 'multimedia') - properly sanitized, mind the PARAM_STR_ARRAY
   ->in(
      'CType',
      $queryBuilder->createNamedParameter(
         ['media', 'multimedia'],
         Connection::PARAM_STR_ARRAY
      )
   )


Aggregate functions
^^^^^^^^^^^^^^^^^^^

Aggregate functions used in `SELECT` parts, often combined with `GROUP BY`. First argument is
the field name (or table name / alias with field name), second argument an optional alias.

* :php:`->min($fieldName, $alias = NULL)` "MIN()" calculation

* :php:`->max($fieldName, $alias = NULL)` "MAX()" calculation

* :php:`->avg($fieldName, $alias = NULL)` "AVG()" calculation

* :php:`->sum($fieldName, $alias = NULL)` "SUM()" calculation

* :php:`->count($fieldName, $alias = NULL)` "COUNT()" calculation


Examples::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // Calculate the average creation timestamp of all rows from tt_content
   // SELECT AVG(`crdate`) AS `averagecreation` FROM `tt_content`
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $result = $queryBuilder
      ->addSelectLiteral(
         $queryBuilder->expr()->avg('crdate', 'averagecreation')
      )
      ->from('tt_content')
      ->execute()
      ->fetch();

   // Distinct list of all existing endtime values from tt_content
   // SELECT `uid`, MAX(`endtime`) AS `maxendtime` FROM `tt_content` GROUP BY `endtime`
   $statement = $queryBuilder
      ->select('uid')
      ->addSelectLiteral(
         $queryBuilder->expr()->max('endtime', 'maxendtime')
      )
      ->from('tt_content')
      ->groupBy('endtime')
      ->execute();


Various Expressions
^^^^^^^^^^^^^^^^^^^

TRIM
%%%%

Using the TRIM expression makes sure fields get trimmed on database level.
See the examples below to get a better idea of what can be done::

    // use TYPO3\CMS\Core\Utility\GeneralUtility;
    // use TYPO3\CMS\Core\Database\ConnectionPool;
    // use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
    $queryBuilder->expr()->comparison(
        $queryBuilder->expr()->trim($fieldName),
        ExpressionBuilder::EQ,
        $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)
    );

The call to :php:`$queryBuilder->expr()-trim()` can be one of the following:

* :php:`trim('fieldName')`
  results in :code:`TRIM("tableName"."fieldName")`
* :php:`trim('fieldName', AbstractPlatform::TRIM_LEADING, 'x')`
  results in :code:`TRIM(LEADING "x" FROM "tableName"."fieldName")`
* :php:`trim('fieldName', AbstractPlatform::TRIM_TRAILING, 'x')`
  results in :code:`TRIM(TRAILING "x" FROM "tableName"."fieldName")`
* :php:`trim('fieldName', AbstractPlatform::TRIM_BOTH, 'x')`
  results in :code:`TRIM(BOTH "x" FROM "tableName"."fieldName")`

LENGTH
%%%%%%

The LENGTH string function can be used to return the length of a string in bytes, method
signature is fieldName with optional alias :php:`->length(string $fieldName, string $alias = null)`::

    // use TYPO3\CMS\Core\Utility\GeneralUtility;
    // use TYPO3\CMS\Core\Database\ConnectionPool;
    // use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
    $queryBuilder->expr()->comparison(
        $queryBuilder->expr()->length($fieldName),
        ExpressionBuilder::GT,
        $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
    );
