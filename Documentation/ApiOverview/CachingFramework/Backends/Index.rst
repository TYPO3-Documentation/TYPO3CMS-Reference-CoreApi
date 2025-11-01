..  include:: /Includes.rst.txt

..  _caching-backend:

===============
Cache backends
===============

There are a variety of different storage backends. They have different characteristics
and can be used for different caching needs. The best backend depends on
your server setup and hardware, as well as cache type and usage.
A backend should be chosen wisely, as the wrong backend can
slow down your TYPO3 installation.

..  _caching_backend-api:

Backend API
===========

All backends must implement the :code:`TYPO3\CMS\Core\Cache\Backend\BackendInterface`.

..  versionchanged:: 14.0
    The :php-short:`\TYPO3\CMS\Core\Cache\Backend\FreezableBackendInterface`
    has been removed. See `Breaking: #107310 - Remove FreezableBackendInterface <https://docs.typo3.org/permalink/changelog:breaking-107310-1755533400>`_.

..  _caching_backend-api-BackendInterface:

BackendInterface
----------------

..  include:: /CodeSnippets/Manual/Cache/BackendInterface.rst.txt

All operations on caches must use the methods above. There are
other interfaces that can be implemented by backends to add additional functionality.
Extension code should not call cache backend operations
directly, but should use the frontend object instead.

..  _caching_backend-api-TaggableBackendInterface:

TaggableBackendInterface
------------------------

..  include:: /CodeSnippets/Manual/Cache/TaggableBackendInterface.rst.txt

..  _caching_backend-api-PhpCapableBackendInterface:

PhpCapableBackendInterface
--------------------------

..  include:: /CodeSnippets/Manual/Cache/PhpCapableBackendInterface.rst.txt

..  _caching-backend-options:

Common options of caching backends
==================================

..  confval:: defaultLifetime
    :name: caching-backend-defaultLifetime
    :type: integer
    :default: 3600

    Default lifetime in seconds of a cache entry if it has not been specified for an
    entry by `set()`.

..  _caching-backend-db:

Database Backend
================

This is the main backend and is suitable for most storage needs.
It does not require additional server daemons or server configuration.

The database backend does not automatically perform garbage collection.
Use the :ref:`Scheduler garbage collection task <caching-architecture-task>` instead.

This backend stores data in a database (usually MySQL)
and can handle large amounts of data with reasonable performance.
Data and tags are stored in two different tables and every cache has its own set of tables.
In terms of performance, the database backend is well optimized
and, if in doubt, should be used as a default backend doubt. This is the default
backend if no backend is specifically set in the configuration.

The Core takes care of creating and updating database tables "on the fly".

..  note::

    Caching framework tables which are no longer required are not
    automatically deleted. That is why the database analyzer in the Install
    Tool will suggest renaming/deleting caching framework tables if you
    change the caching backend to a non-database one.

For caches with a lot of read and write operations, it is important to tune your MySQL setup.
The most important setting is :code:`innodb_buffer_pool_size`. It is a good idea to give MySQL
as much RAM as needed so that the main table space is completely loaded in memory.

The database backend tends to slow down if there are many write operations
and big caches which don't fit into memory because of slow hard drive seek and
write performance. If the data table is too big to fit into memory, this backend can
compress data transparently, which shrinks the amount of
space needed to 1/4 or less. The overhead of the compress/uncompress operation is usually not high.
A good candidate for a cache with enabled compression is the Core pages cache:
it is only read or written once per request and the data size is pretty large.
Compression should not be enabled for caches which are read or written
multiple times in one request.

..  _caching-backend-db-innodb:

InnoDB Issues
-------------

The MySQL database backend uses InnoDB tables. Due to the nature of InnoDB, deleting records
`does not reclaim <https://bugs.mysql.com/bug.php?id=1287>`_ disk space. For example, if the cache uses 10GB,
cleaning still keeps 10GB allocated on the disk even though phpMyAdmin shows 0 as the cache table size.
To reclaim the space, turn on the MySQL option file_per_table, drop the cache tables and re-create
them using the Install Tool.
This does not mean that you should skip the scheduler task. Deleting records still improves performance.


