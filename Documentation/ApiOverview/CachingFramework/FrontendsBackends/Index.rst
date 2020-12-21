.. include:: /Includes.rst.txt



.. _caching-frontend:

===============
Cache Frontends
===============


.. _caching-frontend-api:

Frontend API
============

All frontends must implement the API defined in interface :code:`TYPO3\CMS\Core\Cache\Frontend\FrontendInterface`.
All operations on a specific cache must be done with these methods. The frontend object of a cache is the main object
any cache manipulation is done with, usually the assigned backend object should not be used directly.

.. t3-field-list-table::
 :header-rows: 1

 - :Method,30: Method
   :Description,70: Description

 - :Method:
      getIdentifier
   :Description:
      Returns the cache identifier.

 - :Method:
      getBackend
   :Description:
      Returns the backend instance of this cache. It is seldom needed in usual code.

 - :Method:
      set
   :Description:
      Sets/overwrites an entry in the cache.

 - :Method:
      get
   :Description:
      Returns the cache entry for the given identifier.

 - :Method:
      has
   :Description:
      Checks for existence of a cache entry.
      Do no use this prior to :code:`get()` since :code:`get()`
      returns NULL if an entry does not exist.

 - :Method:
      remove
   :Description:
      Removes the entry for the given identifier from the cache.

 - :Method:
      flushByTag
   :Description:
      Flushes all cache entries which are tagged with the given tag.

 - :Method:
      collectGarbage
   :Description:
      Calls the garbage collection method of the backend.
      This is important for backends which are unable to do this internally
      (like the DB backend).

 - :Method:
      isValidEntryIdentifier
   :Description:
      Checks if a given identifier is valid.

 - :Method:
      isValidTag
   :Description:
      Checks if a given tag is valid.

 - :Method:
      requireOnce
   :Description:
      **PhpFrontend only** Requires a cached PHP file directly.


.. _caching-frontend-avalaible:

Available Frontends
===================

Currently two different frontends are implemented. The main difference are
the data types which can be stored using a specific frontend.


.. _caching-frontend-variable:

Variable Frontend
-----------------

Strings, arrays and objects are accepted by this frontend.
Data is serialized before it is passed to the backend.

.. tip::
   The variable frontend is the most frequently used frontend and handles
   the widest range of data types.


.. _caching-frontend-php:

PHP Frontend
------------

This is a special frontend to cache PHP files. It extends the string frontend
with the method :code:`requireOnce()` which allows PHP files to be :code:`require()`'d
if a cache entry exists. This can be used by extensions to cache and speed up loading
of calculated PHP code and becomes handy if a lot of reflection and
dynamic PHP class construction is done.

A backend to be used in combination with the PHP frontend must implement the interface
:code:`TYPO3\CMS\Core\Cache\Backend\PhpCapableBackendInterface`. Currently the file backend and
the simple file backend fulfill this requirement.

.. note::

   The PHP frontend can **only** be used to cache PHP files.
   It does not work with strings, arrays or objects.
   It is **not** intended as a page content cache.


.. _caching-backend:

===============
Cache backends
===============

A variety of storage backends exists. They have different characteristics
and can be used for different caching needs. The best backend depends on
a given server setup and hardware, as well as cache type and usage.
A backend should be chosen wisely, as a wrong decision could end up actually
slowing down a TYPO3 installation.

.. _caching_backend-api:

Backend API
===========

All backends must implement at least interface :code:`TYPO3\CMS\Core\Cache\Backend\BackendInterface`.
All operations on a specific cache must be done with these methods. There are several further interfaces that can be
implemented by backends to declare additional capabilities. Usually, extension code should not handle cache backend operations
directly, but should use the frontend object instead.

