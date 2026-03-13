.. include:: /Includes.rst.txt

.. _database-restriction-builder:

===================
Restriction builder
===================

.. contents:: Table of Contents
   :depth: 1
   :local:

Database tables in TYPO3 that can be managed in the backend have :doc:`TCA
<t3tca:Index>` definitions that specify how single fields and rows of the table
should be handled and displayed by the framework.

The `ctrl` section of a table's TCA array specifies optional framework-internal
handling of soft deletes and language overlays: For instance, when a row is
deleted in the backend using the page or :guilabel:`Content > Records` module, many tables are configured
to not drop that row entirely from the table, but to set a field (often
`deleted`) for that row from `0` to `1`. Similar mechanisms apply for start and
end times, and to language and workspace overlays as well. See the
:ref:`t3tca:ctrl` chapter in the TCA reference for details on this topic.

However, these mechanisms come at a price: developers of extensions dealing with
low-level queries must take care that overlaid or deleted rows are not included
in the result set of a simple query.

This is where this "automatic restriction" enters the picture: The construct is
created on top of native :ref:`Doctrine DBAL <Database_Introduction>` as a
TYPO3-specific extension. It automatically adds `WHERE` expressions that
suppress rows which are marked as deleted or have exceeded their "active"
lifecycle. All this is based on the TCA configuration of the affected table.


Rationale
=========

A developer might ask why they need to do all this to themselves, and why this
extra material is added on top of a low-level query layer when "just a simple
query" should be fired. The construct implements some important design goals:

*   **Simple:**
    Query creation should be easy to handle without a developer having to deal too
    much with the tedious TCA details..

*   **Cope with developer laziness:**
    If the framework would force a developer to always add casual restrictions
    for every single query, this is easy to forget. We are all lazy, aren't we?

*   **Security:**
    When in doubt, it is better to show a little too little than too much. It is
    much better to deal with a customer complaining that some records are *not*
    displayed than to show too many records. The former is "just a bug", while
    the latter can easily lead to a serious privilege escalation security issue.

*   **Automatic query upgrades:**
    If a table was originally designed without a soft delete and a delete flag
    is later added and registered in TCA, queries executed on that table will
    automatically upgrade and the according :sql:`deleted = 0` restriction will
    be added.

*   **Handing over restriction details to the framework:**
    Having the restriction expressions handled by the framework gives it the
    ability to change details without breaking the extension code. This may well
    happen in the future, and a happy little upgrade path for such cases may
    prove very useful later.

*   **Flexibility:**
    The class construct is designed in a way so that developers can extend or
    or substitute it with their own restrictions if that makes sense for
    modeling the domain in question.


Main construct
==============

The restriction builder is called whenever a :sql:`SELECT` or :sql:`COUNT`
query is executed using either :php:`\TYPO3\CMS\Core\Database\Query\QueryBuilder`
or :php:`\TYPO3\CMS\Core\Database\Connection`. The :ref:`QueryBuilder
<database-query-builder>` allows manipulation of those restrictions, while the
simplified :ref:`Connection <database-connection>` class does not. When a query
deals with multiple tables in a join, restrictions are added for all affected
tables.

Each single restriction such as a
:php:`\TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction` or a
:php:`TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction` is modeled
as a single class that implements the
:php:`\TYPO3\CMS\Core\Database\Query\Restriction\QueryRestrictionInterface`. Each
restriction looks up in TCA whether it should be applied. If so, the
according expressions are added to the :sql:`WHERE` clause when compiling the
final statement.

Multiple restrictions can be grouped into containers which implement the
:php:`\TYPO3\CMS\Core\Database\Query\Restriction\QueryRestrictionContainerInterface`.

The :php:`\TYPO3\CMS\Core\Database\Query\Restriction\DefaultRestrictionContainer`
is always added by default: It adds the

*   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction`
*   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction`,
*   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction` and the
*   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction`.

Note that this applies to all contexts in which a query is executed: It does not
matter whether a query is created from a frontend, a backend, or a
:ref:`CLI <symfony-console-commands>` call, they all add the
:php:`DefaultRestrictionContainer` unless explicitly stated otherwise by an
extension developer.

..  note::
    Having this :php:`DefaultRestrictionContainer` used everywhere is the second
    iteration of this code construct:

    The first variant automatically added contextual restrictions. For instance,
    a query triggered by a call in the backend did not add the hidden flag,
    while a query triggered in the frontend did. We quickly figured out that
    this leads to a huge mess: The distinction between frontend, backend and CLI
    is not *that* sharp in TYPO3, so for example the frontend behaves much more
    like a backend call when using the :doc:`admin panel <ext_adminpanel:Index>`.

    The currently active variant is much easier: It always adds sane defaults
    everywhere, a developer only has to deal with details if they do not fit.
    The Core Team hopes that this approach is a good balance between hidden
    magic, security, transparency, and convenience.


Restrictions
============

