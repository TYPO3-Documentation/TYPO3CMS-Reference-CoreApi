.. include:: /Includes.rst.txt



.. _caching-architecture:

==============================
Caching Framework Architecture
==============================


.. _caching-architecture-base:

Basic Knowhow
=============

The caching framework can handle multiple caches with different configurations.
A single cache consists of any number of cache entries.

A single cache entry is defined by these fields:

- **identifier**: A string as unique identifier within this cache. Used to store and retrieve entries.
- **data**: The data to be cached.
- **lifetime**: A lifetime in seconds of this cache entry. An entry can not be retrieved from cache if lifetime expired.
- **tags**: Additional tags (an array of strings) assigned to the entry. Used to remove specific cache entries.

.. tip::

   The difference between identifier and tags is quite simple: an identifier uniquely identifies a cache entry,
   and a tag is additional data applied to an entry (used for cache eviction). Thus, an identifier refers to a
   single cache entry to store and retrieve an entry, and a tag can refer to multiple cache entries.


.. _caching-architecture-identifier:

About the Identifier
--------------------

The identifier is used to store ("set") and retrieve ("get") entries
from the cache and holds all information to differentiate entries from each other.
For performance reasons, it should be quick to calculate.

Suppose there is an resource-intensive extension added as a plugin on two different pages.
The calculated content depends on the page on which it is inserted and if a user is logged in or not.
So, the plugin creates at maximum four different content outputs,
which can be cached in four different cache entries:

- page 1, no user logged in
- page 1, a user is logged in
- page 2, no user logged in
- page 2, a user is logged in

To differentiate all entries from each other, the identifier is built from the page ID
where the plugin is located, combined with the information whether a user is logged in.
These are concatenated and hashed. In PHP this could look like this::

   $identifier = sha1((string)$this->getPageUid() . (string)$this->isUserLoggedIn());

.. tip::

   sha1 is a good hash algorithm in this case, as collisions are extremely unlikely.
   It scales O(n) with the input length.

When the plugin is accessed, the identifier is calculated early in the program flow.
Next, the plugin looks up for a cache entry with this identifier.
If such an entry exists, the plugin can return the cached content,
else it calculates the content and stores a new cache entry with this identifier.

In general, the identifier is constructed from all dependencies
which specify an unique set of data. The identifier should be based on
information which already exist in the system at the point of its calculation.
In the above scenario the page id and whether or not a user is logged in
are already determined during the frontend bootstrap and can be retrieved from the system quickly.


.. _caching-architecture-tags:

About Tags
----------

Tags are used to drop specific cache entries when some information they are based on
is changed.

Suppose the above plugin displays content based on different news entries.
If one news entry is changed in the backend, all cache entries
which are compiled from this news row must be dropped to ensure that
the frontend renders the plugin content again and does not deliver old content
on the next frontend call.

If - for example - the plugin uses news number one and two on one page,
and news one on another page, the related cache entries should be tagged with these tags:

- page 1, tags news_1, news_2
- page 2, tag news_1

If entry 2 is changed, a simple backend logic (probably a hook in :ref:`DataHandler <using-tcemain>`) could be created,
which drops all cache entries tagged with :code:`news_2`. In this case the first entry would be
invalidated while the second entry still exists in the cache after the operation.

While there is always exactly one identifier for each cache entry,
an arbitrary number of tags can be assigned to an entry and one specific tag
can be assigned to multiple cache entries. All tags a cache entry has are given to
the cache when the entry is stored ("set").


.. _caching-architecture-core:

Caches in the TYPO3 Core
========================

The TYPO3 Core  defines and uses several caching framework caches by default.
This section gives an overview of default caches, its usage and behaviour. If not stated otherwise,
the default database backend with variable frontend is used.

Since TYPO3 CMS 6.2, the various caches are organized in groups.
Three groups currently exist:

pages
  Frontend-related caches.

system
  System caches. Flushing system caches should be avoided as much
  as possible, as rebuilding them requires significant resources.

lowlevel
  Low-level caches. Flushing low-level caches manually should be avoided completely.

all
  All other caches.

Cache clearing commands can be issued to target a particular group. If a cache
does not belong to a group, it will be flushed when the "all" group is flushed,
but such caches should normally be transient anyway.

