..  include:: /Includes.rst.txt

..  _caching-developer:

=====================
Developer Information
=====================

This chapter is targeted at extension authors who want to use the caching
framework for their needs. It is about how to use the framework properly. For
details about its inner working, please refer to the
:ref:`section about architecture <caching-architecture>`.

Example usages can be found throughout the TYPO3 Core, in particular in the system
extensions `core` and `extbase`.


..  _caching-developer-usage:
..  _caching-developer-registration:

Cache Registration
==================

Registration of a new cache should be done in an extension's :ref:`ext-localconf-php`. The
example below defines an empty sub-array in `cacheConfigurations`. Neither
*frontend* nor *backend* are defined, meaning that the cache manager will choose
the default :ref:`variable frontend <caching-frontend-variable>` and the
:ref:`database backend <caching-backend-db>` by default.

..  code-block:: php
    :caption: EXT:some_extension/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']
        ??= [];

..  tip::
    The null coalescing assignment operator (:code:`??=`) check is used to
    enable administrators to overwrite configuration of caches in
    :file:`config/system/settings.php`. During :ref:`bootstrap <bootstrapping>`,
    any :file:`ext_localconf.php` is loaded **after**
    :file:`config/system/settings.php` and :file:`config/system/additional.php`
    are loaded, so it is important to make sure that the administrator did not
    already set any configuration of the extensions cache.

If special settings are needed, for example a specific backend (like the
transient memory backend), it can be defined with an additional line below the
cache array declaration. The extension documentation should hint an integrator
about specific caching needs or setups in this case.

..  tip::
    Extensions should not force specific settings, therefore the null coalescing
    assignment operator (:code:`??=`) is used to allow administrators to
    overwrite those settings. It is recommended to set up a cache configuration
    with sane defaults, but administrators should always be able to overwrite
    them for whatever reason.

..  code-block:: php
    :caption: EXT:some_extension/ext_localconf.php

    // use \TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']
        ??= [];
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['backend']
        ??= TransientMemoryBackend::class;


..  _caching-developer-example:
..  _caching-developer-access:

Using the Cache
===============

First, we need to prepare injection of our cache by setting it up as service in
the :ref:`container service configuration
<configure-dependency-injection-in-extensions>`:

..  code-block:: yaml
    :caption: EXT:some_extension/Configuration/Services.yaml

    services:
      _defaults:
        autowire: true
        autoconfigure: true
        public: false

      Vendor\SomeExtension\:
        resource: '../Classes/*'

      cache.myext_mycache:
        class: TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
        factory: ['@TYPO3\CMS\Core\Cache\CacheManager', 'getCache']
        arguments: ['myext_mycache']

The name of the service for the injection configuration is
:yaml:`cache.myext_mycache`, the name of the cache is `myext_mycache` (as
defined in :php:`ext_localconf.php`). Both can be anything you like, just make
sure they are unique and clearly hint at the purpose of your cache.

..  note::
    Since TYPO3v10, you should prefer :ref:`dependency injection
    <DependencyInjection>` to retrieve cache frontends whenever possible and no
    longer use the :php:`CacheManager` directly.

Here is some example code which retrieves the cache via dependency injection:

..  code-block:: php
    :caption: EXT:some_extension/Classes/MyClass.php

    namespace Vendor\SomeExtension;

    use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

    class MyClass
    {
        private FrontendInterface $cache;

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

..  tip::
    It is not needed to call :php:`$this->cache->has()` before accessing cache
    entries with :php:`$this->cache->get()` as the latter returns :php:`false`
    if no entry exists.

Since the auto-wiring feature of the dependency injection container cannot
detect which cache configuration should be used for the :php:`$cache` argument
of :php:`MyClass`, the :ref:`container service configuration
<configure-dependency-injection-in-extensions>` needs to be extended:

..  code-block:: yaml
    :caption: EXT:some_extension/Configuration/Services.yaml

    services:
      # other configurations

      Vendor\SomeExtension\MyClass:
        arguments:
          $cache: '@cache.myext_mycache'

Here :yaml:`@cache.myext_mycache` refers to the cache service we defined above.
This setup allows you to freely inject the very same cache into any class.

..  note::
    After changes in the :file:`Services.yaml` file flush the cache via
    :guilabel:`Admin Tools > Maintenance` or the :ref:`CLI command
    <symfony-console-commands>` `cache:flush`.
