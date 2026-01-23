..  include:: /Includes.rst.txt

..  _caching-architecture:

==============================
Caching framework architecture
==============================

..  _caching-architecture-base:

Basic know-how
==============

The caching framework can handle multiple caches with different configurations.
A single cache consists of any number of cache entries.

A single cache entry is defined by these fields:

identifier
    A string as unique identifier within this cache. It is used to store and
    retrieve entries.

data
    The data to be cached.

lifetime
    A lifetime in seconds of this cache entry. An entry can not be retrieved
    from cache, if the lifetime is expired.

tags
    Additional tags (an array of strings) assigned to the entry. It is used to
    remove specific cache entries. The cache can be flushed by tag using command
    `vendor/bin/typo3 cache:flushtags <tag>`.

..  versionadded:: 14.0
    Command `vendor/bin/typo3 cache:flushtags <tag>` has been introduced

..  tip::
    The difference between identifier and tags is quite simple: an identifier
    uniquely identifies a cache entry, and a tag is additional data applied to
    an entry (used for cache eviction). Thus, an identifier refers to a single
    cache entry to store and retrieve an entry, and a tag can refer to multiple
    cache entries.


..  _caching-architecture-identifier:

About the identifier
--------------------

The identifier is used to store ("set") and retrieve ("get") entries from the
cache and holds all information to differentiate entries from each other.
For performance reasons, it should be quick to calculate.

Suppose a resource-intensive extension is added as a plugin on two different
pages. The calculated content depends on the page on which it is inserted and
if a user is logged in or not. So, the plugin creates at maximum four different
content outputs, which can be cached in four different cache entries:

*   page 1, no user logged in
*   page 1, a user is logged in
*   page 2, no user logged in
*   page 2, a user is logged in

To differentiate all entries from each other, the identifier is built from the
page ID where the plugin is located, combined with the information whether a
user is logged in. These are concatenated and hashed. In PHP this could look
like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/SomeClass.php

    $identifier = sha1((string)$this->getPageUid() . (string)$this->isUserLoggedIn());

..  tip::
    `sha1`_ is a good hash algorithm in this case, as collisions are extremely
    unlikely. It scales O(n) with the input length.

..  _sha1: https://www.php.net/manual/en/function.sha1.php

When the plugin is accessed, the identifier is calculated early in the program
flow. Next, the plugin looks up for a cache entry with this identifier.
If such an entry exists, the plugin can return the cached content,
else it calculates the content and stores a new cache entry with this identifier.

In general, the identifier is constructed from all dependencies
which specify a unique set of data. The identifier should be based on
information which already exist in the system at the point of its calculation.
In the above scenario the page ID and whether or not a user is logged in
are already determined during the frontend :ref:`bootstrap <bootstrapping>` and
can be retrieved from the system quickly.


..  _caching-architecture-tags:

About tags
----------

..  versionadded:: 14.0
    Command `vendor/bin/typo3 cache:flushtags <tag>` has been introduced

Tags are used to drop specific cache entries when some information they are
based on is changed.

Suppose the above plugin displays content based on different news entries.
If one news entry is changed in the backend, all cache entries
which are compiled from this news row must be dropped to ensure that
the frontend renders the plugin content again and does not deliver old content
on the next frontend call.

For example, if the plugin uses news number one and two on one page, and news
one on another page, the related cache entries should be tagged with these tags:

*   page 1, tags news_1, news_2
*   page 2, tag news_1

If entry 2 is changed, a simple backend logic (probably a hook in
:ref:`DataHandler <using-tcemain>`) could be created, which drops all cache
entries tagged with :code:`news_2`. In this case the first entry would be
invalidated while the second entry still exists in the cache after the
operation.

While there is always exactly one identifier for each cache entry,
an arbitrary number of tags can be assigned to an entry and one specific tag
can be assigned to multiple cache entries. All tags a cache entry has are given
to the cache when the entry is stored ("set").

Command `cache:flushtags` allows flushing cache entries by tag.

Multiple tags can be flushed by passing a comma-separated list of tags.
It is also possible to flush tags for a specific cache group by using the
`--groups` or `-g` option. If no group is specified, all cache groups
are considered.

..  code-block:: bash
    :caption: Example command usage (Composer-mode projects)

    vendor/bin/typo3 cache:flushtags pageId_123
    vendor/bin/typo3 cache:flushtags pages_100,pages_200
    vendor/bin/typo3 cache:flushtags tx_news -g pages

..  seealso::
    :ref:`Frontend cache collector <typo3-request-attribute-frontend-cache-collector>`

..  _caching-architecture-core:

Caches in the TYPO3 Core
========================

The TYPO3 Core defines and uses several caching framework caches by default.
This section gives an overview of default caches, its usage and behaviour. If
not stated otherwise, the default :ref:`database backend <caching-backend-db>`
with :ref:`variable frontend <caching-frontend-variable>` is used.

The various caches are organized in groups. Currently, the following groups
exist:

pages
    Frontend-related caches.

system
    System caches. Flushing system caches should be avoided as much
    as possible, as rebuilding them requires significant resources.

