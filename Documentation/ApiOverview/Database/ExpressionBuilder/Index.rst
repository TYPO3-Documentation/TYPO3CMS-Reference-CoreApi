..  include:: /Includes.rst.txt

..  _database-expression-builder:

==================
Expression builder
==================

.. contents:: **Table of Contents**
   :local:


Introduction
============

The :php:`\TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder` class is
responsible for dynamically creating SQL query parts for :sql:`WHERE` and
:sql:`JOIN ON` conditions. Functions like :php:`->min()` may also be used in
:sql:`SELECT` parts.

It takes care of building query conditions and ensures that table and column
names are quoted within the created expressions / SQL fragments. It is a facade
to the actual Doctrine DBAL :php:`ExpressionBuilder`.

The expression builder is used in the context of the :ref:`query builder
<database-query-builder>` to ensure that queries are built based on the
requirements of the database platform being used.


Basic usage
===========

An instance of the :php:`ExpressionBuilder` is retrieved from the
:php:`QueryBuilder` object:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    $expressionBuilder = $queryBuilder->expr();

It is good practice not to assign an instance of the :php:`ExpressionBuilder` to
a variable, but to use it directly within the code flow of the query builder
context:

..  literalinclude:: _MyTableRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

See available :ref:`parameter types <database-connection-parameter-types>`.

..  warning::
    It is of crucial importance to quote values correctly to not introduce SQL
    injection attack vectors into your application. See the :ref:`according
    section of the query builder <database-query-builder-create-named-parameter>`
    for details.


Junctions
=========

..  versionchanged:: 11.5.10
    The :php:`andX()` and :php:`orX()` methods are replaced by :php:`and()` and
    :php:`or()` to match with Doctrine DBAL, which
    `deprecated <https://github.com/doctrine/dbal/commit/84328cd947706210caebcaea3ca0394b3ebc4673>`_
    these methods. Both methods have been removed with TYPO3 v13.0.

*   :php:`->and()` conjunction

*   :php:`->or()` disjunction

Combine multiple single expressions with :sql:`AND` or :sql:`OR`. Nesting is
possible, both methods are variadic and accept any number of arguments, which
are all combined. However, it usually makes little sense to pass zero or only
one argument.

Example to find :sql:`tt_content` records:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    // WHERE
    //     (`tt_content`.`CType` = 'list')
    //     AND (
    //        (`tt_content`.`list_type` = 'example_pi1')
    //        OR
    //        (`tt_content`.`list_type` = 'example_pi2')
    //     )
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder->where(
        $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('list')),
        $queryBuilder->expr()->or(
            $queryBuilder->expr()->eq(
                'list_type',
                $queryBuilder->createNamedParameter('example_pi1', Connection::PARAM_STR)
            ),
            $queryBuilder->expr()->eq(
                'list_type',
                $queryBuilder->createNamedParameter('example_pi2', Connection::PARAM_STR)
            )
        )
    )

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.


Comparisons
===========

A set of methods to create various comparison expressions or SQL functions:

*   :php:`->eq($fieldName, $value)` "equal" comparison `=`

*   :php:`->neq($fieldName, $value)` "not equal" comparison `!=`

*   :php:`->lt($fieldName, $value)` "less than" comparison `<`

*   :php:`->lte($fieldName, $value)` "less than or equal" comparison `<=`

*   :php:`->gt($fieldName, $value)` "greater than" comparison `>`

*   :php:`->gte($fieldName, $value)` "greater than or equal" comparison `>=`

*   :php:`->isNull($fieldName)` "IS NULL" comparison

*   :php:`->isNotNull($fieldName)` "IS NOT NULL" comparison

*   :php:`->like($fieldName, $value)` "LIKE" comparison

*   :php:`->notLike($fieldName, $value)` "NOT LIKE" comparison

*   :php:`->in($fieldName, $valueArray)` "IN ()" comparison

*   :php:`->notIn($fieldName, $valueArray)` "NOT IN ()" comparison

*   :php:`->inSet($fieldName, $value)` "FIND_IN_SET('42', `aField`)"
    Find a value in a comma separated list of values

*   :php:`->notInSet($fieldName, $value)` "NOT FIND_IN_SET('42', `aField`)"
    Find a value not in a comma separated list of values

*   :php:`->bitAnd($fieldName, $value)` A bitwise AND operation `&`


Remarks and warnings:

*   The first argument :php:`$fieldName` is always quoted automatically.

*   All methods that have a :php:`$value` or :php:`$valueList` as second
    argument **must** be quoted, usually by calling
    :ref:`$queryBuilder->createNamedParameter() <database-query-builder-create-named-parameter>`
    or :ref:`$queryBuilder->quoteIdentifier() <database-query-builder-quote-identifier>`.

    ..  warning::
        Failing to quote will end up in :ref:`SQL injections <security-sql-injection>`!