.. rst-class:: dl-parameters

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction` (default)
    Evaluates :php:`['ctrl']['delete']`, adds for instance
    :sql:`AND deleted = 0` if :php:`TCA['aTable']['ctrl']['delete'] = 'deleted'`
    is specified.

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction` (default)
    Evaluates :php:`['ctrl']['enablecolumns']['disabled']`, adds
    :sql:`AND hidden = 0` if `hidden` is specified as field name.

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction` (default)
    Evaluates :php:`['ctrl']['enablecolumns']['starttime']`, typically adds
    something like ``AND (`tt_content`.`starttime` <= 1475580240)``.

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction` (default)
    Evaluates :php:`['ctrl']['enablecolumns']['endtime']`.

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\FrontendGroupRestriction`
    Evaluates :php:`['enablecolumns']['fe_group']`.

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\RootlevelRestriction`
    Match records on root level, adds ``AND (`pid` = 0)``

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\WorkspaceRestriction`
    The workspace restriction limits an SQL query to only select records which
    are "online" and in live or current workspace.

..  note::
    As an important note and limitation of any workspace-related restrictions,
    fetching the exact records need to be handled after the SQL results are
    fetched, by overlaying the records with
    :php:`\TYPO3\CMS\Backend\Utility\BackendUtility::getRecordWSOL()`,
    :php:`\TYPO3\CMS\Core\Domain\Repository\PageRepository->versionOL()` or
    :php:`\TYPO3\CMS\Core\DataHandling\PlainDataResolver`.

When a restriction needs to be enforced, a restriction could implement the
interface `\TYPO3\CMS\Core\Database\Query\Restriction\EnforceableQueryRestrictionInterface`.
If a restriction implements :php:`EnforceableQueryRestrictionInterface`, the
following applies:

*   :php:`->removeAll()` will remove all restrictions except the ones that
    implement the interface :php:`EnforceableQueryRestrictionInterface`.

*   :php:`->removeByType()` will remove a restriction completely, also
    restrictions that implement the interface
    :php:`EnforceableQueryRestrictionInterface`.


QueryRestrictionContainer
=========================

.. rst-class:: dl-parameters

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\DefaultRestrictionContainer`
    Adds

    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction`
    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction`
    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction`
    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction`

    This container is always added if not told otherwise.

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer`
    Adds

    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction`
    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction`
    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction`
    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction`
    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\WorkspaceRestriction`
    -   :php:`\TYPO3\CMS\Core\Database\Query\Restriction\FrontendGroupRestriction`

    This container should be added by a developer to a query when creating
    query statements in frontend context or when handling frontend stuff from
    within :ref:`CLI <symfony-console-commands>` calls.

:php:`\TYPO3\CMS\Core\Database\Query\Restriction\LimitToTablesRestrictionContainer`
    This restriction container applies added restrictions only to the given
    table aliases. See :ref:`database-limit-restrictions-to-tables` for more
    information. Enforced restrictions are treated equally to all other
    restrictions.

..  _database-limit-restrictions-to-tables:

Limit restrictions to tables
============================

With :php:`\TYPO3\CMS\Core\Database\Query\Restriction\LimitToTablesRestrictionContainer`
it is possible to apply restrictions to a query only for a given set of tables,
or - to be precise - table aliases. Since it is a restriction container, it can
be added to the restrictions of the query builder and can hold restrictions
itself.

Examples
--------

If you want to apply one or more restrictions to only one table, that is
possible as follows. Let us say you have content in the :sql:`tt_content` table
with a relation to categories. Now you want to get all records with their
categories except those that are hidden. In this case, the hidden restriction
should apply only to the :sql:`tt_content` table, not to the :sql:`sys_category`
or :sql:`sys_category_*_mm` table.

..  code-block:: php
    :caption: EXT:some_extension/Classes/Domain/Repository/ContentRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
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
            $queryBuilder->expr()->eq(
                'scmm.uid_foreign',
                $queryBuilder->quoteIdentifier('tt.uid')
            ),
            $queryBuilder->expr()->eq(
                'scmm.uid_local',
                $queryBuilder->quoteIdentifier('sc.uid')
            ),
            $queryBuilder->expr()->eq(
                'tt.uid',
                $queryBuilder->createNamedParameter($id, Connection::PARAM_INT)
            )
        );

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

In addition, it is possible to restrict the complete set of restrictions of a
query builder to a given set of table aliases:

..  code-block:: php
    :caption: EXT:some_extension/Classes/Domain/Repository/ContentRepository.php

    // use TYPO3\CMS\Core\Database\Connection;

    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder->getRestrictions()
        ->removeAll()
        ->add(GeneralUtility::makeInstance(HiddenRestriction::class));
    $queryBuilder->getRestrictions()->limitRestrictionsToTables(['c2']);
    $queryBuilder
        ->select('c1.*')
        ->from('tt_content', 'c1')
        ->leftJoin('c1', 'tt_content', 'c2', 'c1.parent_field = c2.uid')
        ->orWhere(
            $queryBuilder->expr()->isNull('c2.uid'),
            $queryBuilder->expr()->eq(
                'c2.pid',
                $queryBuilder->createNamedParameter(1, Connection::PARAM_INT)
            )
        );

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

