:navigation-title: Queries

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Queries
..  _extbase-persistence-queries:

==================================
Querying the database with Extbase
==================================

Most of what an extension does with the database is *reading* it: fetching the
records a list view shows, the single record behind a detail page, the handful
that match a filter. In Extbase you do this by building a **query** on a
repository and executing it.

The built-in find methods (:php:`findAll()`, :php:`findBy()`, :php:`findByUid()`)
cover the simplest cases and are documented with the repository itself:

..  seealso::

    `The Extbase repository <https://docs.typo3.org/permalink/extbase-domain-repository>`_ — what a repository is, the built-in find methods, and injecting it into a controller.

This page covers everything beyond those: writing your own query methods with
:php:`createQuery()`, constraining and ordering the result, and then the parts
that decide *which* records a query can even see — storage pages, language,
visibility — followed by paging, persisting and debugging.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-persistence-queries-build:

Building a query with createQuery()
===================================

When :php:`findBy(['published' => true])` is not expressive enough — you need a
range, a pattern, or a combination of conditions — write a method on the
repository that builds the query itself. Every custom query follows the same
three steps:

#.  **Create** a query object with :php:`$this->createQuery()`. It is already
    bound to this repository's model and its storage pages.
#.  **Constrain** it with :php:`matching()`, passing one constraint built from
    the query's own constraint methods (:php:`equals()`, :php:`like()`,
    :php:`greaterThan()`, …).
#.  **Execute** it with :php:`execute()`, which returns a
    :php:`\TYPO3\CMS\Extbase\Persistence\QueryResultInterface` you can iterate
    and count.

..  literalinclude:: _snippets/_FindPublished.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

The method lives on the repository because the repository is the only place
that should talk to the database. The controller calls
:php:`$conferenceRepository->findPublished()` and never sees the query.


..  _extbase-persistence-queries-constraints:

Constraining the result
-----------------------

A *constraint* is one condition the records must satisfy. The query object
creates them — each method returns a constraint and does not change the query
until you hand it to :php:`matching()`. In every method the first argument is a
**model property name**, not a database column name; Extbase maps it for you.

In the reference below, each PHP line is the constraint you pass to
:php:`matching()` — as in :php:`$query->matching($query->equals(...))`. The
generated SQL shows the :sql:`WHERE` fragment Extbase produces **on MariaDB**.
Extbase always binds values as named parameters; the SQL here shows the values
inlined as they would land, for readability. The page restrictions Extbase adds
(storagePid, enable fields) are omitted for clarity. Other database platforms may
differ — most visibly PostgreSQL, which uses :sql:`ILIKE` for :php:`like()`.

