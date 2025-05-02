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
                    $queryBuilder->createNamedParameter('lorem')
                )
            );

        debug($queryBuilder->getSql());

        $result = $queryBuilder->executeQuery();

*   Doctrine DBAL throws exceptions if something goes wrong when calling API methods.
    The exception type is :php:`\Doctrine\DBAL\Exception`. Typical extensions should
    usually not catch such exceptions but let it bubble up to be handled by the
    global TYPO3 core error and exception handling: They most often indicate a
    broken connection, database schema or programming error and extensions should
    usually not try to hide away or escalate them on their own.

*   :php:`count() <database-query-builder-count>` query types using the
    :ref:`query builder <database-query-builder>` normally call
    :ref:`->fetchOne() <database-result-fetch-one>` to receive the count value.
    The :ref:`count() <database-connection-count>` method of the
    :ref:`Connection <database-connection>` object does this automatically and
    returns the result of the count value directly.
