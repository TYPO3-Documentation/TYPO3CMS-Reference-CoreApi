..  include:: /Includes.rst.txt

..  _caching-frontend:

===============
Cache frontends
===============

A *cache frontend* is the public API for interacting with a cache. It defines
which value types are accepted and how they are prepared for storage
(for example serialization or compilation), while delegating persistence to the
assigned backend. In everyday use, extensions should work with the frontend
only — direct access to the caching backend is discouraged.

..  _caching-frontend-api:

Caching frontend API
====================

All caching frontends must implement the interface
:php:`\TYPO3\CMS\Core\Cache\Frontend\FrontendInterface`.

..  include:: /CodeSnippets/Manual/Cache/FrontendInterface.rst.txt

The specific cache frontend implementation migth offer additional methods.

..  _caching-frontend-avalaible:

Available cache frontend implementations
========================================

Two frontends are currently available. They primarily differ in the data
types they accept and how values are handled before they are passed to
the backend.

..  _caching-frontend-variable:

Variable frontend
-----------------

This frontend accepts strings, arrays, and objects.
Values are serialized before they are written to the caching backend.

It is implemented in :php:`TYPO3\CMS\Core\Cache\Frontend\VariableFrontend`.

..  tip::
    The variable frontend is the most frequently used frontend and handles
    the widest range of data types.


..  _caching-frontend-php:

PHP frontend
------------

This frontend is specialized for caching executable PHP files. It adds the
methods :php:`requireOnce()` and :php:`require()` to load a cached file
directly. This is useful for extensions that generate PHP code at runtime,
for example when heavy reflection or dynamic class construction is involved.

It is implemented in :php:`TYPO3\CMS\Core\Cache\Frontend\PhpFrontend`.

A backend used with the PHP frontend must implement
:php:`\TYPO3\CMS\Core\Cache\Backend\PhpCapableBackendInterface`. The file
backend and the simple file backend currently fulfill this requirement.

In addition to the methods defined by
:php:`\TYPO3\CMS\Core\Cache\Frontend\FrontendInterface`, it provides:

`requireOnce($entryIdentifier)`
    Loads PHP code from the cache and :php:`require_once` it right away.
`require(string $entryIdentifier)`
    Loads PHP code from the cache and `require()` it right away.

Unlike `require_once()`, `require()` is safe **only** when the cached code can be
included multiple times within a single request. Files that declare classes,
functions, or constants may trigger redeclaration errors.

..  note::

    The PHP caching frontend can **only** be used to cache PHP files.
    It does not work with strings, arrays or objects.
    It is **not** intended as a page content cache.