..  confval-menu::
    :name: extbase-query-constraints

    ..  confval:: equals(string $property, mixed $value, bool $caseSensitive = true)
        :name: query-equals

        Exact match. If :php:`$value` is :php:`null`, a strict :sql:`IS NULL`
        check is generated instead. For string properties, pass :php:`false` as
        the third argument to match case-insensitively.

        ..  code-block:: php

            $query->equals('published', true)

        ..  code-block:: sql

            `published` = 1

    ..  confval:: like(string $property, string $value)
        :name: query-like

        Pattern match on a string property. Use :php:`%` as the wildcard. Using
        :php:`like()` on a non-string property throws an
        :php-short:`\TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException`.

        ..  code-block:: php

            $query->like('title', '%symfony%')

        ..  code-block:: sql

            `title` LIKE '%symfony%'

    ..  confval:: in(string $property, array $values)
        :name: query-in

        Matches when the property equals any value in the array. An empty array
        never matches.

        ..  code-block:: php

            $query->in('uid', [4, 8, 15])

        ..  code-block:: sql

            `uid` IN (4, 8, 15)

    ..  confval:: contains(string $property, mixed $value)
        :name: query-contains

        Matches when a multivalued property (an :php:`ObjectStorage` relation)
        contains the given object. Passing :php:`null` never matches. Unlike the
        scalar comparisons, this resolves through the relation: Extbase joins the
        MM table (or matches the foreign key) for the related object's UID.

        ..  code-block:: php

            $query->contains('speakers', $speaker)

        ..  code-block:: sql

            `uid` IN (
                SELECT `uid_local` FROM `tx_myextension_conference_speaker_mm`
                WHERE `uid_foreign` = 42
            )

    ..  confval:: greaterThan(string $property, mixed $value)
        :name: query-greaterthan

        Strictly greater than the value.

        ..  code-block:: php

            $query->greaterThan('seats', 100)

        ..  code-block:: sql

            `seats` > 100

    ..  confval:: greaterThanOrEqual(string $property, mixed $value)
        :name: query-greaterthanorequal

        Greater than or equal — the usual building block for an open-ended
        "from this date onward" range. A :php:`DateTimeImmutable` is bound
        according to the column type: a Unix timestamp for an integer column
        (shown below), or a formatted string for a :sql:`datetime` column.

        ..  code-block:: php

            $query->greaterThanOrEqual('conferenceDate', new \DateTimeImmutable('today'))

        ..  code-block:: sql

            `conference_date` >= 1782518400

    ..  confval:: lessThan(string $property, mixed $value)
        :name: query-lessthan

        Strictly less than the value.

        ..  code-block:: php

            $query->lessThan('seats', 50)

        ..  code-block:: sql

            `seats` < 50

    ..  confval:: lessThanOrEqual(string $property, mixed $value)
        :name: query-lessthanorequal

        Less than or equal. Combine with :php:`greaterThanOrEqual()` inside a
        :php:`logicalAnd()` to express a closed range.

        ..  code-block:: php

            $query->lessThanOrEqual('conferenceDate', new \DateTimeImmutable('2026-12-31'))

        ..  code-block:: sql

            `conference_date` <= 1798675200

To count matches without loading the objects, call :php:`count()` on the query
after :php:`matching()` instead of :php:`execute()`. It applies the same
constraints and returns an integer.


..  _extbase-persistence-queries-combine:

Combining constraints with logicalAnd(), logicalOr() and logicalNot()
---------------------------------------------------------------------

:php:`matching()` takes exactly one constraint. To apply several conditions,
combine them with :php:`logicalAnd()`, :php:`logicalOr()` and
:php:`logicalNot()`, which themselves return a single constraint:

..  literalinclude:: _snippets/_FindUpcomingPublished.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

A date range is a :php:`logicalAnd()` of :php:`greaterThanOrEqual()` and
:php:`lessThanOrEqual()` — the snippet above pairs a comparison with an
:php:`equals()` constraint in the same way.


..  _extbase-persistence-queries-order-limit:

Ordering and limiting the result
--------------------------------

Set the order with :php:`setOrderings()` (or the repository's
:php:`$defaultOrderings`). The two ordering forms and the
property-versus-column rule are documented with the repository:

..  seealso::

    `Ordering results in Extbase repositories <https://docs.typo3.org/permalink/extbase-domain-repository-ordering>`_ — :php:`$defaultOrderings`, :php:`setOrderings()`, :php:`orderBy()`, and why an unordered query has no guaranteed order.

To return a slice of the result, combine :php:`setLimit()` and
:php:`setOffset()`:

..  literalinclude:: _snippets/_LimitOffset.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

:php:`setLimit()` expects a positive integer. Passing :php:`0` throws an
exception rather than returning an empty result, so guard against it if the
value is computed.


..  _extbase-persistence-queries-results:

Working with the query result
-----------------------------

:php:`execute()` returns a
:php:`\TYPO3\CMS\Extbase\Persistence\QueryResultInterface` which is iterable
and countable. Two methods on it are worth knowing: :php:`getFirst()` returns
the first object (or :php:`null`) without you slicing the result, and
:php:`toArray()` returns the results as a plain array of **fully mapped domain
objects**. This is useful when you need an array rather than the lazy result object.

