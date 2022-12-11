..  include:: /Includes.rst.txt

..  _database-tips-and-tricks:

=======================
Various tips and tricks
=======================

*   Use :guilabel:`Find usages` of PhpStorm for examples! The source code of the
    Core is a great way to learn how specific methods of the API are used. In
    PhpStorm it is extremely helpful to right-click on a single method and list
    all method usages with :guilabel:`Find usages`. This is especially handy
    to quickly see usage examples for complex methods like :php:`join()`
    from the :ref:`query builder <database-query-builder>`.

*   :sql:`INSERT`, :sql:`UPDATE` and :sql:`DELETE` statements are often better
    to read and write using the :ref:`Connection <database-connection>` object
    instead of the :ref:`query builder <database-query-builder>`.

*   :sql:`SELECT DISTINCT aField` is not supported but can be substituted with a
    :php:`->groupBy('aField')`.

*   :ref:`getSql() <database-query-builder-get-sql>` and
    :ref:`executeQuery() <database-query-builder-execute-query>` /
    :ref:`executeStatement() <database-query-builder-execute-statement>` can be
    used after each other during development to simplify debugging:

    ..  code-block:: php
        :caption: EXT:my_extension/Classes/Domain/Repository/MyRepository.php

        $queryBuilder
            ->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'bodytext',
                    $queryBuilder->createNamedParameter('klaus')
                )
            );

        debug($queryBuilder->getSql());

        $result = $queryBuilder->executeQuery();

*   Doctrine DBAL throws exceptions if something goes wrong when calling
    :ref:`executeQuery() <database-query-builder-execute-query>` or
    :ref:`executeStatement() <database-query-builder-execute-statement>`. The
    exception type is :php:`\Doctrine\DBAL\Exception`, which can be caught and
    transferred to a better error message if the application should expect
    query errors. Note that this is not good habit and often indicates an
    architectural flaw in the application at a different layer.

*   :php:`count() <database-query-builder-count>` query types using the
    :ref:`query builder <database-query-builder>` normally call
    :ref:`->fetchOne() <database-result-fetch-one>` to receive the count value.
    The :ref:`count() <database-connection-count>` method of the
    :ref:`Connection <database-connection>` object does this automatically and
    returns the result of the count value directly.