..  _caching-backend-db-options:

Options of database backends
----------------------------

..  confval:: compression
    :name: caching-backend-compression
    :type: boolean
    :default: false

    Whether or not data should be compressed with gzip.
    This can reduce the size of the cache data table, but incurs CPU overhead
    for compression and decompression.

..  confval:: compressionLevel
    :name: caching-backend-compressionLevel
    :type: integer from -1 to 9
    :default: -1

    Gzip compression level (if the :code:`compression` option is set to :code:`true`).
    The default compression level is usually sufficient.

    `-1`
        Default gzip compression (recommended)
    `0`
        No compression
    `9`
        Maximum compression (costs a lot of CPU)


..  _caching-backend-memcached:

Memcached backend
=================

`Memcached <https://memcached.org/>`_ is a simple, distributed key/value RAM database.
To use this backend, at least one memcached daemon must be reachable,
and the PECL module "memcache" must be loaded.
There are two PHP memcached implementations: "memcache" and "memcached".
Currently, only memcache is supported by this backend.


..  _caching-backend-memcache-warning:

Limitations of memcached backends
---------------------------------

Memcached is a simple key-value store by design . Since the caching framework
needs to structure it to store the identifier-data-tags relations, for each
cache entry it stores an identifier->data, identifier->tags and a
tag->identifiers entry.

This leads to structural problems:

-   If memcache runs out of memory but must store new entries,
    it will toss *some* other entry out of the cache
    (this is called an eviction in memcached speak).
-   If data is shared over multiple memcache servers and a server fails,
    key/value pairs on this system will just vanish from cache.

Both cases lead to corrupted caches. If, for example, a tags->identifier entry is lost,
:code:`dropByTag()` will not be able to find the corresponding identifier->data entries
to be removed and they will not be deleted. This results in old data being delivered by the cache.
There is currently **no** implementation of garbage collection that
could rebuild cache integrity.

It is important to monitor a memcached system for evictions and server outages
and to clear caches if that happens.

Furthermore, memcache has no namespacing.
To distinguish entries of multiple caches from each other,
every entry is prefixed with the cache name.
This can lead to very long run times if a big cache needs to be flushed,
as every entry has to be handled separately. It would not be possible
to just truncate the whole cache with one call as this would clear
the whole memcached data which might also contain non-TYPO3-related entries.

Because of the these drawbacks, the memcached backend should be used with care.
It should be used in situations where cache integrity is not important or if a
cache does not need to use tags. Currently, the memcache backend implements the
TaggableBackendInterface, so the implementation does allow tagging,
even if it is not advisable to use this backend with heavy tagging.

..  warning::

    Since memcached does not have namespacing and access control,
    this backend should not be used if different third party systems have access
    to the same memcached daemon - for security reasons.
    This is a typical problem in cloud deployments where access to memcache is cheap
    (but could be read by third parties) and access to databases is expensive.


..  _caching-backend-memcache-options:

Options for the memcached backend
---------------------------------

..  confval:: servers
    :name: caching-backend-memcached-servers
    :type: array
    :required: true

    Array of memcached servers. At least one server must be defined.
    Each server definition is a string, with the following valid syntaxes:

    `hostname or IP`
        TCP connect to host on memcached default port
        (usually 11211, defined by PHP ini variable :code:`memcache.default_port`)
    `hostname:port`
        TCP connect to host on port
    `tcp://hostname:port`
        Same as above
    `unix:///path/to/memcached.sock`
        Connect to memcached server using unix sockets

..  confval:: compression
    :name: caching-backend-memcached-compression
    :type: boolean
    :default: false

    Enable memcached internal data compression.
    Can be used to reduce memcached memory consumption,
    but adds additional compression / decompression CPU overhead
    on the memcached servers.