Which results in:

..  code-block:: sql

    SELECT "c1".*
      FROM "tt_content" "c1"
      LEFT JOIN "tt_content" "c2" ON c1.parent_field = c2.uid
      WHERE (("c2"."uid" IS NULL) OR ("c2"."pid" = 1))
        AND ("c2"."hidden" = 0))


.. _database-custom-restrictions:

Custom restrictions
===================

It is possible to add additional query restrictions by adding class names as key
to :php:`$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']`.
These restriction objects will be added to any select query executed using the
:ref:`QueryBuilder <database-query-builder>`.

If these added restriction objects additionally implement
:php:`\TYPO3\CMS\Core\Database\Query\Restriction\EnforceableQueryRestrictionInterface`
and return :php:`true` in the to be implemented method :php:`isEnforced()`,
calling :php:`$queryBuilder->getRestrictions()->removeAll()` such restrictions
will **still** be applied to the query.

If an enforced restriction must be removed, it can still be removed with
:php:`$queryBuilder->getRestrictions()->removeByType(SomeClass::class)`.

Implementers of custom restrictions can therefore have their restrictions always
enforced, or even not applied at all, by returning an empty expression in certain cases.

To add a custom restriction class, use the following snippet:

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

..  note::
    The class name must be the array key and the value must always be an array,
    which is reserved for options given to the restriction objects.

..  attention::
    Restrictions added by third-party extensions will impact the whole system.
    Therefore this API does not allow removing restrictions added by the system
    and adding restrictions should be handled with care.

Removing third party restrictions is possible, by setting the option
:php:`disabled` for a restriction to :php:`true` in global TYPO3 configuration
or :file:`ext_localconf.php` of an extension:

..  literalinclude:: _ext_localconf_remove.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

Examples
========

Often the default restrictions are sufficient. Nothing needs to be done in those
cases.

However, many backend modules still want to show disabled records and remove the
start time and end time restrictions to allow administration of those records
for an editor. A typical setup from within a backend module:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    // use TYPO3\CMS\Core\Utility\GeneralUtility;
    // use TYPO3\CMS\Core\Database\Connection;
    // use TYPO3\CMS\Core\Database\ConnectionPool;
    // use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction
    // SELECT `uid`, `bodytext` FROM `tt_content` WHERE (`pid` = 42) AND (`tt_content`.`deleted` = 0)
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    // Remove all restrictions but add DeletedRestriction again
    $queryBuilder
        ->getRestrictions()
        ->removeAll()
        ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
    $result = $queryBuilder
        ->select('uid', 'bodytext')
        ->from('tt_content')
        ->where($queryBuilder->expr()->eq(
            'pid',
            $queryBuilder->createNamedParameter($pid, Connection::PARAM_INT)
        ))
        ->executeQuery()
        ->fetchAllAssociative(();

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

The :php:`DeletedRestriction` should be kept in almost all cases. Usually, the
only extension that dismisses that flag is the recycler module to list and
resurrect deleted records. Any object implementing the
:php:`QueryRestrictionInterface` can be given to :php:`->add()`. This allows
extensions to deliver own restrictions.

An alternative to the recommended way of first removing all restrictions and
then adding needed ones again (using :php:`->removeAll()`, then :php:`->add()`)
is to kick specific restrictions with a call to :php:`->removeByType()`:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    // use TYPO3\CMS\Core\Utility\GeneralUtility;
    // use TYPO3\CMS\Core\Database\ConnectionPool;
    // use TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction
    // use TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction
    // Remove starttime and endtime, but keep hidden and deleted
    $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
    $queryBuilder
        ->getRestrictions()
        ->removeByType(StartTimeRestriction::class)
        ->removeByType(EndTimeRestriction::class);

Read :ref:`how to correctly instantiate <database-query-builder-instantiation>`
a query builder with the connection pool.

In the frontend it is often needed to swap the :php:`DefaultRestrictionContainer`
with the :php:`FrontendRestrictionContainer`:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    // use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer
    // Remove default restrictions and add list of default frontend restrictions
    $queryBuilder->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));


Note that :php:`->setRestrictions()` resets any previously specified
restrictions. Any class instance implementing
:php:`QueryRestrictionContainerInterface` can be given to
:php:`->setRestrictions()`. This allows extensions to deliver and use an custom
set of restrictions for own query statements if needed.

..  tip::
    It can be very helpful to debug the final statements created by the
    :php:`RestrictionBuilder` using :php:`debug($queryBuilder->getSQL())` right
    before the final call to :php:`$queryBuilder->executeQuery()`. Just take
    care these calls **do not**
    :ref:`end up in production <database-query-builder-get-sql>` code.
