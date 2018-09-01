.. include:: ../../../Includes.txt

.. _database-migration:

Migrating from TYPO3_DB
-----------------------

This chapter is for those poor souls who want to migrate old and busted `$GLOBALS['TYPO3_DB']`
calls to new hotness `doctrine-dbal` based API.

It tries to give some hints on typical pitfalls and areas a special eye should be kept on.

Migration of a single extension is finished if a search for `$GLOBALS['TYPO3_DB']` does
not return hits anymore. This search is the most simple entry point to see which areas need work.


Compare raw queries
^^^^^^^^^^^^^^^^^^^

The main goal during migration is usually to fire a logically identical query. One recommended
and simple approach to verify this is to note down and compare the queries at the lowest possible
layer. In $GLOBALS['TYPO3_DB'], the final query statement is usually retrieved by removing the
`exec_` part from the method name, in `doctrine` method :php:`QueryBuilder->getSQL()` can be used::

   // Initial code:
   $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'index_fulltext', 'phash=' . (int)$phash);

   // Remove 'exec_' and debug SQL:
   debug($GLOBALS['TYPO3_DB']->SELECTquery('*', 'index_fulltext', 'phash=' . (int)$phash));
   // Returns:
   'SELECT * FROM index_fulltext WHERE phash=42'

   // Migrate to doctrine and debug SQL:
   // 'SELECT * FROM index_fulltext WHERE phash=42'
   $queryBuilder->select('*')
   ->from('index_fulltext')
   ->where(
      $queryBuilder->expr()->eq('phash', $queryBuilder->createNamedParameter($pash, \PDO::PARAM_INT))
   );
   debug($queryBuilder->getSQL());


The above example returns the exact same query as before. This is not always as trivial to see
since `WHERE` clauses are often in a different order. This especially happens if the
:ref:`RestrictionBuilder <database-restriction-builder>` is involved. Since the restrictions
are crucial and can easily go wrong it is advised to keep an eye on those where parts during
transition.


enableFields() and deleteClause()
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

:php:`BackendUtility::deleteClause()` adds `deleted=0` if `['ctrl']['deleted']` is specified in the
table's `TCA`. The method call *should* be removed during migration. If there is no other restriction
method involved in the old call like `enableFields()`, the migrated code typically removes all
doctrine default restrictions and just adds the `DeletedRestriction` again::

   // Before:
   $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      'uid, TSconfig',
      'pages',
      'TSconfig != \'\''
         . BackendUtility::deleteClause('pages'),
      'pages.uid'
   );

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction
   // After:
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
   $queryBuilder
      ->getRestrictions()
      ->removeAll()
      ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
   $res = $queryBuilder->select('uid', 'TSconfig')
      ->from('pages')
      ->where($queryBuilder->expr()->neq('TSconfig', $queryBuilder->createNamedParameter('')))
      ->groupBy('uid')
      ->execute();


`BackendUtility::versioningPlaceholderClause('pages')` is typically substituted with the
`BackendWorkspaceRestriction`. Example very similar to the above one::

   // Before:
   $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      'uid, TSconfig',
      'pages',
      'TSconfig != \'\''
         . BackendUtility::deleteClause('pages')
         . BackendUtility::versioningPlaceholderClause('pages'),
      'pages.uid'
   );

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction
   // use TYPO3\CMS\Core\Database\Query\Restriction\BackendWorkspaceRestriction
   // After:
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
   $queryBuilder
      ->getRestrictions()
      ->removeAll()
      ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
      ->add(GeneralUtility::makeInstance(BackendWorkspaceRestriction::class));
   $res = $queryBuilder->select('uid', 'TSconfig')
      ->from('pages')
      ->where($queryBuilder->expr()->neq('TSconfig', $queryBuilder->createNamedParameter('')))
      ->groupBy('uid')
      ->execute();


