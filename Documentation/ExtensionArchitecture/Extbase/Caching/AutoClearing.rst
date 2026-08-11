:navigation-title: Automatic cache clearing

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Automatic cache clearing
..  _extbase-caching-autoclearing:

=======================================================
Automatic page cache clearing on Extbase record changes
=======================================================

When your plugin persists a change through a repository, the pages that display
that record are already in the page cache and would keep serving the old
content until their cache expired. Extbase prevents that: after a repository
write, it clears the cache of the pages affected by the change. This is the
default behaviour, and the write-side counterpart to the read-side
:ref:`cache tags <extbase-caching-cachetags>` of the previous page.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-caching-autoclearing-flow:

How an Extbase repository write clears the cache
================================================

Three repository operations trigger cache clearing: adding, updating and
removing a record. Each :sql:`INSERT`, :sql:`UPDATE` and :sql:`DELETE` that goes
through the Extbase persistence layer registers the affected record — its table
and :abbr:`UID (unique identifier, the primary key of a TYPO3 database record)` —
for later clearing. At the **end of the request**, Extbase resolves the
registered records to page UIDs and flushes the page cache for those pages.

Two details are worth knowing:

*   Clearing happens **at the end of the request**, not the instant you call
    :php:`add()` or :php:`update()`. Several writes in one request are collected
    and their pages flushed together once.

*   Registration is driven by records, not relations. A write that only touches a
    relation (:abbr:`MM (many-to-many)`) table — with no record of its own —
    does not register a record for clearing.


..  _extbase-caching-autoclearing-pages:

Which pages an Extbase record change clears
===========================================

For each changed record, Extbase clears three kinds of page:

*   **Every page tagged with that record.** This is the primary mechanism and the
    reverse of :ref:`cache tags <extbase-caching-cachetags>`. When a page renders
    a record, its cache entry is tagged with :sql:`<table>_<uid>`. When that
    record changes, Extbase flushes the :sql:`<table>_<uid>` tag, which
    invalidates every page carrying it. A conference shown on ten different list
    pages is therefore refreshed on all ten when it changes — without anyone
    configuring which pages those are. The storage page below is *not* how a list
    page gets cleared; the tag is.

*   **The record's storage page** — additionally, the page whose :sql:`pid` the
    record lives on is flushed (by its :sql:`pageId_<pid>` tag). This has no effect if
    the storagePid is a sysFolder, but for a content bearing page type it makes a difference.
    Consider the impact before deciding where a record stores as to not invalidate
    page caches for pages that might not even display that record.

*   **Any pages named in that page's** :ref:`TCEMAIN.clearCacheCmd <t3tsref:pagetcemain-clearcachecmd>`
    **Page TSconfig.** An integrator can name further page UIDs to flush whenever
    *any* record on the storage page changes. Unlike the per-record tag above,
    this is a coarse, page-level rule the integrator maintains by hand — useful
    when a page depends on the storage folder as a whole rather than on one
    record.


..  _extbase-caching-autoclearing-lifetime:

The page cache lifetime and where it comes from
===============================================

Automatic clearing flushes a page *early*, when its records change. Absent any
change, a cached page lives until its lifetime expires. That lifetime is not a
single fixed number — it is resolved from several sources, each overriding or
narrowing the previous:

#.  **The page's Cache timeout field** (:guilabel:`Page > Behaviour > Cache
    timeout`). If set to a non-zero value, it wins.
#.  **TypoScript** :typoscript:`config.cache_period`. Used when the page field is
    not set.
#.  **A framework fallback** when neither of the above applies. In the calculator
    that handles record and page lifetimes this fallback is one year; a separate
    24-hour fallback applies to the content-object rendering path. Treat these as
    innermost fallbacks, not as "the" default.
#.  **Narrowed by record visibility.** The lifetime is then shortened to the next
    :sql:`starttime` or :sql:`endtime` of the records on the page, so a page
    expires no later than the moment its content becomes visible or hidden.
#.  **Overridden by an event.** Finally, a listener on
    :ref:`ModifyCacheLifetimeForPageEvent` receives the resolved value and may
    replace it entirely.

Because of this chain, do not rely on a hard-coded number for "how long a page is
cached". If you need the real, effective value for a given page, verify it rather
than infer it:

*   **Inspect the cache entry.** With the default database cache backend, the
    :sql:`cache_pages` table stores an :sql:`expires` timestamp for each cached
    page. The remaining lifetime is :sql:`expires` minus the current time.

*   **Observe the resolved value.** A listener on
    :ref:`ModifyCacheLifetimeForPageEvent` is handed the fully resolved lifetime
    for the page; logging it there reports exactly what the system computed,
    after every source above has been applied.


..  _extbase-caching-autoclearing-setting:

The `enableAutomaticCacheClearing` setting for Extbase
======================================================

Automatic clearing is controlled by
:typoscript:`config.tx_extbase.persistence.enableAutomaticCacheClearing`, which is
**enabled by default**:

..  literalinclude:: _snippets/_enableAutomaticCacheClearing.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

The setting gates the *flush*, not the *registration*: repository writes always
register their changed records, and the setting decides whether those registered
pages are cleared at the end of the request.

This is a **global** TypoScript setting in :typoscript:`config.tx_extbase`. It
applies to every repository write on the site for as long as it is set, and there
is no supported way to toggle it temporarily from PHP for a single operation —
unlike :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`, whose runtime behaviour
can be adjusted per instance. Setting it to :typoscript:`0` therefore means every
repository write across the site stops refreshing the frontend, and clearing
caches becomes your own responsibility through the
:ref:`cache-clearing helper <extbase-caching-cachetags-clearing>`. Leave it at its
default unless a deliberate, site-wide cache strategy replaces it.


..  _extbase-caching-autoclearing-limits:

What automatic Extbase cache clearing does not cover
====================================================

This mechanism is Extbase's own, and it only reacts to writes made **through an
Extbase repository**. It does not cover:

*   **Raw database writes** — records changed with a
    :abbr:`DBAL (Database Abstraction Layer)`
    :php:`\TYPO3\CMS\Core\Database\Query\QueryBuilder` query bypass the Extbase
    persistence layer, register nothing, and clear no cache. After such a write
    you must clear the affected pages yourself with the
    :ref:`cache-clearing helper <extbase-caching-cachetags-clearing>`.

*   **Relation-only changes** — as noted above, a write that only touches an
    :abbr:`MM (many-to-many)` table registers no record.

*   **Caches outside the pages group** — automatic clearing flushes by tag
    within the :php:`pages` cache group, calling :php:`flushByTags()` on **every**
    cache registered in that group, not only the page cache itself. A custom cache
    is reached by this **if you register it into the** :php:`pages` **group and tag
    its entries** with the same :sql:`<table>_<uid>` value — which is exactly what
    you want for a cache that stores rendered output, so it is invalidated
    together with the page cache. A custom cache left in the default :php:`all`
    group is *not* in the pages group and is not touched, so you must invalidate
    it yourself. The two-level list cache from
    :ref:`the optimisation section <extbase-caching-noncacheable-optimise>` uses
    the pages group for precisely this reason.

:php:`\TYPO3\CMS\Core\DataHandling\DataHandler` is a different case: it is not
covered by *this* mechanism, but it clears caches on its own. A DataHandler write
registers the changed record for page-cache clearing through its own routine and
honours the same :ref:`TCEMAIN.clearCacheCmd <t3tsref:pagetcemain-clearcachecmd>` Page TSconfig — so records
written through DataHandler do refresh the frontend, just not via the Extbase path
described here.

With this, you have the full caching picture for an Extbase plugin: cached by
default, non-cacheable only when you must, invalidated precisely with cache tags,
and refreshed automatically when records change.

..  seealso::

    *   `Caching for Extbase plugins <https://docs.typo3.org/permalink/extbase-caching-overview>`_ — the chapter overview.

    *   `Cache tags for Extbase plugins <https://docs.typo3.org/permalink/extbase-caching-cachetags>`_ — the read-side counterpart: tagging pages so they can be invalidated.
