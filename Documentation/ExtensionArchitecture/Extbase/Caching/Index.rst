:navigation-title: Caching

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Caching
..  _extbase-caching-overview:
..  _extbase_caching:

===========================
Caching for Extbase plugins
===========================

TYPO3 caches the rendered output of a page so that the work to build it runs
once and every following visitor is served the stored result. This is what keeps
a content-heavy site fast: the database queries, the template rendering and any
business logic behind a page happen on the first request, and the cached output
answers the rest.

An Extbase plugin is part of that picture. By default its output is cached
together with the page it sits on, so a plugin action runs once and its result
is reused. That default is almost always what you want — but a plugin can also
opt out of it, and the moment it does, the trade-offs shift onto you. This
chapter is about those choices: when a plugin is cached, how to keep it cached
while still showing fresh data, and what it costs when you turn caching off.

..  seealso::

    This chapter covers only the Extbase-specific side of caching. For the
    caching framework itself — cache frontends and backends, configuration and
    the page cache — see `Caching <https://docs.typo3.org/permalink/t3coreapi:caching>`_.
    The general concept of cacheable versus dynamic content is explained there
    through the `USER_INT <https://docs.typo3.org/permalink/t3tsref:cobj-user-int>`_
    TypoScript object, which is exactly the mechanism an Extbase plugin uses under
    the hood.


..  _extbase-caching-overview-why:

Why caching matters for an Extbase plugin
=========================================

Every Extbase plugin is rendered as a content object on the page. In its default,
cached state that content object is built once and its output is stored in the
page cache; subsequent requests for the same page never re-run the action. A
plugin listing conferences runs its repository query on the first visit and then
serves the same markup to everyone until the cache is cleared.

Two things change that default:

*   **Declaring an action non-cacheable.** An action registered as non-cacheable
    is rendered on *every* request, outside the page cache. This is necessary for
    genuinely dynamic output, but it moves the responsibility for performance from
    the framework to you.

*   **Writing records through a repository.** When your plugin saves, updates or
    deletes a record, the cached pages that show that record must be refreshed —
    otherwise visitors keep seeing stale content. Extbase handles this
    automatically by default.

Both are covered in the pages below.


..  _extbase-caching-overview-topics:

What this Extbase caching chapter covers
========================================

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :card-height: 100

    ..  card:: :ref:`Non-cacheable actions <extbase-caching-noncacheable>`

        When and how to make an action non-cacheable with
        :php:`configurePlugin()`, what USER_INT rendering really costs, and how to
        keep a non-cached plugin fast.

    ..  card:: :ref:`Cache tags <extbase-caching-cachetags>`

        How Extbase tags the page cache for the records a repository reads, so
        those pages can be invalidated precisely instead of disabling the cache.

    ..  card:: :ref:`Automatic cache clearing <extbase-caching-autoclearing>`

        How saving through a repository clears the cache of the affected pages,
        what :typoscript:`enableAutomaticCacheClearing` controls, and where it
        stops.


..  toctree::
    :titlesonly:
    :hidden:

    NonCacheable
    CacheTags
    AutoClearing
