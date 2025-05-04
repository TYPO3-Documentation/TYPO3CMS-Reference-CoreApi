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

..  include:: _EscapeWarning.rst.txt

..  _database-expression-builder-basic-junctions:

Junctions
=========

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

..  _database-expression-builder-as:

:php:`ExpressionBuilder::as()`
------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderAs.rst.txt

Creates a statement to append a field alias to a value, identifier or sub-expression.

..  note::

    Some :php:`ExpressionBuilder` methods (like :php:`select()` and :php:`from()`) provide an argument to directly add
    the expression alias to reduce some nesting. This new method can be used for
    custom expressions and avoids recurring conditional quoting and alias appending.

..  literalinclude:: _RepositoryAs.php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

..  _database-expression-builder-concat:

:php:`ExpressionBuilder::concat()`
----------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderConcat.rst.txt

Can be used to concatenate values, row field values or expression results into
a single string value.

The created expression is built on the proper platform-specific and preferred
concatenation method, for example :sql:`field1 || field2 || field3 || ...`
for SQLite and :sql:`CONCAT(field1, field2, field3, ...)` for other database vendors.

..  include:: _EscapeWarning.rst.txt

..  literalinclude:: _RepositoryConcat.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

..  _database-expression-builder-castInt:

:php:`ExpressionBuilder::castInt()`
-----------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderCastInt.rst.txt

Can be used to create an expression which converts a value, row field value or
the result of an expression to signed integer type.

Uses the platform-specific preferred way for casting to dynamic length
character type, which means :sql:`CAST("value" AS INTEGER)` for most database vendors
except PostgreSQL. For PostgreSQL the :sql:`"value"::INTEGER` cast notation
is used.

..  literalinclude:: _RepositoryCastInt.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

..  _database-expression-builder-castText:

:php:`ExpressionBuilder::castText()`
------------------------------------

..  versionadded:: 13.3

..  todo: Add api description as soon as building code-snippets is working again