..  _caching-backend-redis:

Redis Backend
=============

`Redis <https://redis.io/>`_ is a key-value storage/database.
In contrast to memcached, it allows structured values.
Data is stored in RAM but it can be persisted to disk
and doesn't suffer from the design problems of the memcached backend implementation.
The redis backend can be used as an alternative to the database backend
for big cache tables and help to reduce load on database servers this way.
The implementation can handle millions of cache entries, each with hundreds of tags
if the underlying server has enough memory.

Redis is extremely fast but very memory hungry.
The implementation is an option for big caches with lots of data
because most operations perform O(1) in proportion to the number of (redis) keys.
This basically means that access to an entry in a cache with a million entries
takes the same time as to a cache with only 10 entries,
as long as there is enough memory available to hold the complete set in memory.
At the moment only one redis server can be used at a time per cache,
but one redis instance can handle multiple caches without performance loss when flushing a single cache.

..  attention::

    The scheduler garbage collection task should be run regularly to
    find and delete old cache tags entries. These do not expire on their own and
    would remain in memory indefinitely - unless the cache is flushed.

The implementation is based on the PHP `phpredis <https://github.com/nicolasff/phpredis>`_ module,
which must be available on the system.

..  warning::

    Please check the section on
    :ref:`configuration <cacheBackendRedisServerConfiguration>` and monitor
    memory usage (and eviction, if enabled). Otherwise, you may run into
    problems, if not enough memory for the cache entries is reserved on the Redis
    server (`maxmemory`).

..  note::

    It is important to monitor the redis server and tune its settings
    to the specific caching needs and hardware capabilities.
    There are several articles on the net and the redis configuration file
    contains some important hints on how to speed up the system if it reaches its limit.
    A full documentation of available options is beyond this documentation.


..  _caching-backend-redis-example:

Redis example
-------------

The Redis caching backend configuration is very similar to that of other
backends, with one caveat.

TYPO3 caches should be separated if the same keys are used.
This applies to the `pages` and `pagesection` caches.
Both use "tagIdents:pageId_21566" for a page with id 21566.
How you separate them is for a system administrator to decide. We provide
examples with several databases but this may not be the best option
in production where you might want to use multiple cores (which do not
support databases). Separation is also a good idea because
caches can be flushed individually.

If you have several of your own caches which each use unique keys (for example
by using a different prefix for each separate cache identifier), you can
store them in the same database, but it is good practice to separate the core
caches.

    In practical terms, Redis databases should be used to separate different keys
    belonging to the same application (if needed), and not to use a single Redis
    instance for multiple unrelated applications.

    https://redis.io/commands/select/

..  The paragraph above is an intentional quote!


..  literalinclude:: _redis.php
    :language: php
    :caption: config/system/additional.php | typo3conf/system/additional.php


..  _caching-backend-redis-options:

Options for the redis caching backend
-------------------------------------

..  confval:: servers
    :name: caching-backend-redis-hostname
    :type: string
    :default: `127.0.0.1`

    IP address or name of redis server to connect to.

..  confval:: port
    :name: caching-backend-redis-port
    :type: integer
    :default: `6379`

    Port of the redis daemon.

..  confval:: persistentConnection
    :name: caching-backend-redis-persistentConnection
    :type: boolean
    :default: `false`

    Activate a persistent connection to a redis server. This is a good idea
    in high load cloud setups.

..  confval:: database
    :name: caching-backend-redis-database
    :type: integer
    :default: `0`

    Number of the database to store entries. Each cache should have its own database,
    otherwise caches sharing a database are all flushed if the flush operation
    is issued to one of them. Database numbers 0 and 1 are used and flushed by the Core unit tests
    and should not be used if possible.

..  confval:: username
    :name: caching-backend-redis-username
    :type: string

    ..  versionadded:: 14.0

    Use this option to authenticate against Redis using both a username and a
    password:

    ..  literalinclude:: _redis_password.php
        :caption: config/system/additional.php

