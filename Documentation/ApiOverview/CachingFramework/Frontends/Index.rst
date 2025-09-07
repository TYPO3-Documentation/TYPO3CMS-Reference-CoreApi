.. include:: /Includes.rst.txt

.. _caching-frontend:

===============
Cache frontends
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