There are :ref:`TSconfig options for permissions <t3tsconfig:useroptions>`
corresponding to each group.

The following caches exist in the TYPO3 CMS Core:

- `core`

  - Core cache for compiled php code. It should **not** be used by extensions.
  - Uses **PhpFrontend** with the **SimpleFileBackend** for maximum performance.
  - Stores Core internal compiled PHP code like concatenated :file:`ext_tables.php` and :file:`ext_localconf.php`
    files, autoloader and sprite configuration PHP files.
  - This cache is instantiated very early during bootstrap and **can not** be re configured
    by instance specific :file:`LocalConfiguration.php` or similar.
  - Cache entries are located in directory :file:`typo3temp/var/cache/code/core` or :file:`var/cache/code/core` (for composer-based installations). The full directory and any file
    in this directory can be safely removed and will be re-created upon next request. This is especially useful during
    development
  - **group**: system

- `hash`

  - Stores several key-value based cache entries, mostly used during frontend rendering.
  - **groups**: all, pages

- `pages`

  - The frontend page cache. Stores full frontend pages.
  - Content is compressed by default to reduce database memory and storage overhead.
  - **groups**: all, pages

- `pagesection`

  - Used to store "parts of a page", for example used to store Typoscript snippets and
    compiled frontend templates.
  - Content is compressed by default to reduce database memory and storage overhead.
  - **groups**: all, pages

- `runtime`

  - Runtime cache to store data specific for current request.
  - Used by several Core parts during rendering to re-use already calculated data.
  - Valid for one request only.
  - Can be re-used by extensions that have similar caching needs.

- `rootline`

  - Cache for rootline calculations.
  - Quick and simple cache dedicated for Core usage, Should **not** be re-used by extensions.
  - **groups**: all, pages

- `imagesizes`

   - Cache for imagesizes.
   - Should _only_ be cleared manually, if you know what you are doing.
   - **groups**: lowlevel

- `assets`

   - Cache for assets.
   - Examples: Backend Icons, RTE or RequireJS Configuration
   - **groups**: system

- `l10n`

  - Cache for the localized labels.
  - **groups**: system

- `fluid_template`

   - Cache for Fluid templates.
   - **groups**: system

- Extbase

  - Contains detailed information about a class' member variables and methods.
  - **group**: system

- dashboard_rss

  - Contains the contents of RSS-Feeds retrieved by RSS widgets on the dashboard.
  - This cache can be used by extension authors for their own RSS widgets.


.. tip::

   In rare cases, for example when classes that are required during the
   bootstrap process are introduced (usually when working on the TYPO3 Core ),
   cache clearings requests themselves might throw fatal errors.
   The solution here is to manually remove the cache files from
   :file:`typo3temp/var/cache/code/` or :file:`var/cache/code/` (for composer-based installation).


.. _caching-architecture-task:

Garbage Collection Task
=======================

The Core system provides a Scheduler task to collect the garbage of all cache backends.
This is important for backends like the database backend that do not remove old cache entries
and tags internally. It is highly recommended to add this Scheduler task and run it once in a while
(maybe once a day at night) for all used backends that do not delete entries which exceeded
their lifetime on their own to free up memory or hard disk space.


.. _caching-architecture-api:

Cache API
=========

The caching framework architecture is based on the following classes:

- **\\TYPO3\\CMS\\Core\\Cache\\Frontend\\FrontendInterface**: Main interface to handle cache entries of a specific cache.
  Different frontends and further interfaces exist to handle different data types.
- **\\TYPO3\\CMS\\Core\\Cache\\Backend\\BackendInterface**: Main interface that every valid storage backend must implement.
  Several backends and further interfaces exist to specify specific backend capabilities. Some frontends require backends
  to implement additional interfaces.

.. note::

   The `\TYPO3\CMS\Core\Cache\CacheManager` was used before TYPO3 10.1 to
   retrieve an object implementing `FrontendInterface`. It is now recommended
   to :ref:`use dependency injection <caching-developer-example>` to retrieve
   this object and no longer use the `CacheManager` directly.


.. warning::
  Do not use the CacheManager in :file:`ext_localconf.php` - instead load caches on demand at the place where they are needed.
