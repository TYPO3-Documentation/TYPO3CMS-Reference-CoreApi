..  include:: /Includes.rst.txt

..  _caching-backend:

==============
Cache backends
==============

TYPO3 offers several storage backends. Each of them has its own
characteristics and suits different caching needs. The best backend for a
cache depends on your server, your hardware, the type of the cache and the way
the cache is used. Choose the backend with care: the wrong one slows your TYPO3
installation down.

..  _caching_backend-api:

Backend API
===========

All backends must implement the :code:`TYPO3\CMS\Core\Cache\Backend\BackendInterface`.

..  versionchanged:: 14.0
    The :php-short:`\TYPO3\CMS\Core\Cache\Backend\FreezableBackendInterface`
    has been removed. See `Breaking: #107310 - Remove FreezableBackendInterface <https://docs.typo3.org/permalink/changelog:breaking-107310-1755533400>`_.

..  _caching_backend-api-BackendInterface:

`BackendInterface`
------------------

..  include:: /CodeSnippets/Manual/Cache/BackendInterface.rst.txt

Every operation on a cache uses one of the methods above. A backend can
implement further interfaces to add more functionality. In your extension, do
not call the methods of a backend directly. Use the frontend object instead.

..  _caching_backend-api-TaggableBackendInterface:

`TaggableBackendInterface`
--------------------------

..  include:: /CodeSnippets/Manual/Cache/TaggableBackendInterface.rst.txt

..  _caching_backend-api-PhpCapableBackendInterface:

`PhpCapableBackendInterface`
----------------------------

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

Database backend
================

The database backend is the default backend. TYPO3 uses it whenever the
configuration does not name another backend. It suits most storage needs and
needs no additional server daemon and no server configuration.

The backend stores the data in a database, usually MySQL, and handles large
amounts of data at a reasonable speed. It stores the data and the tags in two
tables, and each cache has its own pair of tables. The TYPO3 Core creates and
updates these tables itself.

The database backend does not collect garbage on its own. Use the
:ref:`Scheduler garbage collection task <caching-architecture-task>` instead.

..  note::

    TYPO3 does not delete the tables of a cache that no longer uses the
    database backend. The database analyzer in the Install Tool therefore
    suggests that you rename or delete these tables after you switch a cache
    to another backend.

Tune your MySQL server if a cache has many read and write operations. The
most important setting is :code:`innodb_buffer_pool_size`. Give MySQL enough
RAM to keep the main table space in memory.

The database backend becomes slower when a cache has many write operations
and does not fit into memory, because the hard drive then limits the speed.
Switch :confval:`compression <caching-backend-compression>` on for a cache
whose data table is too large for the memory. Compression shrinks the needed
space to a quarter or less, and it costs little CPU time. The pages cache of
the TYPO3 Core is a good candidate: its data is large, and each request reads
or writes it only once. Do not switch compression on for a cache that a single
request reads or writes several times.

..  _caching-backend-db-innodb:

`InnoDB` issues
---------------

The MySQL database backend uses InnoDB tables. InnoDB
`does not reclaim <https://bugs.mysql.com/bug.php?id=1287>`_ the disk space of
deleted records. A cache that uses 10 GB therefore still occupies 10 GB after
you clean it, although phpMyAdmin reports a table size of 0. To get the space
back, switch the MySQL option `file_per_table` on, drop the cache tables and
create them again in the Install Tool.

Run the Scheduler task nonetheless. Deleting the records still improves the
performance.


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


..  _caching-backend-compressionLevel:

compressionLevel
~~~~~~~~~~~~~~~~

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

`Memcached <https://memcached.org/>`_ is a distributed key-value store that
keeps its data in RAM. This backend needs at least one reachable memcached
daemon and the loaded PECL module `memcache`. PHP has two memcached
extensions, `memcache` and `memcached`. This backend supports `memcache` only.


..  _caching-backend-memcache-warning:

Limitations of memcached backends
---------------------------------

Memcached is a key-value store. The caching framework needs more structure
than that, so it stores three entries for each cache entry: identifier to
data, identifier to tags, and tag to identifiers.

This causes two problems:

-   Memcached deletes *some* other entry when it runs out of memory and has
    to store a new one. Memcached calls this an eviction.
-   Entries vanish when the data is spread over several memcached servers and
    one of these servers fails.

Both cases corrupt the cache. If a tag-to-identifier entry is lost, for
example, :code:`dropByTag()` no longer finds the matching identifier-to-data
entries and does not delete them. The cache then delivers outdated data. There
is **no** garbage collection that rebuilds the integrity of the cache.

Monitor a memcached system for evictions and for server outages, and flush the
caches when either of them happens.

Memcached also has no namespaces. TYPO3 prefixes every entry with the name of
the cache to keep the caches apart. Flushing a large cache therefore takes a
long time, because TYPO3 deletes each entry separately. It cannot truncate the
whole store in one call, because that would also delete the entries of other
applications.

