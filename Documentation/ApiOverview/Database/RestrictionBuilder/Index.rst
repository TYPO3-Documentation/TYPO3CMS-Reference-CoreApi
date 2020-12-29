.. include:: /Includes.rst.txt

.. _database-restriction-builder:

==================
RestrictionBuilder
==================

Database tables in `TYPO3 CMS` that can be administrated in the backend come with
:ref:`TCA <t3tca:start>` definitions that
specify how single fields and rows of the table should be handled and displayed
by the framework.

The `ctrl` section of a tables `TCA` array specifies optional framework internal
handling of soft deletes and language overlays: For instance, if a row in the backend
is deleted using the page or list module, many tables are configured to not
entirely drop that row from the table, instead a field (often `deleted`) is set
from zero to one for that row. Similar mechanics kick in for start- and endtime as
well as language and workspace overlays. See the :ref:`t3tca:ctrl` chapter in the
TCA reference for details on this topic.

These mechanics however come with a price tag attached to it: Extension developers
dealing with low-level query stuff must take care overlayed or deleted rows
are not in the result set of a casual query.

This is where this "automatic restriction" stuff kicks in: The construct is created
on top of native Doctrine DBAL as `TYPO3 CMS` specific extension. It automatically
adds `WHERE` expressions that suppress rows which are marked as deleted or exceeded
their "active" life cycle. All that is based on the `TCA` configuration of the affected table.


Rationale
=========

A developer may ask why she has to go through all this and why this additional stuff
is added on a low-level query layer, when "just a simple query" should be fired. The
construct implements some important design goals:

* **Simple:**
  Query creation should be easy to use without forcing a developer thinking
  too much about those nasty `TCA` details.

* **Cope with developer laziness:**
  If the framework would force a developer to always add casual
  restrictions for each and every query, this is easy to forget. We're all lazy, are we?

* **Security:**
  If in doubt, it is better to show a little too less than too much. It is
  much better to deal with a customer who complains some records are *not* shown than
  to show too many records. The former is "just a bug" while the latter can easily
  escalate to a serious privilege escalation security issue.

* **Automatic query upgrades:**
  If a table was designed without soft-delete in the first
  place and later a deleted flag is added and registered in `TCA`, queries executed
  on that table will automatically upgrade and add the according `deleted = 0` restriction.

* **Handing over restriction details to the framework:**
  Having the restriction expressions
  done by the framework gives it the opportunity to change details without breaking
  extension code. This may very well happen in the future and having a happy little
  upgrade path for such cases in place may become very handy later.

* **Flexibility:**
  The class construct is created in a way that allows developers to extend
  or substitute it with own restrictions if that is useful to model the domain in question.


Main Construct
==============

The restriction builder is called whenever a `SELECT` or `COUNT` query is executed through
either the `QueryBuilder` or `Connection`. The `QueryBuilder` allows manipulation of those
restrictions while the simplified `Connection` class does not. If a query deals with multiple
tables in a join, restrictions for all affected tables are added.

Each single restriction like a `DeletedRestriction` or a `StartTimeRestriction` is modeled as
a single class implementing the `QueryRestrictionInterface`. Each restriction looks up in
`TCA` if it should kick in. If so, it adds according expressions to the `WHERE` clause when
the final statement is compiled.

Multiple restrictions can be grouped in containers which implement the
`QueryRestrictionContainerInterface`.

The `DefaultRestrictionContainer` is always added by ... uuhm ... default: It adds the
`DeletedRestriction`, the `HiddenRestriction`, the `StartTimeRestriction` and the
`EndTimeRestriction`. Note this is true for all contexts a query is executed in: It does not
matter whether a query is created from within a frontend, a backend or a cli call, they all add
the `DefaultRestrictionContainer` if not explicitly told otherwise by an extension developer.