..  confval:: password
    :name: caching-backend-redis-password
    :type: string | array (deprecated)

    ..  deprecated:: 14.0
        Setting this configuration option with an array is deprecated
        and will be removed in 15.0. See `Deprecation: #107725 - Deprecate
        usage of array in password for authentication in Redis cache backend <https://docs.typo3.org/permalink/changelog:deprecation-107725-1760807740>`_

    Password used to connect to the redis instance if the redis server needs authentication.

    ..  warning::

        The password is sent to the redis server as plain text.

..  confval:: compression
    :name: caching-backend-redis-compression
    :type: boolean
    :default: false

    Whether or not data compression with gzip should be enabled.
    This can reduce cache size, but adds some CPU overhead for the compression
    and decompression operations in PHP.

..  confval:: compressionLevel
    :name: caching-backend-redis-compressionLevel
    :type: integer from -1 to 9
    :default: -1

    Set gzip compression level to a specific value. The default compression level is usually sufficient.

    -1
        Default gzip compression (recommended)
    0
        No compression
    9
        Maximum compression (but more CPU overhead)

..  _cacheBackendRedisServerConfiguration:

Redis server configuration
--------------------------

This section is about the configuration on the Redis server, not the client.

For flushing by cache tags to work, it is important that the integrity of
the cache entries and cache tags is maintained. This may not be the case,
depending on which eviction policy (`maxmemory-policy`) is used. For example,
for a page id=81712, the following entries may exist in the Redis page cache:

#.  `tagIdents:pageId_81712` (tag->identifier relation)
#.  `identTags:81712_7e9c8309692aa221b08e6d5f6ec09fb6` (identifier->tags relation)
#.  `identData:81712_7e9c8309692aa221b08e6d5f6ec09fb6` (identifier->data)

If entries are evicted (due to memory shortage), there is no mechanism which
ensures that all related entries will be evicted. If
`maxmemory-policy allkeys-lru` is used, for example, this may
result in the situation that the cache entry (identData) still exists, but the
tag entry (tagIdents) does not. The tag entry reflects the relation
"cache tag => cache identifier" and is used for
:php:`RedisBackend::flushByTag()`). If this entry is gone, the cache
can no longer be flushed if content is changed on the page or an explicit
flushing of the page cache for this page is requested. Once this is the case,
cache flushing (for this page) is only possible via other means (such as full
cache flush).

Because of this, the following recommendations apply:

#.  Allocate enough memory (`maxmemory`) for the cache.
#.  Use the `maxmemory-policy` `volatile-ttl`. This will ensure
    that no tagIdents entries are removed. (These have no expiration date).
#.  Regularly run the TYPO3 scheduler garbage collection task for the Redis cache
    backend.
#.  Monitor `evicted_keys` in case an eviction policy is used.
#.  Monitor `used_memory` if eviction policy `noeviction` is used. The
    `used_memory` should always be less then `maxmemory`.

..  tip::

    The information about `evicted_keys` etc. can be obtained via `redis-cli` and
    the `info` command or via php-redis. Further information about the results of
    info is in the `documentation <https://redis.io/commands/info/>`__.

The `Eviction policy <https://redis.io/docs/latest/operate/rs/databases/memory-performance/eviction-policy/>`__
options have the following drawbacks:

volatile-ttl
    (recommended) Will flush only entries with an expiration date. Should be ok
    with TYPO3.

noeviction
    (Not recommended) Once memory is full, no new entries will be saved to cache.
    Only use if you can ensure that there is always enough memory.

allkeys-lru, allkeys-lfu, allkeys-random
    (Not recommended) This may result in tagIdents being removed, but not the
    related identData entry, which makes it impossible to flush the cache
    entries by tag (which is necessary for TYPO3 cache flushing on changes to
    work and the flush page cache to work for specific pages).