Use the memcached backend with care. It fits a cache whose integrity does not
matter, or a cache that does not use tags. The backend implements the
:php-short:`\TYPO3\CMS\Core\Cache\Backend\TaggableBackendInterface`, so
tagging works, but do not use this backend for heavy tagging.

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


..  _caching-backend-memcached-compression:

compression
~~~~~~~~~~~

..  confval:: compression
    :name: caching-backend-memcached-compression
    :type: boolean
    :default: false

    Enable memcached internal data compression.
    Can be used to reduce memcached memory consumption,
    but adds additional compression / decompression CPU overhead
    on the memcached servers.

..  _caching-backend-redis:

Redis backend
=============

`Redis <https://redis.io/>`_ is a key-value store. Unlike memcached it allows
structured values. Redis keeps the data in RAM and can also write it to disk,
and it does not have the design problems of the memcached backend. Use the
Redis backend instead of the database backend for large caches, to take load
off the database server. It handles millions of cache entries, each with
hundreds of tags, if the server has enough memory.

Redis is very fast and needs a lot of memory. Most operations perform in O(1)
in proportion to the number of Redis keys: reading an entry from a cache with
a million entries takes as long as reading from a cache with ten entries, as
long as the whole set fits into the memory. A cache uses one Redis server at a
time. One Redis instance serves several caches, and flushing one of them does
not slow down the others.

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

The configuration of the Redis backend resembles the configuration of the
other backends, with one exception: keep caches apart that use the same keys.
The `pages` and the `pagesection` cache are such a pair. Both use
`tagIdents:pageId_21566` for the page with the ID 21566.

How you keep them apart is a decision for the system administrator. The
examples below use one Redis database per cache. In production another way may
suit you better, because a Redis Cluster supports one database only. Separate
caches have a second advantage: you can flush each of them on its own.

Store your own caches in one database if each of them uses unique keys, for
example through its own prefix per cache identifier. Keep the caches of the
TYPO3 Core apart nonetheless.

    In practical terms, Redis databases should be used to separate different keys
    belonging to the same application (if needed), and not to use a single Redis
    instance for multiple unrelated applications.

    https://redis.io/commands/select/

..  The paragraph above is an intentional quote!


..  literalinclude:: _redis.php
    :caption: config/system/additional.php | typo3conf/system/additional.php


..  _caching-backend-redis-options:

Options for the redis caching backend
-------------------------------------

..  confval:: servers
    :name: caching-backend-redis-hostname
    :type: string
    :default: `127.0.0.1`

    IP address or name of redis server to connect to.


..  _caching-backend-redis-port:

port
~~~~

..  confval:: port
    :name: caching-backend-redis-port
    :type: integer
    :default: `6379`

    Port of the redis daemon.


..  _caching-backend-redis-persistentConnection:

persistentConnection
~~~~~~~~~~~~~~~~~~~~

..  confval:: persistentConnection
    :name: caching-backend-redis-persistentConnection
    :type: boolean
    :default: `false`

    Activate a persistent connection to a redis server. This is a good idea
    in high load cloud setups.


..  _caching-backend-redis-database:

database
~~~~~~~~

..  confval:: database
    :name: caching-backend-redis-database
    :type: integer
    :default: `0`

    Number of the database to store entries. Each cache should have its own database,
    otherwise caches sharing a database are all flushed if the flush operation
    is issued to one of them. Database numbers 0 and 1 are used and flushed by the Core unit tests
    and should not be used if possible.


..  _caching-backend-redis-keyPrefix:

keyPrefix
~~~~~~~~~

..  confval:: keyPrefix
    :name: caching-backend-redis-keyPrefix
    :type: string
    :default: (empty)

    ..  versionadded:: 13.3

        See `Feature: #104451 - Redis backends support for key prefixing
        <https://docs.typo3.org/permalink/changelog:feature-104451-1721646565>`_.

    Prefix added to all keys this backend writes to Redis. Allows the same
    Redis database to be shared by multiple caches or TYPO3 instances, as
    long as the prefix is unique. If only one cache sharing the database has
    no prefix set, flushing it flushes the whole database.


..  _caching-backend-redis-username:

username
~~~~~~~~

..  confval:: username
    :name: caching-backend-redis-username
    :type: string

    ..  versionadded:: 14.0

    Use this option to authenticate against Redis using both a username and a
    password:

    ..  literalinclude:: _redis_password.php
        :caption: config/system/additional.php


..  _caching-backend-redis-password:

password
~~~~~~~~

..  confval:: password
    :name: caching-backend-redis-password
    :type: string

    ..  versionchanged:: 15.0
        Setting this configuration option with an array is no longer
        supported. Use the separate `username` and `password` options
        instead. See `Breaking: #109783 - Deprecated functionality removed
        <https://docs.typo3.org/permalink/changelog:breaking-109783-1776735296>`_

    Password used to connect to the redis instance if the redis server needs authentication.

    ..  warning::

        The password is sent to the redis server as plain text.