.. note::

    Having this `DefaultRestrictionContainer` used everywhere is the second iteration of
    that code construct:

    The first variant automatically added restrictions based on context. For instance, a
    query fired by a call that is executed in the backend did not add the hidden flag, while
    a query fired from within a frontend call did so. We quickly figured this ends up in a
    huge mess: The distinction between frontend, backend and cli is not *that* sharp in `TYPO3`,
    as example the frontend behaves much more like a backend call if the admin panel is used.

    The currently active variant is much easier: It always adds sane defaults everywhere, a
    developer only has to deal with details if they don't fit. The Core Team hopes this
    approach is a good balance between hidden magic, security, transparency and convenience.


Restrictions
============

* `DeletedRestriction`:
  (default) Evaluates :php:`['ctrl']['delete']`, adds for instance `AND deleted = 0` if
  :php:`TCA['aTable']['ctrl']['delete'] = 'deleted'` is specified.

* `HiddenRestriction`:
  (default) Evaluates :php:`['ctrl']['enablecolumns']['disabled']`, adds `AND hidden = 0`
  if `hidden` is specified as field name.

* `StartTimeRestriction`:
  (default) Evaluates :php:`['ctrl']['enablecolumns']['starttime']`, typically adds
  something like ``AND (`tt_content`.`starttime` <= 1475580240)``.

* `EndTimeRestriction`:
  (default) Evaluates :php:`['ctrl']['enablecolumns']['endtime']`.

* `FrontendGroupRestriction`:
  Evaluates :php:`['enablecolumns']['fe_group']`.

* `RootlevelRestriction`:
  Match records on root level, adds ``AND (`pid` = 0)``

* `BackendWorkspaceRestriction`:
  Determines the current workspace a backend user is working in and adds
  a couple of restrictions to select only records of that workspace if the table supports workspaced records.

* `FrontendWorkspaceRestriction`:
  Restriction to filter records for fronted workspaces preview.

* `WorkspaceRestriction`: `WorkspaceRestriction` has been added to overcome downsides of
   `FrontendWorkspaceRestriction` and `BackendWorkspaceRestriction`. The workspace restriction
   limits a SQL query to only select records which are "online" and in live or current
   workspace.

.. note::

   As an important note and limitation of any workspace-related restrictions, fetching the exact
   records need to be handled after the SQL results are fetched, by overlaying the records with
   :php:`BackendUtility::getRecordWSOL()`, :php:`PageRepository->versionOL()` or `PlainDataResolver`.

If a restriction needs to be enforced, a restriction could implement the interface `EnforceableQueryRestrictionInterface`.
If a restriction implements `EnforceableQueryRestrictionInterface`, the following applies:

* `->removeAll()` will remove all restrictions except the ones that implement the interface `EnforceableQueryRestrictionInterface`

* `->removeByType()` will remove a restriction completely, also restrictions that implement the interface `EnforceableQueryRestrictionInterface`


QueryRestrictionContainer
=========================

* `DefaultRestrictionContainer`: Add `DeletedRestriction`, `HiddenRestriction`, `StartTimeRestriction`
  and `EndTimeRestriction`. This container is always added if not told otherwise.

* `FrontendRestrictionContainer`: Adds `DeletedRestriction`, `HiddenRestriction`, `StartTimeRestriction`,
  `EndTimeRestriction`, `FrontendWorkspaceRestriction` and `FrontendGroupRestriction`. This container should be
  be added by a developer to a query if creating query statements in frontend context or if handling
  frontend stuff from within cli calls.

limitRestrictionsToTables()
===========================

With the :php:`\TYPO3\CMS\Core\Database\Query\Restriction\LimitToTablesRestrictionContainer`
it is possible to apply restrictions to a query only for a given set of tables, or - to be precise - table aliases.
Since it is a restriction container, it can be added to the restrictions of the query builder and
can hold restrictions itself.


Examples
========

Often the default restrictions are sufficient. Nothing needs to be done in those cases.

However, many backend modules still want to show disabled records and remove the starttime and endtime
restrictions to allow administration of those records for an editor. A typical setup from within a
backend module::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction
   // SELECT `uid`, `bodytext` FROM `tt_content` WHERE (`pid` = 42) AND (`tt_content`.`deleted` = 0)
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   // Remove all restrictions but add DeletedRestriction again
   $queryBuilder
      ->getRestrictions()
      ->removeAll()
      ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
   $result = $queryBuilder
      ->select('uid', 'bodytext')
      ->from('tt_content')
      ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid, \PDO::PARAM_INT)))
      ->execute()
      ->fetchAll();