.. t3-field-list-table::
 :header-rows: 1

 - :Method,30: Method
   :Description,70: Description

 - :Method:
      setCache
   :Description:
      Reference to the frontend which uses the backend. This method is mostly used internally.

 - :Method:
      set
   :Description:
      Save data in the cache.

 - :Method:
      get
   :Description:
      Load data from the cache.

 - :Method:
      has
   :Description:
      Checks if a cache entry with the specified identifier exists.

 - :Method:
      remove
   :Description:
      Remove a cache entry with the specified identifier.

 - :Method:
      flush
   :Description:
      Remove all cache entries.

 - :Method:
      collectGarbage
   :Description:
      Does garbage collection.

 - :Method:
      flushByTag
   :Description:
      **TaggableBackendInterface only** Removes all cache entries which are tagged by the specified tag.

 - :Method:
      findIdentifiersByTag
   :Description:
      **TaggableBackendInterface only** Finds and returns all cache entry identifiers which are tagged by the specified tag.

 - :Method:
      requireOnce
   :Description:
      **PhpCapableBackendInterface only** Loads PHP code from the cache and require_onces it right away.

 - :Method:
      freeze
   :Description:
      **FreezableBackendInterface only** Freezes this cache backend.

 - :Method:
      isFrozen
   :Description:
      **FreezableBackendInterface only** Tells if this backend is frozen.


.. _caching-backend-options:

Common Options
==============

.. t3-field-list-table::
 :header-rows: 1

 - :Option,20: Option
   :Description,50: Description
   :Mandatory,10: Mandatory
   :Type,10: Type
   :Default,10: Default

 - :Option:
      defaultLifetime
   :Description:
      Default lifetime in seconds of a cache entry if it is not specified for a specific entry on set()
   :Mandatory:
      No
   :Type:
      integer
   :Default:
      3600


.. _caching-backend-db:

Database Backend
================

This is the main backend suitable for most storage needs.
It does not require additional server daemons nor server configuration.

The database backend does not automatically perform garbage collection.
Instead the :ref:`Scheduler garbage collection task <caching-architecture-task>` should be used.

It stores data in the configured database (usually MySQL)
and can handle large amounts of data with reasonable performance.
Data and tags are stored in two different tables, every cache needs its own set of tables.
In terms of performance the database backend is already pretty well optimized
and should be used as default backend if in doubt. This backend is the default backend if no backend
is specifically set in the configuration.

The Core takes care of creating and updating required database tables "on the fly".

.. note::

   However, caching framework tables which are not needed anymore are not deleted automatically. That is why the database analyzer in the Install Tool will propose you to rename/delete caching framework tables after you changed the caching backend to a non-database one.

..

For caches with a lot of read and write operations, it is important to tune the MySQL setup.
The most important setting is :code:`innodb_buffer_pool_size`. A generic goal is to give MySQL
as much RAM as needed to have the main table space loaded completely in memory.

The database backend tends to slow down if there are many write operations
and big caches which do not fit into memory because of slow harddrive seek and write performance.
If the data table grows too big to fit into memory, it is possible to compress given data transparently
with this backend, which often shrinks the amount of needed space to 1/4 or less.
The overhead of the compress/uncompress operation is usually not high.
A good candidate for a cache with enabled compression is the Core pages cache:
it is only read or written once per request and the data size is pretty large.
The compression should not be enabled for caches which are read or written
multiple times during one request.

.. _caching-backend-db-innodb:

InnoDB Issues
-------------

The database backend for MySQL uses InnoDB tables. Due to the nature of InnoDB, deleting records
`does not reclaim <http://bugs.mysql.com/bug.php?id=1287>`_ the actual disk space. E.g. if the cache uses 10GB,
cleaning it will still keep 10GB allocated on the disk even though phpMyAdmin will show 0 as the cache table size.
To reclaim the space, turn on the MySQL option file_per_table, drop the cache tables and re-create
them using the Install Tool.
This does not by any mean that you should skip the scheduler task. Deleting records still improves performance.


.. _caching-backend-db-options:

Options
-------

.. t3-field-list-table::
 :header-rows: 1

 - :Option,20: Option
   :Description,50: Description
   :Mandatory,10: Mandatory
   :Type,10: Type
   :Default,10: Default

 - :Option:
      compression
   :Description:
      Whether or not data should be compressed with gzip.
      This can reduce size of the cache data table, but incurs CPU overhead
      for compression and decompression.
   :Mandatory:
      No
   :Type:
      boolean
   :Default:
      false

 - :Option:
      compressionLevel
   :Description:
      Gzip compression level (if the :code:`compression` option is set to :code:`true`).
      The default compression level is usually sufficient.
      - -1: Default gzip compression (recommended)
      - 0: No compression
      - 9: Maximum compression (costs a lot of CPU)
   :Mandatory:
      No
   :Type:
      integer from -1 to 9
   :Default:
      -1