..  _caching-backend-redis-compression:

compression
~~~~~~~~~~~

..  confval:: compression
    :name: caching-backend-redis-compression
    :type: boolean
    :default: false

    Whether or not data compression with gzip should be enabled.
    This can reduce cache size, but adds some CPU overhead for the compression
    and decompression operations in PHP.


..  _caching-backend-redis-compressionLevel:

compressionLevel
~~~~~~~~~~~~~~~~

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

Flushing by cache tag only works while the cache entries and the cache tags
belong together. The eviction policy of the server (`maxmemory-policy`) can
break that. The page cache holds these entries for the page with the ID 81712,
for example:

#.  `tagIdents:pageId_81712` (tag->identifier relation)
#.  `identTags:81712_7e9c8309692aa221b08e6d5f6ec09fb6` (identifier->tags relation)
#.  `identData:81712_7e9c8309692aa221b08e6d5f6ec09fb6` (identifier->data)

When Redis runs out of memory it evicts entries, and nothing makes it evict
the related entries as well. With `maxmemory-policy allkeys-lru`, for example,
the data entry (`identData`) can survive while the tag entry (`tagIdents`)
disappears. The tag entry holds the relation "cache tag to cache identifier",
which :php:`RedisBackend::flushByTag()` needs. Without it, TYPO3 can no longer
flush the page cache for that page, neither when an editor changes the content
of the page nor when somebody flushes that page cache explicitly. Only a full
cache flush then helps.

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
    Recommended. Redis removes only entries that have an expiration date, and
    it therefore keeps the `tagIdents` entries.

noeviction
    Not recommended. Redis stores no new entry once the memory is full. Use
    this policy only if the memory is always sufficient.

allkeys-lru, allkeys-lfu, allkeys-random
    Not recommended. Redis can remove a `tagIdents` entry and keep the related
    `identData` entry. TYPO3 then cannot flush these entries by tag, which it
    needs for flushing the cache of a changed page.

..  seealso::

    *   `Redis eviction policies <https://redis.io/docs/latest/operate/rs/databases/memory-performance/eviction-policy/>`__
    *   `Redis configuration <https://redis.io/docs/latest/operate/oss_and_stack/management/config/>`__

..  _caching-backend-file:

File backend
============

The file backend stores each cache entry as one file in the file system. It
writes the lifetime and the tags into the file, after the data.

The backend is the larger variant of the :ref:`simple file backend
<caching-backend-simple-file>`. Both implement the
:php:`PhpCapableInterface`, so both work with the :php:`PhpFrontend`. Only the
file backend also implements the :php:`TaggableInterface`.

The backend caches PHP code well, because its `get` and `set` operations need
little time. It handles tags poorly: the more tags a cache uses, the slower it
becomes. Do not use this backend for data with many tags.

..  warning::

    :code:`flushByTag()` performs in O(n) and is therefore slow.

    :code:`get()` and :code:`set()` are fast and scale well. A cache with many
    entries still slows down over time. Store such a cache on faster hardware,
    for example on a RAM disk, an SSD or a battery-backed RAID system.

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

Simple file backend
===================

The simple file backend is the smaller variant of the :ref:`file backend
<caching-backend-file>`. Unlike most other backends it does not implement the
:code:`TaggableInterface`, so you cannot tag its entries and cannot flush them
by tag. This makes the backend faster for caches that do not need tags. The
TYPO3 Core uses it for the central Core cache, which holds the autoloader
entries and other important entries. TYPO3 flushes that cache as a whole and
never removes single entries from it.


..  _caching-backend-pdo:

PDO backend
===========

The PDO backend talks to a database through PHP's native PDO interface. Use
it instead of the database backend when a cache belongs in a database that
TYPO3 otherwise reaches through DBAL, because PDO saves the parser overhead.

The backend collects garbage, which frees disk space or memory. Call the
garbage collection regularly.

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


..  _caching-backend-pdo-username:

username
~~~~~~~~

..  confval:: username
    :name: caching-backend-pdo-username
    :type: string

    Username for the database connection.



..  _caching-backend-pdo-password:

password
~~~~~~~~

..  confval:: password
    :name: caching-backend-pdo-password
    :type: string

    Password to use for the database connection.


..  _caching-backend-transient:

Transient memory backend
========================

The transient memory backend stores the data in a PHP array, which lives for
one request only. Use it for an expensive calculation, or for a value that the
code reads from the database again and again. The first call stores the value
in the array, and every further call reads it from there. The TYPO3 Core and
the extensions share the caches of an installation, so they also share these
values.

This backend is the fastest one, because the data stays in memory. That data
adds to the memory of the PHP process and can reach the PHP setting
:code:`memory_limit`.


..  _caching-backend-null:

Null backend
============

The null backend stores nothing and always returns :code:`false` on
:code:`get()`. Use it during development to switch a cache off.