The `DeletedRestriction` should be kept in almost all cases. Usually, the only extension that dismiss
that flag is the recycler module to list and resurrect deleted records. Any object implementing the
`QueryRestrictionInterface` can be given to :php:`->add()`. This allows extensions to deliver own restrictions.

An alternative to the recommended way of first removing all restrictions and then adding needed
ones again (using :php:`->removeAll()`, then :php:`->add()`) is to kick specific restrictions with a call to
:php:`->removeByType()`::

   // use TYPO3\CMS\Core\Utility\GeneralUtility;
   // use TYPO3\CMS\Core\Database\ConnectionPool;
   // use TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction
   // use TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction
   // Remove starttime and endtime, but keep hidden and deleted
   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder
      ->getRestrictions()
      ->removeByType(StartTimeRestriction::class)
      ->removeByType(EndTimeRestriction::class);


In the frontend it is often needed to swap the `DefaultRestrictionContainer` with the
`FrontendRestrictionContainer`::

   // use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer
   // Kick default restrictions and add list of default frontend restrictions
   $queryBuilder->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));


Note that :php:`->setRestrictions()` resets any previously specified restrictions. Any class instance implementing
`QueryRestrictionContainerInterface` can be given to :php:`->setRestrictions()`. This allows extensions to
deliver and use an own set of restrictions for own query statements if needed.

.. tip::

   It can be very helpful to debug the final statements created by the `RestrictionBuilder` using
   :php:`debug($queryBuilder->getSQL())` right before the final call to :php:`$queryBuilder->execute()`. Just
   take care these calls **do not** :ref:`end up in production <database-query-builder-get-sql>` code.


If you want to apply one or more restriction/s to only one table, that is possible as follows. Let's say,
that you have content in table `tt_content` with a relation to categories. Now you would like to get all records with their categories, except those that are hidden. The hidden restriction in this case should only apply to
the :sql:`tt_content` table, not to the :sql:`sys_category` or :sql:`sys_category_*_mm` table.::

   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder->getRestrictions()
       ->removeByType(HiddenRestriction::class)
       ->add(
           GeneralUtility::makeInstance(LimitToTablesRestrictionContainer::class)
               ->addForTables(GeneralUtility::makeInstance(HiddenRestriction::class), ['tt'])
       );
   $queryBuilder->select('tt.uid', 'tt.header', 'sc.title')
       ->from('tt_content', 'tt')
       ->from('sys_category', 'sc')
       ->from('sys_category_record_mm', 'scmm')
       ->where(
           $queryBuilder->expr()->eq('scmm.uid_foreign', $queryBuilder->quoteIdentifier('tt.uid')),
           $queryBuilder->expr()->eq('scmm.uid_local', $queryBuilder->quoteIdentifier('sc.uid')),
           $queryBuilder->expr()->eq('tt.uid', $queryBuilder->createNamedParameter($id, \PDO::PARAM_INT))
       );


In this example the :php:`HiddenRestriction` is only applied to :sql:`tt` table alias of :sql:`tt_content`.

Furthermore it is possible to restrict the complete set of restrictions of a query builder to a
given set of table aliases.

.. code-block:: php

   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(HiddenRestriction::class));
   $queryBuilder->getRestrictions()->limitRestrictionsToTables(['c2']);
   $queryBuilder
      ->select('c1.*')
      ->from('tt_content', 'c1')
      ->leftJoin('c1', 'tt_content', 'c2', 'c1.parent_field = c2.uid')
      ->orWhere($queryBuilder->expr()->isNull('c2.uid'), $queryBuilder->expr()->eq('c2.pid', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT)));

Which will result in:

.. code-block:: sql

   SELECT "c1".*
   FROM "tt_content" "c1"
   LEFT JOIN "tt_content" "c2" ON c1.parent_field = c2.uid
   WHERE (("c2"."uid" IS NULL) OR ("c2"."pid" = 1)) AND ("c2"."hidden" = 0))