If you do not need domain objects at all, pass :php:`true` to
:php:`execute()`. This is a different array: :php:`$query->execute(true)`
returns the **raw database rows** as a :php:`list<array<string, mixed>>` and
skips object mapping entirely. It is the lighter option for read-only data you
will not modify or persist at the cost of losing the typed model objects, their
getters, and relation access. Use it when hydration is pure overhead — a
report, an export, a quick lookup — and stay with the default
:php:`QueryResultInterface` whenever you work with the objects themselves.


..  _extbase-persistence-queries-storagepid:

The storagePid page restriction
===============================

Every query a repository builds is restricted to records on configured *storage
pages* (the **storagePid**), in addition to the constraints you set with
:php:`matching()`. This is the most common reason a query returns something other
than what you expect, and it has its own page:

..  seealso::

    `The storagePid <https://docs.typo3.org/permalink/extbase-persistence-storagepid>`_ — the resolution chain, the recursive setting, why ``storagePid = 0`` does not disable the restriction, and how to override or drop the restriction for a single query.


..  _extbase-persistence-queries-querysettings:

Overriding query behaviour with query settings
==============================================

Every query carries a
:php:`query settings <\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface>`
object that controls the implicit restrictions Extbase applies. Set it with
:php:`$query->getQuerySettings()` inside a custom repository method:

..  literalinclude:: _snippets/_QuerySettings.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

The storagePid is one of these settings; its two methods
(:php:`setRespectStoragePage()` and :php:`setStoragePageIds()`) are documented on
the :ref:`storagePid page <extbase-persistence-storagepid-override>`.
The remaining settings control language and visibility:

..  confval-menu::
    :name: extbase-querysettings
    :display: table
    :type:
    :default:

    ..  confval:: setRespectSysLanguage(bool)
        :name: qs-respectSysLanguage
        :type: `bool`
        :default: `true`

        When :php:`true`, results are filtered and overlaid according to the
        current language. When :php:`false`, records of all languages are
        returned without overlay.

    ..  confval:: setIgnoreEnableFields(bool)
        :name: qs-ignoreEnableFields
        :type: `bool`
        :default: `false`

        When :php:`true`, hidden, start/stop-scheduled and access-restricted
        records are included. By default these :sql:`enable fields` are honoured.

    ..  confval:: setIncludeDeleted(bool)
        :name: qs-includeDeleted
        :type: `bool`
        :default: `false`

        When :php:`true`, soft-deleted records (those flagged in the
        :sql:`deleted` column) are returned. Use with care.

..  warning::

    :php:`setIgnoreEnableFields(true)` and :php:`setIncludeDeleted(true)` bypass
    the visibility rules editors rely on. A frontend query that ignores enable
    fields will show hidden and time-restricted records to visitors. Reserve
    these for backend or maintenance contexts and never apply them to a default
    frontend listing.


..  _extbase-persistence-queries-pagination:

Paginating a query result
=========================

For page-by-page navigation, do not compute offsets by hand. TYPO3 splits
pagination into two collaborating roles, each with its own family of classes:

*   A **paginator** wraps the item source and slices it to the current page.
    All paginators extend
    :php:`\TYPO3\CMS\Core\Pagination\AbstractPaginator` and expose the current
    page's items in :php:`getPaginatedItems()`. Which one you pick depends
    on the source: :php:`\TYPO3\CMS\Extbase\Pagination\QueryResultPaginator` for
    an Extbase query result,
    :php:`\TYPO3\CMS\Core\Pagination\ArrayPaginator` for a plain array,
    :php:`\TYPO3\CMS\Core\Pagination\QueryBuilderPaginator` for a raw DBAL
    query, and several source-specific paginators shipped by other extensions.
*   **Pagination** takes a paginator and computes the page-number metadata
    used to render the navigation — previous, next, first, last and the list of
    page numbers. All implement
    :php:`\TYPO3\CMS\Core\Pagination\PaginationInterface`. Core ships two
    strategies: :php:`\TYPO3\CMS\Core\Pagination\SimplePagination` (every page
    number) and :php:`\TYPO3\CMS\Core\Pagination\SlidingWindowPagination` (a
    moving window around the current page, for long result sets).