.. _caching-backend-memcached:

Memcached Backend
=================

`Memcached <http://memcached.org/>`_ is a simple, distributed key/value RAM database.
To use this backend, at least one memcached daemon must be reachable,
and the PECL module "memcache" must be loaded.
There are two PHP memcached implementations: "memcache" and "memcached".
Currently, only memcache is supported by this backend.


.. _caching-backend-memcache-warning:

Warning and Design Constraints
------------------------------

Memcached is a simple key-value store by design . Since the caching framework
needs to structure it to store the identifier-data-tags relations, for each
cache entry it stores an identifier->data, identifier->tags and a
tag->identifiers entry.

This leads to structural problems:

- If memcache runs out of memory but must store new entries,
  it will toss *some* other entry out of the cache
  (this is called an eviction in memcached speak).
- If data is shared over multiple memcache servers and some server fails,
  key/value pairs on this system will just vanish from cache.

Both cases lead to corrupted caches. If, for example, a tags->identifier entry is lost,
:code:`dropByTag()` will not be able to find the corresponding identifier->data entries
which should be removed and they will not be deleted. This results in old data delivered by the cache.
Additionally, there is currently **no** implementation of the garbage collection that could rebuild cache integrity.

It is important to monitor a memcached system for evictions and server outages
and to clear caches if that happens.

Furthermore memcache has no sort of namespacing.
To distinguish entries of multiple caches from each other,
every entry is prefixed with the cache name.
This can lead to very long runtimes if a big cache needs to be flushed,
because every entry has to be handled separately and it is not possible
to just truncate the whole cache with one call as this would clear
the whole memcached data which might even hold non TYPO3 related entries.

Because of the mentioned drawbacks, the memcached backend should be used with care
or in situations where cache integrity is not important or if a cache has no need to use tags at all.
Currently, the memcache backend implements the TaggableBackendInterface, so the implementation does allow tagging,
even if it is not advised to used this backend together with heavy tagging.

.. warning::

   Since memcached has no sort of namespacing and access control,
   this backend should not be used if other third party systems have access
   to the same memcached daemon for security reasons.
   This is a typical problem in cloud deployments where access to memcache is cheap
   (but could be read by third parties) and access to databases is expensive.


.. _caching-backend-memcache-options:

Options
-------

.. t3-field-list-table::
 :header-rows: 1

 - :Option,20: Option
   :Description,50: Description
   :Mandatory,10: Mandatory
   :Type,10: Type
   :Default,10: Default

 - :Option:
      servers
   :Description:
      Array of used memcached servers. At least one server must be defined.
      Each server definition is a string, allowed syntaxes:

      - hostname or IP: TCP connect to host on memcached default port
        (usually 11211, defined by PHP ini variable :code:`memcache.default_port`)
      - hostname:port: TCP connect to host on port
      - tcp://hostname:port: Same as above
      - unix:///path/to/memcached.sock: Connect to memcached server using unix sockets
   :Mandatory:
      Yes
   :Type:
      array
   :Default:

 - :Option:
      compression
   :Description:
      Enable memcached internal data compression.
      Can be used to reduce memcached memory consumption,
      but adds additional compression / decompression CPU overhead
      on the related memcached servers.
   :Mandatory:
      No
   :Type:
      boolean
   :Default:
      false


.. _caching-backend-redis:

Redis Backend
=============

`Redis <http://redis.io/>`_ is a key-value storage/database.
In contrast to memcached, it allows structured values.
Data is stored in RAM but it allows persistence to disk
and doesn't suffer from the design problems of the memcached backend implementation.
The redis backend can be used as an alternative to the database backend
for big cache tables and helps to reduce load on database servers this way.
The implementation can handle millions of cache entries each with hundreds of tags
if the underlying server has enough memory.

