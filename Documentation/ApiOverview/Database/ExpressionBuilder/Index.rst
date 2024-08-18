..  include:: /Includes.rst.txt

..  _database-expression-builder:

==================
Expression builder
==================

.. contents:: **Table of Contents**
   :local:

..  include:: _ExpressionBuilder.rst.txt

..  _database-expression-builder-basic-usage:

Basic usage
===========

An instance of the :php:class:`ExpressionBuilder <TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder>` is retrieved from the
:php:`QueryBuilder` object:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

    $expressionBuilder = $queryBuilder->expr();

It is good practice not to assign an instance of the :php:class:`ExpressionBuilder <TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder>` to
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

..  _database-expression-builder-basic-junctions:

Junctions
=========

..  versionchanged:: 11.5.10
    The :php:`andX()` and :php:`orX()` methods are deprecated and replaced by
    :php:`and()` and :php:`or()` to match with Doctrine DBAL, which `deprecated
    <https://github.com/doctrine/dbal/commit/84328cd947706210caebcaea3ca0394b3ebc4673>`_
    these methods.

*   :php:`->and()` conjunction

*   :php:`->or()` disjunction

Combine multiple single expressions with :sql:`AND` or :sql:`OR`. Nesting is
possible, both methods are variadic and accept any number of arguments, which
are all combined. However, it usually makes little sense to pass zero or only
one argument.

Example to find :sql:`tt_content` records:

..  literalinclude:: _RepositoryWithJunctions.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

..  _database-expression-builder-basic-comparisons:

Comparisons
===========

A set of methods to create various comparison expressions or SQL functions:

..  include:: _ExpressionBuilderComparisons.rst.txt

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

..  _database-expression-builder-basic-aggregate-functions:

Aggregate functions
===================

Aggregate functions used in :sql:`SELECT` parts, often combined with
:sql:`GROUP BY`. The first argument is the field name (or table name / alias
with field name), the second argument is an optional alias.

..  include:: _ExpressionBuilderAggregate.rst.txt

Examples:

..  literalinclude:: _RepositoryAgregate.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

..  _database-expression-builder-basic-various-expressions:

Various expressions
===================

length()
--------

..  include:: _ExpressionBuilderLength.rst.txt

The :php:`->length()` string function can be used to return the length of a
string in bytes.

..  literalinclude::  _RepositoryLength.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.


trim()
------

..  include:: _ExpressionBuilderTrim.rst.txt

Using the :php:`->trim()` expression ensures that the fields are trimmed at the
database level. The following examples give a better idea of what is possible:

..  literalinclude:: _RepositoryWithTrim.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

The call to :php:`$queryBuilder->expr()-trim()` can be one of the following:

*   :php:`trim('fieldName')`
    results in :sql:`TRIM("tableName"."fieldName")`
*   :php:`trim('fieldName', TrimMode::LEADING, 'x')`
    results in :sql:`TRIM(LEADING "x" FROM "tableName"."fieldName")`
*   :php:`trim('fieldName', TrimMode::TRAILING, 'x')`
    results in :sql:`TRIM(TRAILING "x" FROM "tableName"."fieldName")`
*   :php:`trim('fieldName', TrimMode::BOTH, 'x')`
    results in :sql:`TRIM(BOTH "x" FROM "tableName"."fieldName")`
