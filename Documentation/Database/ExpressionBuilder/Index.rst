.. include:: ../../Includes.txt

.. _database-expression-builder:

ExpressionBuilder
-----------------

The `ExpressionBuilder` class is responsible to dynamically create SQL query parts
for `WHERE` and `JOIN ON` conditions.

It takes care of building query conditions while ensuring table and column names
are quoted within the created expressions / SQL fragments. It is a facade to
the actual `doctrine-dbal` `ExpressionBuilder`.

The `ExpressionBuilder` is used within the context of the :ref:`QueryBuilder <database-query-builder>`
to ensure queries are being build based on the requirements of the database platform in use.

An instance of the `ExpressionBuilder` is retrieved from the `QueryBuilder` object:

.. code-block:: php

    $expressionBuilder = $queryBuilder->expr();


It is good practice to not assign an instance of the `ExpressionBuilder` to a variable but
to use it within the code flow of the `QueryBuilder` context directly:

.. code-block:: php

    $rows = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content)
        ->select('uid', 'header', 'bodytext')
        ->from('tt_content')
        ->where(
            // `bodytext` = 'klaus' AND `header` = 'peter'
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus')),
            $queryBuilder->expr()->eq('header', $queryBuilder->createNamedParameter('peter'))
        )
        ->execute()
        ->fetchAll();


.. important::

    It is crucially important to quote values correctly to not introduce SQL injection attack
    vectors to your application. See the
    :ref:`section of the QueryBuilder <database-query-builder-create-named-parameter>` for details.


Junctions
^^^^^^^^^

* `->andX()` conjunction

* `->orX()` disjunction


Combine multiple single expressions with `AND` or `OR`. Nesting is possible, both methods are variadic and
take any number of argument which are all combined. It usually doesn't make much sense to hand over
zero or only one argument, though:

.. code-block:: php

    $queryBuilder->where(
        
    );


Comparisons
^^^^^^^^^^^


Expressions
^^^^^^^^^^^