..  seealso::

    *   `Redis eviction policies <https://redis.io/docs/latest/operate/rs/databases/memory-performance/eviction-policy/>`__
    *   `Redis configuration <https://redis.io/docs/latest/operate/oss_and_stack/management/config/>`__

..  _caching-backend-file:

File backend
============

The file backend stores every cache entry as a single file in the file system.
The lifetime and tags are added to the file after the data section.

This backend is the big brother of the Simple file backend and implements
additional interfaces. Like the simple file backend it also implements the
:php:`PhpCapableInterface`, so it can be used with :php:`PhpFrontend`. In
contrast to the simple file backend it also implements
:php:`TaggableInterface`.

In general, the backend was specifically optimized to cache PHP code because the
`get` and `set` operations have low overhead. The file backend is
not very good at tagging and does not scale well with the number of tags. Do
not use this backend if cached data has many tags.

..  warning::

    The performance of :code:`flushByTag()` is bad and scales just O(n).

    On the contrary, performance of :code:`get()` and :code:`set()` operations
    is good and scales well. Of course, if there are many entries, this might
    still slow down after a while and a different storage strategy should be used
    (e.g. RAM disks, battery backed up RAID systems or SSD hard disks).

..  _caching-backend-file-options:

Options for the file backend
----------------------------

..  confval:: cacheDirectory
    :name: caching-backend-redis-cacheDirectory
    :type: array
    :Default: `var/cache/`

    The directory where the cache files are stored. By default, it is assumed
    that the directory is below :code:`TYPO3_DOCUMENT_ROOT`. However, an
    absolute path could be selected. Every cache should be assigned
    its own directory, otherwise flushing of one cache would flush all other
    caches in the same directory.

..  _caching-backend-simple-file:

Simple File Backend
===================

The simple file backend is the small brother of the :ref:`file backend <caching-backend-file>`. In contrast to most
other backends, it does not implement the :code:`TaggableInterface`, so cache entries cannot be tagged and flushed
by tag. This improves performance if cache entries do not need such tagging. The TYPO3 Core uses this backend
for its central Core cache (it holds autoloader cache entries and other important cache entries). The Core cache is
usually flushed completely and does not need specific cache entry eviction.


..  _caching-backend-pdo:

PDO Backend
===========

The PDO backend can be used as a native PDO interface to databases which are connected to PHP via PDO.
It is an alternative to the database backend if a cache should be stored in a database which is otherwise
only supported by TYPO3 dbal to reduce the parser overhead.

Garbage collection is implemented for this backend and should be called to clean up hard disk space or memory.

..  note::

   There is currently very little production experience with this backend, especially not with a capable database like Oracle.
   Any feedback for real life use cases of this cache is appreciated.


..  _caching-backend-pdo-options:

Options for the PDO backend
---------------------------

..  confval:: dataSourceName
    :name: caching-backend-pdo-dataSourceName
    :type: string
    :required: true

    Data source name for connecting to the database. Examples:

    -   `mysql:host=localhost;dbname=test`
    -   `sqlite:/path/to/sqlite.db`
    -   `sqlite::memory`

..  confval:: username
    :name: caching-backend-pdo-username
    :type: string

    Username for the database connection.


..  confval:: password
    :name: caching-backend-pdo-password
    :type: string

    Password to use for the database connection.


..  _caching-backend-transient:

Transient Memory Backend
========================

The transient memory backend stores data in a PHP array. It is only valid for one request. This is useful if code
logic carries out expensive calculations or repeatedly looks up identical
information in a database. Data is stored once in an array and data entries are retrieved
from the cache in consecutive calls, getting rid of additional overhead.
Since caches are available system-wide and shared between Core and extensions,
they can share the same information.

Since the data is stored directly in memory, this backend is the quickest. The stored data adds to
the memory consumed by the PHP process and can hit the :code:`memory_limit` PHP setting.


..  _caching-backend-null:

Null Backend
============

The null backend is a dummy backend which doesn't store any data and always returns :code:`false`
on :code:`get()`. This backend is useful in a development context to "switch off" a cache.