*   :php:`->like()` and :php:`->notLike()` values **must** be **additionally**
    quoted with a call to :ref:`$queryBuilder->escapeLikeWildcards($value)
    <database-query-builder-escape-like-wildcards>` to suppress the special
    meaning of `%` characters from `$value`.


Examples:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    // `bodytext` = 'foo' - string comparison
    ->eq('bodytext', $queryBuilder->createNamedParameter('foo'))

    // `tt_content`.`bodytext` = 'foo'
    ->eq('tt_content.bodytext', $queryBuilder->createNamedParameter('foo'))

    // `aTableAlias`.`bodytext` = 'foo'
    ->eq('aTableAlias.bodytext', $queryBuilder->createNamedParameter('foo'))

    // `uid` = 42 - integer comparison
    ->eq('uid', $queryBuilder->createNamedParameter(42, Connection::PARAM_INT))

    // `uid` >= 42
    ->gte('uid', $queryBuilder->createNamedParameter(42, Connection::PARAM_INT))

    // `bodytext` LIKE 'lorem'
    ->like(
        'bodytext',
        $queryBuilder->createNamedParameter(
            $queryBuilder->escapeLikeWildcards('lorem')
        )
    )

    // `bodytext` LIKE '%lorem%'
    ->like(
        'bodytext',
        $queryBuilder->createNamedParameter(
            '%' . $queryBuilder->escapeLikeWildcards('lorem') . '%'
        )
    )

    // usergroup does not contain 42
    ->notInSet('usergroup', $queryBuilder->createNamedParameter('42'))

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

See available :ref:`parameter types <database-connection-parameter-types>`.

Aggregate Functions
===================

Aggregate functions used in :sql:`SELECT` parts, often combined with
:sql:`GROUP BY`. The first argument is the field name (or table name / alias
with field name), the second argument is an optional alias.

*   :php:`->min($fieldName, $alias = NULL)` "MIN()" calculation

*   :php:`->max($fieldName, $alias = NULL)` "MAX()" calculation

*   :php:`->avg($fieldName, $alias = NULL)` "AVG()" calculation

*   :php:`->sum($fieldName, $alias = NULL)` "SUM()" calculation

*   :php:`->count($fieldName, $alias = NULL)` "COUNT()" calculation

Examples:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // Calculate the average creation timestamp of all rows from tt_content
    // SELECT AVG(`crdate`) AS `averagecreation` FROM `tt_content`
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $result = $queryBuilder
        ->addSelectLiteral(
            $queryBuilder->expr()->avg('crdate', 'averagecreation')
        )
        ->from('tt_content')
        ->executeQuery()
        ->fetchAssociative();

    // Distinct list of all existing endtime values from tt_content
    // SELECT `uid`, MAX(`endtime`) AS `maxendtime` FROM `tt_content` GROUP BY `endtime`
    $statement = $queryBuilder
        ->select('uid')
        ->addSelectLiteral(
            $queryBuilder->expr()->max('endtime', 'maxendtime')
        )
        ->from('tt_content')
        ->groupBy('endtime')
        ->executeQuery();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.


Various Expressions
===================

trim()
------

Using the :php:`->trim()` expression ensures that the fields are trimmed at the
database level. The following examples give a better idea of what is possible:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // use TYPO3\CMS\Core\Database\Connection
    // use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder->expr()->comparison(
        $queryBuilder->expr()->trim($fieldName),
        ExpressionBuilder::EQ,
        $queryBuilder->createNamedParameter('', Connection::PARAM_STR)
    );

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

The call to :php:`$queryBuilder->expr()-trim()` can be one of the following:

*   :php:`trim('fieldName')`
    results in :code:`TRIM("tableName"."fieldName")`
*   :php:`trim('fieldName', TrimMode::LEADING, 'x')`
    results in :code:`TRIM(LEADING "x" FROM "tableName"."fieldName")`
*   :php:`trim('fieldName', TrimMode::TRAILING, 'x')`
    results in :code:`TRIM(TRAILING "x" FROM "tableName"."fieldName")`
*   :php:`trim('fieldName', TrimMode::BOTH, 'x')`
    results in :code:`TRIM(BOTH "x" FROM "tableName"."fieldName")`


length()
--------

The :php:`->length()` string function can be used to return the length of a
string in bytes. The signature of the method signature is :php:`$fieldName`
with an optional alias :php:`->length(string $fieldName, string $alias = null)`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    // use TYPO3\CMS\Core\Database\Connection;
    // use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder->expr()->comparison(
        $queryBuilder->expr()->length($fieldName),
        ExpressionBuilder::GT,
        $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)
    );

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.
