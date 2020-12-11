.. include:: /Includes.rst.txt
.. _caching-developer:

=====================
Developer information
=====================

This chapter is targeted at extension authors who want to use the caching framework
for their needs. It is about how to use the framework properly. For details about
its inner working, please refer to the :ref:`section about architecture <caching-architecture>`.

Example usages can be found throughout the TYPO3 CMS Core, in particular in
system extension "core" and "extbase".


.. index::
   Caching; Registration
.. _caching-developer-usage:
.. _caching-developer-registration:

Cache registration
==================

Registration of a new cache should be done in :file:`ext_localconf.php`. The example below just defines
an empty sub-array in *cacheConfigurations*. Neither *frontend* nor *backend* are defined,
meaning that the cache manager will choose the default :ref:`variable frontend <caching-frontend-variable>`
and the :ref:`database backend <caching-backend-db>` by default.

.. code-block:: php

   if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'])) {
       $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'] = [];
   }

.. tip::

   The :code:`is_array()` check is done to enable administrators to overwrite configuration of caches
   in :file:`LocalConfiguration.php`. During bootstrap, any :file:`ext_localconf.php` is loaded **after**
   :file:`DefaultConfiguration.php` and :file:`AdditionalConfiguration.php` are loaded, so it is
   important to make sure that the administrator did not already set any configuration of the
   extensions cache.

If special settings are needed, for example a specific backend (like the transient memory backend),
it can be defined with an additional line below the cache array declaration. The extension documentation
should hint an integrator about specific caching needs or setups in this case.

.. tip::

   Extensions should not force specific settings, therefore the selection is again encapsulated in a
   :code:`if (!isset())` check to allow administrators to overwrite those settings.
   It is recommended to set up a cache configuration with sane defaults,
   but administrators should always be able to overwrite them for whatever reason.

.. code-block:: php

   if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'])) {
       $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'] = [];
   }
   if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['backend'])) {
       $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['backend'] = \TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend::class;
   }


.. index::
   Caching; Dependency injection
   Caching; CacheManager
.. _caching-developer-example:
.. _caching-developer-access:

Using the Cache
===============

Since TYPO3 10.1, you should prefer :ref:`dependency injection <DependencyInjection>`
to retrieve cache frontends whenever possible and no longer use the `CacheManager` directly.


Here is some example code::

   class MyClass
   {
       /**
        * @var TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
        */
       private $cache;

       public function __construct(FrontendInterface $cache)
       {
           $this->cache = $cache;
       }

       protected function getCachedMagic()
       {
           $cacheIdentifier = $this->calculateCacheIdentifier();

           // If $entry is false, it hasn't been cached. Calculate the value and store it in the cache:
           if (($entry = $this->cache->get($cacheIdentifier)) === false) {
               $entry = $this->calculateMagic();

               // [calculate lifetime and assigned tags]

               // Save value in cache
               $this->cache->set($cacheIdentifier, $entry, $tags, $lifetime);
           }
           return $entry;
       }

Since the auto-wiring feature of the dependency injection container cannot detect
which cache configuration should be used for the :php:`$cache` argument, the :ref:`container
service configuration <configure-dependency-injection-in-extensions>` needs to be extended as well:

.. code-block:: yaml

    services:
      cache.my_cache:
        class: TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
        factory: ['@TYPO3\CMS\Core\Cache\CacheManager', 'getCache']
        arguments: ['myext_mycache']

      MyClass:
        arguments:
          $cache: '@cache.my_cache'

.. tip::

   It isn't needed to call :code:`has()` before accessing cache entries with :code:`get()`
   as the latter returns :code:`false` if no entry exists.
