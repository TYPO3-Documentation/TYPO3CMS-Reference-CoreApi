:navigation-title: Queries

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Queries
..  _extbase-persistence-queries:

==================================
Querying the database with Extbase
==================================

This page is the complete query reference for Extbase. It covers what happens
*around* a query — which pages Extbase searches, which records it includes, how
it limits and orders results, when changes are written back, and how to debug a
query that misbehaves.

The constraint methods (:php:`equals()`, :php:`like()`, :php:`logicalAnd()` and
so on) and the built-in find methods (:php:`findAll()`, :php:`findBy()` …) are
documented where you write them, on the repository:

..  seealso::

    *   `Built-in find methods <https://docs.typo3.org/permalink/extbase-domain-repository-find-methods>`_ — :php:`findAll()`, :php:`findBy()`, :php:`findByUid()`, counting.

    *   `Custom query methods <https://docs.typo3.org/permalink/extbase-domain-repository-custom-queries>`_ — :php:`createQuery()` and the full constraint list.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-persistence-queries-storagepid:

Where Extbase looks: the storagePid resolution chain
====================================================

Every Extbase query — except :php:`findByUid()` and
:php:`findByIdentifier()` — is restricted to records stored on one or more
specific TYPO3 pages, the *storage pages* (often called the **storagePid**).

This restriction is the single most common reason an Extbase query does not
behave as expected. The classic symptom is a repository that returns *nothing*,
but that is only the most obvious case. Just as often the storagePid returns the
*wrong* result: too few records because some live on a page outside the
restriction, too many because a recursive lookup reaches into unrelated
subpages, or seemingly random records because the configured page is not the one
holding the data. An empty result at least announces the problem; a plausible
but incomplete result can go unnoticed for a long time.

Several options feed the storagePid, and later ones override earlier ones. In a
frontend request Extbase resolves them in this order:

#.  **Extension-wide TypoScript** —
    :typoscript:`plugin.tx_myextension.persistence.storagePid`.
#.  **Plugin-specific TypoScript** —
    :typoscript:`plugin.tx_myextension_conferencelist.persistence.storagePid`
    overrides the extension-wide value for that one plugin.
#.  **The Startingpoint field** on the plugin's content element. When an editor
    fills in the :guilabel:`Behaviour > Starting point` field, the chosen pages
    override the TypoScript value. The label hides the real database column,
    which is :sql:`pages` — useful to know when inspecting records or writing
    overrides, as the label is not guaranteed to read the same on every
    instance or in every language.
#.  **FlexForm** — only if the plugin's FlexForm defines a field bound to
    :typoscript:`persistence.storagePid`. A FlexForm overrides the storage page only
    when it deliberately exposes the :typoscript:`persistence` sheet. This is
    mentioned only for completeness — it would be rather unusual to expose a
    :typoscript:`persistence.storagePid` FlexForm field on a plugin that already
    offers the :sql:`pages` (Startingpoint) field.
#.  **PHP, per query** — the query settings, covered in the next section,
    override everything above. Where in your code you set them decides how wide
    the effect is: inside a single repository method only that one query
    changes; inside an overridden :php:`createQuery()` every query the
    repository builds is affected.

The most specific option that supplies a value wins. The query settings always have the
final say.


..  _extbase-persistence-queries-recursive:

Searching subpages with the recursive setting
---------------------------------------------

By default Extbase searches only the exact storage pages you configure — not
their subpages. To include records stored in subfolders below the storage page,
set a recursion depth.

In TypoScript, :typoscript:`persistence.recursive` applies to the
TypoScript-configured storagePids:

..  literalinclude:: _snippets/_recursive.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

The :guilabel:`Starting point` field has its own :guilabel:`Recursive` selector
next to it that does the same for the editor-chosen pages.

..  warning::

    Recursion is a frequent source of *too many* results, not too few. A
    recursive depth set too high pulls in records from unrelated subpages that
    happen to sit below the storage page. Set the depth to the smallest value
    that covers your folder structure.