Redis is known to be extremely fast but very memory hungry.
The implementation is an option for big caches with lots of data
because most important operations perform O(1) in proportion to the number of (redis) keys.
This basically means that the access to an entry in a cache with a million entries
is not slower than to a cache with only 10 entries,
at least if there is enough memory available to hold the complete set in memory.
At the moment only one redis server can be used at a time per cache,
but one redis instance can handle multiple caches without performance loss when flushing a single cache.

The garbage collection task should be run every once in a while to find and delete old tags.

The implementation is based on the PHP `phpredis <https://github.com/nicolasff/phpredis>`_ module,
which must be available on the system.

.. note::

   It is important to monitor the redis server and tune its settings
   to the specific caching needs and hardware capabilities.
   There are several articles on the net and the redis configuration file
   contains some important hints on how to speed up the system if it reaches bounds.
   A full documentation of available options is far beyond this documentation.

.. _caching-backend-redis-options:

Options
-------

.. t3-field-list-table::
 :header-rows: 1

 - :Option,20: Option
   :Description,50: Description
   :Mandatory,10: Mandatory
   :Type,10: Type
   :Default,10: Default

 - :Option:
      hostname
   :Description:
      IP address or name of redis server to connect to.
   :Mandatory:
      No
   :Type:
      string
   :Default:
      127.0.0.1

 - :Option:
      port
   :Description:
      Port of the redis daemon.
   :Mandatory:
      No
   :Type:
      integer
   :Default:
      6379

 - :Option:
      persistentConnection
   :Description:
      Activate a persistent connection to redis server. This could be a benefit under high load cloud setups.
   :Mandatory:
      No
   :Type:
      boolean
   :Default:
      false

 - :Option:
      database
   :Description:
      Number of the database to store entries. Each cache should use its own database,
      otherwise all caches sharing a database are flushed if the flush operation
      is issued to one of them. Database numbers 0 and 1 are used and flushed by the Core unit tests
      and should not be used if possible.
   :Mandatory:
      No
   :Type:
      integer
   :Default:
      0

 - :Option:
      password
   :Description:
      Password used to connect to the redis instance if the redis server needs authentication.

      .. warning::

         The password is sent to the redis server in plain text.
   :Mandatory:
      No
   :Type:
      string
   :Default:


 - :Option:
      compression
   :Description:
      Whether or not data compression with gzip should be enabled.
      This can reduce cache size, but adds some CPU overhead for the compression
      and decompression operations in PHP.
   :Mandatory:
      No
   :Type:
      boolean
   :Default:
      false

 - :Option:
      compressionLevel
   :Description:
      Set gzip compression level to a specific value. The default compression level is usually sufficient.

      - -1: Default gzip compression (recommended)
      - 0: No compression
      - 9: Maximum compression (but more CPU overhead)
   :Mandatory:
      No
   :Type:
      integer from -1 to 9
   :Default:
      -1


.. _caching-backend-wincache:

Wincache Backend
================

`Wincache <http://www.iis.net/downloads/microsoft/wincache-extension>`_ is a PHP opcode cache similar to APC, but
dedicated to the Windows OS platform. Similar to APC, the cache can also be used as in-memory key/value cache.

The cache backend implementation is nearly identical to the implementation of `APC backend <https://docs.typo3.org/m/typo3/reference-coreapi/9.5/en-us/ApiOverview/CachingFramework/FrontendsBackends/Index.html#apc-backend>`_ and has the same design constrains.


.. _caching-backend-file:

File Backend
============

The file backend stores every cache entry as a single file to the file system.
The lifetime and tags are added after the data part in the same file.

This backend is the big brother of the Simple file backend and implements additional interfaces. Like the simple file
backend it also implements the :code:`PhpCapableInterface`, so it can be used with :code:`PhpFrontend`. In contrast to
the simple file backend it furthermore implements :code:`TaggableInterface` and :code:`FreezableInterface`.

A frozen cache does no lifetime check and has a list of all existing cache entries that is reconstituted during initialization.
As a result, a frozen cache needs less file system look ups and calculation time if accessing cache entries. On the other
hand, a frozen cache can not manipulate (remove, set) cache entries anymore. A frozen cache must flush the complete cache
again to make cache entries writable again. Freezing caches is currently not used in the TYPO3 Core. It can be an option
for code logic that is able to calculate and set all possible cache entries during some initialization phase, to then freeze
the cache and use those entries until the whole thing is flushed again. This can be useful especially if caching PHP code.