Can be used to create an expression which converts a value, row field value or
the result of an expression to type `TEXT` or a large `VARCHAR, depending on the
database system in use.

Casting is done to large :sql:`VARCHAR/CHAR` types using the :sql:`CAST/CONVERT`
or similar methods based on the used database engine.

..  include:: _EscapeWarning.rst.txt

..  literalinclude:: _RepositoryCastText.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

..  _database-expression-builder-castVarchar:

:php:`ExpressionBuilder::castVarchar()`
---------------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderCastVarchar.rst.txt

Can be used to create an expression which converts a value, row field value or
the result of an expression to varchar type with dynamic length.

Uses the platform-specific preferred way for casting to dynamic length
character type, which means :sql:`CAST("value" AS VARCHAR(<LENGTH>))`
or :sql:`CAST("value" AS CHAR(<LENGTH>))` is used, except for PostgreSQL.
For PostgreSQL the :sql:`"value"::INTEGER` cast notation is used.

..  include:: _EscapeWarning.rst.txt

..  literalinclude:: _RepositoryCastVarChar.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php


..  _database-expression-builder-if:

:php:`ExpressionBuilder::if()`
------------------------------

..  versionadded:: 13.3

..  include:: _ExpressionBuilderIf.rst.txt

This method is used for "if-then-else" expressions. These are
translated into :sql:`IF` or :sql:`CASE` statements depending on the
database engine in use.

..  warning::
    No automatic quoting or escaping is done for the condition and true/false
    part. Extension authors need to ensure proper quoting for each part or use
    API calls for doing the quoting, for example the
    :php:`TYPO3\CMS\Core\Database\Query\Expression\CompositeExpression` or
    :ref:`ExpressionBuilder calls <database-expression-builder-basic-comparisons>`.

Example:

..  code-block:: php

    // use TYPO3\CMS\Core\Database\Connection;

    $queryBuilder
        ->selectLiteral(
            $queryBuilder->expr()->if(
                $queryBuilder->expr()->eq(
                    'hidden',
                    $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)
                ),
                $queryBuilder->quote('page-is-visible'),
                $queryBuilder->quote('page-is-not-visible'),
                'result_field_name'
            ),
        )
        ->from('pages');

Result with MySQL/MariaDB:

..  code-block:: sql

    SELECT
        (IF(`hidden` = 0, 'page-is-visible', 'page-is-not-visible')) AS `result_field_name`
        FROM `pages`


..  _database-expression-builder-left:

:php:`ExpressionBuilder::left()`
--------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderLeft.rst.txt

Extract :php:`$length` characters of :php:`$value` from the left side.

Creates a :sql:`LEFT("value", number_of_chars)` expression for all supported
database vendors except SQLite, where :sql:`substring("value", start[, number_of_chars])`
is used to provide a compatible expression.

..  tip::

    For other sub string operations, :php:`\Doctrine\DBAL\Platforms\AbstractPlatform::getSubstringExpression()`
    can be used. Synopsis: :php:`getSubstringExpression(string $string, string $start, ?string $length = null): string`.


..  _database-expression-builder-leftPad:

:php:`ExpressionBuilder::leftPad()`
-----------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderLeftPad.rst.txt

Left-pad the value or sub-expression result with :php:`$paddingValue`, to a total
length of :php:`$length`.

SQLite does not support :sql:`LPAD("value", length, "paddingValue")`, therefore a
more complex compatible replacement expression construct is created.

..  include:: _EscapeWarning.rst.txt

..  literalinclude:: _RepositoryLeftPad.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php


..  _database-expression-builder-length:

:php:`ExpressionBuilder::length()`
----------------------------------

..  include:: _ExpressionBuilderLength.rst.txt

The :php:`length()` string function can be used to return the length of a
string in bytes.

..  literalinclude:: _RepositoryLength.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.
See available :ref:`parameter types <database-connection-parameter-types>`.

..  _database-expression-builder-repeat:

:php:`ExpressionBuilder::repeat()`
----------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderRepeat.rst.txt

Create a statement to generate a value repeating defined :php:`$value` for
:php:`$numberOfRepeats` times. This method can be used to provide the
repeat number as a sub-expression or calculation.

:sql:`REPEAT("value", numberOfRepeats)` is used to build this expression for all database
vendors except SQLite for which the compatible replacement construct expression
:sql:`REPLACE(PRINTF('%.' || <valueOrStatement> || 'c', '/'),'/', <repeatValue>)`
is used, based on :sql:`REPLACE()` and the built-in :sql:`printf()`.

..  include:: _EscapeWarning.rst.txt

..  literalinclude:: _RepositoryRepeat.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

..  _database-expression-builder-right:

:php:`ExpressionBuilder::right()`
---------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderRight.rst.txt

Extract :php:`$length` characters of :php:`$value` from the right side.

Creates a :sql:`RIGHT("value", length)` expression for all supported
database vendors except SQLite, where :sql:`substring("value", start_of_string[, length])`
is used to provide a compatible expression.

..  include:: _EscapeWarning.rst.txt

..  literalinclude:: _RepositoryRight.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php


..  _database-expression-builder-rightPad:

:php:`ExpressionBuilder::rightPad()`
------------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderRightPad.rst.txt

Right-pad the value or sub-expression result with :php:`$paddingValue`, to a
total length of :php:`$length`.

SQLite does not support :sql:`RPAD("value", length, "paddingValue")`, therefore a
more complex compatible replacement expression construct is created.

..  include:: _EscapeWarning.rst.txt

..  literalinclude:: _RepositoryRightPad.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

..  _database-expression-builder-space:

:php:`ExpressionBuilder::space()`
---------------------------------

..  versionadded:: 13.1

..  include:: _ExpressionBuilderSpace.rst.txt

Create a statement containing :php:`$numberOfSpaces` space characters.

The :sql:`SPACE(numberOfSpaces)` expression is used for MariaDB and MySQL and
:php:`ExpressionBuilder::repeat()` expression as fallback for PostgreSQL
and SQLite.

..  include:: _EscapeWarning.rst.txt

..  literalinclude:: _RepositorySpace.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyTableRepository.php

..  _database-expression-builder-trim:

:php:`ExpressionBuilder::trim()`
--------------------------------

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