..  _extbase-persistence-queries-querysettings:

Overriding query behaviour with query settings
==============================================

Every query carries a
:php:`query settings <\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface>`
object that controls the implicit restrictions Extbase applies. Reach it with
:php:`$query->getQuerySettings()` inside a custom repository method:

..  literalinclude:: _snippets/_QuerySettings.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

The most relevant settings:

..  confval-menu::
    :name: extbase-querysettings
    :display: table
    :type:
    :default:

    ..  confval:: setRespectStoragePage(bool)
        :name: qs-respectStoragePage
        :type: `bool`
        :default: `true`

        When :php:`false`, the storagePid restriction is dropped entirely and
        the query searches the whole table regardless of page. This is how
        you genuinely disable the page restriction.

    ..  confval:: setStoragePageIds(array)
        :name: qs-storagePageIds
        :type: `int[]`

        Sets the storage pages explicitly for this query, overriding the
        configured storagePid. Expects an array of integer page UIDs. Has no
        effect once :php:`setRespectStoragePage(false)` is set.

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


..  _extbase-persistence-queries-storagepid-zero:

Why ``storagePid = 0`` does not disable the restriction
-------------------------------------------------------

A common misconception is that setting the storagePid to :typoscript:`0`
switches off the page restriction. It does not. For an ordinary table, ``0`` is
the UID of the page tree root, a level no editor ever stores records on — so the
query looks for records on page 0 and finds none. The effect is an empty result,
not an unrestricted query.

To actually search the whole table irrespective of page, drop the restriction in
PHP:

..  literalinclude:: _snippets/_DisableStoragePid.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php


..  _extbase-persistence-queries-build-storagepid:

Building the storagePid array from editor input
-----------------------------------------------

When for any reason the storagePid array can't be build by extbase, but you want
to do it manually, use Core API rather than constructing the recursive pages yourself. The core
:php:`\TYPO3\CMS\Core\Domain\Repository\PageRepository` resolves the recursive
list of page UIDs for you, honouring access rights and the enable-field rules:

..  literalinclude:: _snippets/_RecursivePids.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

The resulting integer array is exactly what :php:`setStoragePageIds()` expects.
Letting the core API build it keeps the recursion logic identical to what
Extbase applies internally.


..  _extbase-persistence-queries-limit-offset:

Limiting, paging and ordering the result
========================================

Ordering is set with :php:`setOrderings()` (or the repository's
:php:`$defaultOrderings`) and is documented with the repository, because the
keys are property names and the behaviour belongs next to where you write
queries:

..  seealso::

    `Ordering results <https://docs.typo3.org/permalink/extbase-domain-repository-ordering>`_ — :php:`$defaultOrderings`, :php:`setOrderings()`, and why an unordered query has no guaranteed order.

To return a slice of the result, combine :php:`setLimit()` and
:php:`setOffset()`:

..  literalinclude:: _snippets/_LimitOffset.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

:php:`setLimit()` expects a positive integer; passing :php:`0` throws an
exception rather than returning an empty result, so guard against it if the
value is computed.

:php:`execute()` returns a
:php:`\TYPO3\CMS\Extbase\Persistence\QueryResultInterface`, which is iterable
and countable. Two methods on it are worth knowing: :php:`getFirst()` returns
the first object (or :php:`null`) without you slicing the result, and
:php:`toArray()` returns the results as a plain array of **fully mapped domain
objects** — useful when you need an array rather than the lazy result object.

If you do not need domain objects at all, pass :php:`true` to
:php:`execute()`. This is a different array: :php:`$query->execute(true)`
returns the **raw database rows** as a :php:`list<array<string, mixed>>` and
skips object mapping entirely. It is the lighter option for read-only data you
will not modify or persist, at the cost of losing the typed model objects, their
getters, and relation access. Reach for it when hydration is pure overhead — a
report, an export, a quick lookup — and stay with the default
:php:`QueryResultInterface` whenever you work with the objects themselves.


..  _extbase-persistence-queries-pagination:

Paginating a query result
-------------------------

For page-by-page navigation, do not compute offsets by hand. TYPO3 splits
pagination into two collaborating roles, each with its own family of classes:

*   A **paginator** wraps the item source and slices it to the current page.
    All paginators extend
    :php:`\TYPO3\CMS\Core\Pagination\AbstractPaginator` and expose the current
    page's items through :php:`getPaginatedItems()`. Which one you pick depends
    on the source: :php:`\TYPO3\CMS\Extbase\Pagination\QueryResultPaginator` for
    an Extbase query result,
    :php:`\TYPO3\CMS\Core\Pagination\ArrayPaginator` for a plain array,
    :php:`\TYPO3\CMS\Core\Pagination\QueryBuilderPaginator` for a raw DBAL
    query, and several source-specific paginators shipped by other extensions.
*   A **pagination** takes a paginator and computes the page-number metadata
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
writing only what changed. In most actions you do not call a save method on an
object you loaded and modified; the ORM detects the change and writes it for you.

This deferred flush is convenient but has two consequences worth knowing.


..  _extbase-persistence-queries-persistall:

Forcing a write with persistAll()
---------------------------------

Two situations need the flush to happen earlier than the end of the request.
Call :php:`$this->persistenceManager->persistAll()` in both:

*   **Before a redirect.** :php:`$this->redirect()` ends the request before the
    automatic flush runs, so an object added just before it is never written.
*   **When you need the new UID.** A freshly created object has no UID until it
    is persisted. Persist first, then read the UID.

..  literalinclude:: _snippets/_PersistAll.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php


..  _extbase-persistence-queries-isnew:

Detecting an unpersisted object
-------------------------------

Before persistence, an object has no UID — :php:`getUid()` returns :php:`null`.
To check whether Extbase still considers an object new (not yet written), use
the persistence manager's public :php:`isNewObject()` method:

..  literalinclude:: _snippets/_IsNew.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

..  note::

    The domain object also carries an :php:`_isNew()` method, but it is marked
    :php:`@internal`. Use
    :php:`\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface::isNewObject()`
    in extension code — it is the supported public API and returns the same
    answer.


..  _extbase-persistence-queries-debug:

Debugging an Extbase query
==========================

When a query returns something other than what you expect — nothing, too few
records, too many, or the wrong ones — work through this checklist before
suspecting the constraint logic:

#.  **Check the storagePid first.** It is the cause far more often than the
    query. Confirm which page the records live on and which page the query
    searches.
#.  **Check the recursive depth.** Records in subfolders are invisible without
    it; an over-broad depth pulls in unrelated records.
#.  **Check the language.** With :php:`setRespectSysLanguage(true)` (the
    default), records in another language are filtered out or overlaid.
#.  **Check enable fields.** Hidden or time-restricted records are excluded by
    default — correct for the frontend, surprising during debugging.
#.  **Inspect the generated SQL.** Extbase builds real SQL; seeing the exact
    statement and its parameters shows the page restriction and every other
    condition actually applied.

To see the SQL, convert the query to a Doctrine query builder and dump it with
the Extbase debugger:

..  literalinclude:: _snippets/_DebugQuery.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

..  warning::

    :php:`\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser` is
    marked :php:`@internal` and may change without notice. Use it for debugging
    only, never in production code paths.

..  seealso::

    `Persistence and the Extbase ORM <https://docs.typo3.org/permalink/extbase-concepts-persistence>`_ — the ORM mental model and object lifecycle.

    `Extbase repository <https://docs.typo3.org/permalink/extbase-domain-repository>`_ — find methods, constraints and the DBAL escape hatch.

    `Object relations in Extbase <https://docs.typo3.org/permalink/extbase-persistence-relations>`_ — how related objects are loaded and the lazy-loading trade-off.

Once you can query confidently, the next step is understanding how Extbase loads
*related* objects — and the performance trade-off that comes with them. That is
covered in :ref:`extbase-persistence-relations`.