:php:`BackendUtility::BEenableFields()` in combination with :php:`BackendUtility::deleteClause()` adds the same
calls as the `DefaultRestrictionContainer`. No further configuration needed::

   // Before:
   $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
      'title, content, crdate',
      'sys_news',
      '1=1'
         . BackendUtility::BEenableFields($systemNewsTable)
         . BackendUtility::deleteClause($systemNewsTable)
   );

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // After:
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
      ->getQueryBuilderForTable('sys_news');
   $queryBuilder
      ->select('title', 'content', 'crdate')
      ->from('sys_news')
      ->execute();


:php:`cObj->enableFields()` in frontend context is typically directly substituted with
`FrontendRestrictionContainer`::

   // Before:
   $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      '*', $table,
      'pid=' . (int)$pid
         . $this->cObj->enableFields($table)
   );

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer
   // After:
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
   $queryBuilder->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
   $queryBuilder->select('*')
      ->from($table)
      ->where(
         $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid, \PDO::PARAM_INT))
      )
   );


From ->exec_UDATEquery() to ->update()
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Most often, the easiest way to migrate a `$GLOBALS['TYPO3_DB']->exec_UDATEquery()` is to use
:php:`$connection->update()`::

    // Before:
    $database->exec_UPDATEquery(
        'aTable', // table
        'uid = 42', // where
        [ 'aField' => 'newValue' ] // value array
    );

    // After:
    $connection->update(
        'aTable', // table
        [ 'aField' => 'newValue' ], // value array
        [ 'uid' => 42 ] // where
    );

.. warning::
    If switching from :php:`exec_UPDATEquery()` to :ref:`update <database-connection-update>`, the
    order of arguments change, `where` and `values` are swapped!


Result set iteration
^^^^^^^^^^^^^^^^^^^^

The `exec_*` calls return a resource object that is typically iterated over using :php:`sql_fetch_assoc()`.
This is typically changed to :php:`->fetch()` on the `Statement` object::

   // Before:
   $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(...);
   while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
      // Do something
   }

   // After:
   $statement = $queryBuilder->execute();
   while ($row = $statement->fetch()) {
      // Do something
   }


sql_insert_id()
^^^^^^^^^^^^^^^

It is sometimes needed to fetch the new `uid` of a just added record to further work with that row.
In `TYPO3_DB` this was done with a call to :php:`->sql_insert_id()` after a :php:`->exec_INSERTquery()` call
on the same resource. :php:`->lastInsertId()` can be used instead::

   // Before:
   $GLOBALS['TYPO3_DB']->exec_INSERTquery(
      'pages',
      [
         'pid' => 0,
         'title' => 'Home',
      ]
   );
   $pageUid = $GLOBALS['TYPO3_DB']->sql_insert_id();

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // After:
   $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
   $databaseConnectionForPages = $connectionPool->getConnectionForTable('pages');
   $databaseConnectionForPages->insert(
      'pages',
      [
         'pid' => 0,
         'title' => 'Home',
       ]
   );
   $pageUid = (int)$databaseConnectionForPages->lastInsertId('pages');


fullQuoteStr()
^^^^^^^^^^^^^^

:php:`->fullQuoteStr()` is rather straight changed to a :php:`->createNamedParameter()`, typical case::

   // Before:
   $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      'uid, title',
      'tt_content',
      'bodytext = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr('horst')
   );

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // After:
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $statement = $queryBuilder
      ->select('uid', 'title')
      ->from('tt_content')
      ->where(
         $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('horst'))
      )
      ->execute();


ext_tables.sql
^^^^^^^^^^^^^^

The schema migrator that compiles :file:`ext_tables.sql` files from all loaded extensions and compares them with
current schema definitions in the database has been fully rewritten. It mostly should work as before, some
specific fields however tend to grow a little larger on `mysql` platforms than before. This usually
shouldn't have negative side effects, typically no :file:`ext_tables.sql` changes are needed when migrating an
extension to the new query API.


extbase QueryBuilder
^^^^^^^^^^^^^^^^^^^^

The `extbase` internal `QueryBuilder` used in `Repositories` still exists and works a before. There is
usually no manual migration needed. It is theoretically possible to use the doctrine based query builder
object in Extbase which can become handy since the new one is much more feature rich, but that topic
didn't yet fully settle in the core and no general recommendation can be given yet.