In general, the backend was specifically optimized to cache PHP code, the :code:`get` and :code:`set` operations have low
overhead. The file backend is not very good with tagging and does not scale well with the number of tags. Do not use this
backend if cached data has many tags.

.. warning::

   The performance of :code:`flushByTag()` is bad and scales just O(n).

   On the contrary performance of :code:`get()` and :code:`set()` operations.
   is good and scales well. Of course if many entries have to be handled, this might
   still slow down after a while and a different storage strategy should be used
   (e.g. RAM disks, battery backed up RAID systems or SSD hard disks).


.. _caching-backend-file-options:

Options
-------

.. t3-field-list-table::
 :header-rows: 1

 - :Option,20: Option
   :Description,50: Description
   :Mandatory,10: Mandatory
   :Type,10: Type
   :Default,10: Default

 - :Option:
      cacheDirectory
   :Description:
      The directory where the cache files are stored. By default it is assumed that the directory is below
      :code:`TYPO3_DOCUMENT_ROOT`. However, an absolute path can be selected, too. Every cache should be assigned
      its own directory, otherwise flushing of one cache would flush all other caches within the same directory as well.
   :Mandatory:
      No
   :Type:
      string
   :Default:
      typo3temp/cache/


.. _caching-backend-simple-file:

Simple File Backend
===================

The simple file backend is the small brother of the :ref:`file backend <caching-backend-file>`. In contrast to most
other backends, it does not implement the :code:`TaggableInterface`, so cache entries can not be tagged and flushed
by tag. This improves the performance if cache entries do not need such tagging. The TYPO3 Core uses this backend
for its central Core cache (that hold autoloader cache entries and other important cache entries). The Core cache is
usually flushed completely and does not need specific cache entry eviction.


.. _caching-backend-pdo:

PDO Backend
===========

The PDO backend can be used as a native PDO interface to databases which are connected to PHP via PDO.
It is an alternative to the database backend if a cache should be stored in a database which is otherwise
only supported by TYPO3 dbal to reduce the parser overhead.

The garbage collection is implemented for this backend and should be called to clean up hard disk space or memory.

.. note::

   There is currently very little production experience with this backend, especially not with a capable database like Oracle.
   Any feedback for real life use cases of this cache is appreciated.


.. _caching-backend-pdo-options:

Options
-------

.. t3-field-list-table::
 :header-rows: 1

 - :Option,20: Option
   :Description,50: Description
   :Mandatory,10: Mandatory
   :Type,10: Type
   :Default,10: Default

 - :Option:
      dataSourceName
   :Description:
      Data source name for connecting to the database. Examples:

      - mysql:host=localhost;dbname=test
      - sqlite:/path/to/sqlite.db
      - sqlite::memory
   :Mandatory:
      Yes
   :Type:
      string
   :Default:

 - :Option:
      username
   :Description:
      Username for the database connection.
   :Mandatory:
      No
   :Type:
      string
   :Default:

 - :Option:
      password
   :Description:
      Password to use for the database connection.
   :Mandatory:
      No
   :Type:
      string
   :Default:


.. _caching-backend-transient:

Transient Memory Backend
========================

The transient memory backend stores data in a PHP array. It is only valid for one request. This becomes handy if code
logic needs to do expensive calculations or must look up identical information from a database over and over again
during its execution. In this case it is useful to store the data in an array once and just lookup the entry from the
cache for consecutive calls to get rid of the otherwise additional overhead. Since caches are available system wide and
shared between Core and extensions they can profit from each other if they need the same information.

Since the data is stored directly in memory, this backend is the quickest backend available. The stored data adds to
the memory consumed by the PHP process and can hit the :code:`memory_limit` PHP setting.


.. _caching-backend-null:

Null Backend
============

The null backend is a dummy backend which doesn't store any data and always returns :code:`false`
on :code:`get()`. This backend becomes handy in development context to practically "switch off" a cache.
