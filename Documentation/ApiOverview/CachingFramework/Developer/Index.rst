.. include:: /Includes.rst.txt



.. _caching-developer:

=====================
Developer Information
=====================

This chapter is targeted at extension authors who want to use the caching framework
for their needs. It is about how to use the framework properly. For details about
its inner working, please refer to the :ref:`section about architecture <caching-architecture>`.

Example usages can be found throughout the TYPO3 CMS Core, in particular in
system extension `core` and `extbase`.


.. _caching-developer-usage:
.. _caching-developer-registration:

Cache Registration
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


.. _caching-developer-example:
.. _caching-developer-access:

Using the Cache
===============

First, we need to prepare injection of our cache by setting it up as service in the :ref:`container
service configuration <configure-dependency-injection-in-extensions>`:

.. code-block:: yaml

    services:
      cache.my_cache:
        class: TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
        factory: ['@TYPO3\CMS\Core\Cache\CacheManager', 'getCache']
        arguments: ['myext_mycache']

The name of the service for the injection configuration is :`cache.mycache`, the name of the cache is `myext_mycache`.
Both can be anything you like, just make sure they are unique and clearly hint at the purpose of your cache.

.. note::

   Since TYPO3v10, you should prefer :ref:`dependency injection <DependencyInjection>`
   to retrieve cache frontends whenever possible and no longer use the :php:`CacheManager` directly.

Here is some example code which retrieves the cache via dependency injection::

   namespace Acme\MyExt;
   
   use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
   
   class MyClass
   {
       /**
        * @var FrontendInterface
        */
       private $cache;

       public function __construct(FrontendInterface $cache)
       {
           $this->cache = $cache;
       }

       protected function getCachedValue()
       {
           $cacheIdentifier = /* ... logic to determine the cache identifier ... */;

           // If $entry is false, it hasn't been cached. Calculate the value and store it in the cache:
           if (($value = $this->cache->get($cacheIdentifier)) === false) {
               $value = /* ... Logic to calculate value ... */;
               $tags = /* ... Tags for the cache entry ... */
               $lifetime = /* ... Calculate/Define cache entry lifetime ... */

               // Save value in cache
               $this->cache->set($cacheIdentifier, $value, $tags, $lifetime);
           }
           
           return $value;
       }

.. tip::

   It isn't needed to call :code:`has()` before accessing cache entries with :code:`get()`
   as the latter returns :code:`false` if no entry exists.

Since the auto-wiring feature of the dependency injection container cannot detect
which cache configuration should be used for the :php:`$cache` argument of :php:`MyClass`,
the :ref:`container service configuration <configure-dependency-injection-in-extensions>`
needs to be extended:

.. code-block:: yaml

    services:
      Acme\MyExt\MyClass:
        arguments:
          $cache: '@cache.my_cache'

Here `@cache.my_cache` refers to the cache service we defined above. This setup allows you
to freely inject the very same cache into any class.