For an Extbase query result you therefore combine a
:php:`QueryResultPaginator` with the pagination strategy of your choice. The
controller creates both and assigns them to the view:

..  literalinclude:: _snippets/_Pagination.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

The paginator queries lazily — it only fetches the records for the current page,
not the whole result set — so it is safe to use over large tables. In the
template the records for the current page come from
:html:`{paginator.paginatedItems}` (you loop over that to render the items),
while :html:`{pagination.allPageNumbers}` supplies the page numbers for the
navigation links. The original :php:`findAll()` result is never passed to the
view:

..  literalinclude:: _snippets/_Pagination.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html


..  _extbase-persistence-queries-write:

When changes reach the database
===============================

Reads happen immediately. Writes do not. Extbase tracks the state of every
object it loads and flushes the accumulated changes once, automatically, at the
end of the request — comparing each object against its original state and
writing only what has changed. In most actions you do not need to call a save method on an
object that you have loaded and modified; the ORM will detect the change and
write it for you.

This deferred flush is convenient, but has two consequences that are worth knowing.


..  _extbase-persistence-queries-persistall:

Forcing a write with persistAll()
---------------------------------

Two situations need the flush to happen earlier than the end of the request.
Call :php:`$this->persistenceManager->persistAll()` in both:

*   **Before a redirect.** :php:`$this->redirect()` ends the request before the
    automatic flush runs, so an object that is added just before it is never written.
*   **When you need the new UID.** A freshly created object has no UID until it
    is persisted. Persist first, then read the UID.

..  literalinclude:: _snippets/_PersistAll.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php


..  _extbase-persistence-queries-isnew:

Detecting an unpersisted object
-------------------------------

Before persistence, an object has no UID — :php:`getUid()` returns :php:`null`.
To check whether Extbase still considers an object to be new (not yet written), use
the persistence manager's public :php:`isNewObject()` method:

..  literalinclude:: _snippets/_IsNew.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

..  note::

    The domain object also carries an :php:`_isNew()` method, but it is marked
    as :php:`@internal`. Use
    :php:`\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface::isNewObject()`
    in extension code — it is the supported public API and will return the same
    answer.


..  _extbase-persistence-queries-debug:

Debugging an Extbase query
==========================

When a query returns something other than what you expect — nothing, too few
records, too many, or the wrong ones — work through this checklist first before
checking for possibly incorrect constraint logic:

#.  **Check the storagePid first.** This is the cause far more often than the
    query itself. Confirm which page the records live on and which page the query
    searches.
#.  **Check the recursive depth.** Records in subfolders are invisible without
    it; an over-broad depth pulls in unrelated records.
#.  **Check the language.** With :php:`setRespectSysLanguage(true)` (the
    default), records in other languages are filtered out or overlaid.
#.  **Check enable fields.** Hidden or time-restricted records are excluded by
    default — correct for the frontend, surprising during debugging.
#.  **Inspect the generated SQL.** Extbase builds real SQL; seeing the exact
    SQL statement and its parameters will show the page restrictions and any conditions that
    have been applied.

To see the SQL, convert the query to a Doctrine query builder and dump it using
the Extbase debugger:

..  literalinclude:: _snippets/_DebugQuery.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

..  warning::

    :php:`\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser` is
    marked as :php:`@internal` and may change without notice. Use it for debugging
    only, never in production code paths.

..  seealso::

    `Persistence and the Extbase ORM <https://docs.typo3.org/permalink/extbase-concepts-persistence>`_ — the ORM mental model and object lifecycle.

    `Extbase repository <https://docs.typo3.org/permalink/extbase-domain-repository>`_ — find methods, constraints and the DBAL escape hatch.

    `Object relations in Extbase <https://docs.typo3.org/permalink/extbase-persistence-relations>`_ — how related objects are loaded and the lazy-loading trade-off.

Once you can query confidently, the next step is understanding how Extbase loads
*related* objects — and the performance trade-off that comes with them. That is
covered in :ref:`extbase-persistence-relations`.
