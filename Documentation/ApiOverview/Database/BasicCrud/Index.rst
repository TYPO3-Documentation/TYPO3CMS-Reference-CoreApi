.. include:: ../../../Includes.txt

.. _database-basic-crud:


Basic CRUD
----------

A list of basic usage examples of the query API. This is just a kickstart.
Details on the single methods are found in the following chapters, especially
:ref:`QueryBuilder <database-query-builder>` and :ref:`Connection <database-connection>`.

.. note::

    The examples use the shorthand syntax for class names. Please refer to :ref:`Class overview <database-class-overview>`       for the full namespace.


INSERT a row
^^^^^^^^^^^^

A straight insert to a table:

.. code-block:: php

    GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content')
        ->insert(
            'tt_content',
            [
                'pid' => (int)42,
                'bodytext' => 'bernd',
            ]
        );

.. code-block:: sql

    INSERT INTO `tt_content` (`pid`, `bodytext`) VALUES ('42', 'bernd')


SELECT a single row
^^^^^^^^^^^^^^^^^^^

Straight fetch of a single row from `tt_content` table:

.. code-block:: php

    $uid = 4;
    $row = GeneralUtility::makeInstance(ConnectionPool::class)
        ->getConnectionForTable('tt_content')
        ->select(
            ['uid', 'pid', 'bodytext'], // fields to select
            'tt_content', // from
            [ 'uid' => (int)$uid ] // where
        )
        ->fetch();


Result in $row:

.. code-block:: php

    array(3 items)
       uid => 4 (integer)
       pid => 35 (integer)
       bodytext => 'some content' (12 chars)


The engine quotes field names, adds default TCA restrictions like "deleted=0",
and prepares a query executed with this final statement:

.. code-block:: sql

    SELECT `uid`, `pid`, `bodytext`
        FROM `tt_content`
        WHERE (`uid` = '4')
            AND ((`tt_content`.`deleted` = 0)
            AND (`tt_content`.`hidden` = 0)
            AND (`tt_content`.`starttime` <= 1473447660)
            AND ((`tt_content`.`endtime` = 0) OR (`tt_content`.`endtime` > 1473447660)))


.. note::

   Default restrictions `deleted`, `hidden`, `startime` and `endtime` based on `TCA` setting of a table
   are only applied to `select()` calls, they are *not* added for `delete()` or other query types.


SELECT multiple rows with some WHERE magic
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Advanced query using the `QueryBuilder` and manipulating the default restrictions:

.. code-block:: php

    $uid = 4;
    // Get a query builder for a query on table "tt_content"
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
    // Remove all default restrictions (delete, hidden, starttime, stoptime), but add DeletedRestriction again
    $queryBuilder->getRestrictions()
        ->removeAll()
        ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
    // Execute a query with "bodytext=klaus OR uid=4" and proper quoting
    $rows = $queryBuilder
        ->select('uid', 'pid', 'bodytext')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus')),
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
        )
        ->execute()
        ->fetchAll();

Result in $rows:

.. code-block:: php

   array(2 items)
      0 => array(3 items)
         uid => 4 (integer)
         pid => 35 (integer)
         bodytext => 'bernd' (5 chars)
      1 => array(3 items)
         uid => 366 (integer)
         pid => 13 (integer)
         bodytext => 'klaus' (5 chars)


The executed query looks like:

.. code-block:: sql

    SELECT `uid`, `pid`, `bodytext`
        FROM `tt_content`
        WHERE ((`bodytext` = 'klaus') OR (`uid` = 4))
            AND (`tt_content`.`deleted` = 0)


UPDATE multiple rows
^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content')
        ->update(
            'tt_content',
            [ 'bodytext' => 'bernd' ], // set
            [ 'bodytext' => 'klaus' ] // where
        );


.. code-block:: sql

    UPDATE `tt_content` SET `bodytext` = 'bernd' WHERE `bodytext` = 'klaus'


DELETE a row
^^^^^^^^^^^^

.. code-block:: php

    GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content')
        ->delete(
            'tt_content', // from
            [ 'uid' => (int)4711 ] // where
        );


.. code-block:: sql

    DELETE FROM `tt_content` WHERE `uid` = '4711'