lowlevel
    Low-level caches. Flushing low-level caches manually should be avoided
    completely.

all
    All other caches.

Cache clearing commands can be issued to target a particular group. If a cache
does not belong to a group, it will be flushed when the "all" group is flushed,
but such caches should normally be :ref:`transient <caching-backend-transient>`
anyway.

There are :ref:`TSconfig options for permissions <t3tsref:useroptions>`
corresponding to each group.

The following caches exist in the TYPO3 Core:

`core`
    **group**: system

    *   Core cache for compiled PHP code. It should **not** be used by extensions.
    *   Uses the :ref:`PHP frontend <caching-frontend-php>` with the
        :ref:`Simple file backend <caching-backend-simple-file>` for maximum
        performance.
    *   Stores Core internal compiled PHP code like concatenated
        :ref:`ext_tables.php <ext-tables-php>` and
        :ref:`ext_localconf.php <ext-localconf-php>` files and
        :ref:`autoloader <autoload>`.
    *   This cache is instantiated very early during
        :ref:`bootstrap <bootstrapping>` and **can not** be re-configured
        by instance-specific :file:`config/system/settings.php` or similar.
    *   Cache entries are located in directory :file:`var/cache/code/core/`
        (for Composer-based installations) and
        :file:`typo3temp/var/cache/code/core/` (for Classic mode installations). The
        full directory and any file in this directory can be safely removed and
        will be re-created upon next request. This is especially useful during
        development

`hash`
    **groups**: all, pages

    *   Stores several key-value based cache entries, mostly used during
        frontend rendering.

`pages`
    **groups**: all, pages

    *   The frontend page cache. It stores full frontend pages.
    *   The content is compressed by default to reduce database memory and
        storage overhead.

`runtime`
    *   Runtime cache to store data specific for current request.
    *   Used by several Core parts during rendering to re-use already calculated
        data.
    *   Valid for one request only.
    *   Can be re-used by extensions that have similar caching needs.

`rootline`
    **groups**: all, pages

    *   Cache for rootline calculations.
    *   A quick and simple cache dedicated for Core usage, it should **not** be
        re-used by extensions.

`assets`
    **groups**: system

    *   Cache for assets.
    *   Examples: backend icons, RTE or JavaScript configuration.

`l10n`
    **groups**: system

    Cache for the localized labels.

`fluid_template`
    **groups**: system

    *   Cache for :ref:`Fluid` templates.

`extbase`
    **group**: system

    *   Contains detailed information about a class' member variables and
        methods.

`ratelimiter`
    **group**: system

    *   Cache for the `Symfony rate limiter`_ component (for example, used for
        :ref:`backend <typo3ConfVars_be_loginRateLimit>` or
        :ref:`frontend <typo3ConfVars_fe_loginRateLimit>` login rate limiting).

..  _Symfony rate limiter: https://symfony.com/doc/current/rate_limiter.html

`typoscript`
    **group**: pages

    *   Cache for :ref:`TypoScript <t3tsref:start>`.

`database_schema`
    **group**: system

    Cache for database schema information.

`dashboard_rss`
    *   Contains the contents of RSS feeds retrieved by RSS widgets on the
        :doc:`dashboard <ext_dashboard:Index>`.
    *   This cache can be used by extension authors for their own RSS widgets.


..  tip::
    In rare cases, for example, when classes that are required during the
    bootstrap process are introduced (usually when working on the TYPO3 Core),
    cache clearings requests themselves might throw fatal errors.
    The solution here is to manually remove the cache files from
    :file:`var/cache/code/` (for Composer-based installations) or
    :file:`typo3temp/var/cache/code/` (for Classic mode installations).


.. _caching-architecture-task:

Garbage collection task
=======================

The Core system provides a :doc:`scheduler <ext_scheduler:Index>` task to
collect the garbage of all :ref:`cache backends <caching-backend>`. This is
important for backends like the :ref:`database backend <caching-backend-db>`
that do not remove old cache entries and tags internally. It is highly
recommended to add this scheduler task and run it once in a while (maybe once a
day at night) for all used backends that do not delete entries which exceeded
their lifetime on their own to free up memory or hard disk space.


.. _caching-architecture-api:

Cache API
=========

The caching framework architecture is based on the following classes:

:php:`\TYPO3\CMS\Core\Cache\Frontend\FrontendInterface`
    Main interface to handle cache entries of a specific cache. Different
    frontends and further interfaces exist to handle different data types.

:php:`\TYPO3\CMS\Core\Cache\Backend\BackendInterface`
    Main interface that every valid storage backend must implement. Several
    backends and further interfaces exist to specify specific backend
    capabilities. Some frontends require backends to implement additional
    interfaces.

..  note::
    The :php:`\TYPO3\CMS\Core\Cache\CacheManager` was used before TYPO3 v10.1 to
    retrieve an object implementing :php:`FrontendInterface`. It is now
    recommended to :ref:`use dependency injection <caching-developer-example>`
    to retrieve this object and no longer use the :php:`CacheManager` directly.

..  warning::
    Do not use the :php:`CacheManager` in :file:`ext_localconf.php` - instead
    load caches on demand at the place where they are needed.
