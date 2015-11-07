.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt



.. _caching-developer:

Developer information
^^^^^^^^^^^^^^^^^^^^^

This chapter is targeted at extension authors who want to use the caching framework
for their needs. It is about how to use the framework properly. For details about
its inner working, please refer to the :ref:`section about architecture <caching-architecture>`.

Example usages can be found throughout the TYPO3 CMS Core, in particular in
system extension "core" and "extbase".


.. _caching-developer-usage:

Cache registration and usage
""""""""""""""""""""""""""""

Registration of a new cache should be done in :file:`ext_localconf.php`. The example below just defines
an empty sub-array in *cacheConfigurations*. Neither *frontend* nor *backend* are defined,
meaning that the cache manager will choose the default :ref:`variable frontend <caching-frontend-variable>`
and the :ref:`database backend <caching-backend-db>` by default.

.. code-block:: php

   if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'])) {
       $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'] = array();
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
       $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'] = array();
   }
   if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['backend'])) {
       $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\TransientMemoryBackend';
   }

To get an instance of a cache, :code:`GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('myext_mycache')`
should be used. The cache manager will return the fully initialized cache instance::

   $myCacheInstance = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('myext_mycache');



.. _caching-developer-usage-compatibility:

How to keep extensions compatible with TYPO3 CMS 4.5 and 6.0 at the same time
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

From TYPO3 CMS 4.3 to 4.5, cache registration was a somewhat more complicated process.
If an extension must also support these versions, it should implement this other registration
process encapsulated in a proper version check. Example::

   // Register cache 'myext_mycache'
   if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'])) {
       $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'] = array();
   }
   // Define string frontend as default frontend, this must be set with TYPO3 4.5 and below
   // and overrides the default variable frontend of 4.6
   if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['frontend'])) {
       $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['frontend'] = 'TYPO3\\CMS\\Core\\Cache\\Frontend\\StringFrontend';
   }
   if (t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) < '4006000') {
       if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['backend'])) {
           $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['backend'] = 't3lib_cache_backend_DbBackend';
       }
       // Define data and tags table for 4.5 and below (obsolete in 4.6)
       if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['options'])) {
           $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['options'] = array();
       }
       if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['options']['cacheTable'])) {
           $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['options']['cacheTable'] = 'tx_myext_mycache';
       }
       if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['options']['tagsTable'])) {
           $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['options']['tagsTable'] = 'tx_myext_mycache_tags';
       }
   }


If the database backend is chosen, the extension must add the required tables in file
:file:`ext_tables.sql`. Those tables will only be used in TYPO3 4.5 and below:

.. code-block:: sql

   #
   # Table structure for table 'tx_myext_mycache'
   #
   CREATE TABLE tx_myext_mycache (
       id int(11) unsigned NOT NULL auto_increment,
       identifier varchar(250) DEFAULT '' NOT NULL,
       crdate int(11) unsigned DEFAULT '0' NOT NULL,
       content mediumblob,
       lifetime int(11) unsigned DEFAULT '0' NOT NULL,
       PRIMARY KEY (id),
       KEY cache_id (identifier)
   ) ENGINE=InnoDB;

   #
   # Table structure for table 'tx_myext_mycache_tags'
   #
   CREATE TABLE tx_myext_mycache_tags (
       id int(11) unsigned NOT NULL auto_increment,
       identifier varchar(250) DEFAULT '' NOT NULL,
       tag varchar(250) DEFAULT '' NOT NULL,
       PRIMARY KEY (id),
       KEY cache_id (identifier),
       KEY cache_tag (tag)
   ) ENGINE=InnoDB;

An extension should usually not depend on :code:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['useCachingFramework']`
being **true**. This variable is always **true** since TYPO3 CMS 4.6, but could be **false**
in older version. It should be possible to use the caching framework in an extension even if
it is not activated globally for the Core. To achieve this, an extension must not expect the
:code:`cacheManager` and :code:`cacheFactory` classes to be already instantiated and available.
Instead it should perform its own initialization. Example::

   class tx_myext_myFunctionality {
       /**
        * @var \TYPO3\CMS\Core\Cache\Frontend\AbstractFrontend
        */
       protected $cacheInstance;

       /**
        * Constructor
        */
       public function __construct() {
           $this->initializeCache();
       }

       /**
        * Initialize cache instance to be ready to use
        *
        * @return void
        */
       protected function initializeCache() {
           \TYPO3\CMS\Core\Cache\Cache::initializeCachingFramework();
           try {
               $this->cacheInstance = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('myext_mycache');
           } catch (\TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException $e) {
               $this->cacheInstance = $GLOBALS['typo3CacheFactory']->create(
                   'myext_mycache',
                   $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['frontend'],
                   $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['backend'],
                   $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['options']
               );
           }
       }
   }

Calling :code:`\TYPO3\CMS\Core\Cache\Cache::initializeCachingFramework()` ensures that the :code:`cacheManager`
and :code:`cacheFactory` instances are available in TYPO3 CMS 4.5 and below. After calling
:code:`initializeCache()`, all available frontend operations like :code:`get()`,
:code:`set()` and :code:`flushByTag()` can be executed on :code:`$this->cacheInstance`.


.. _caching-developer-access:

Cache access logic
""""""""""""""""""

Cache usage patterns are usually wrappers around the main code sections.
Here is some example code::

       protected function getCachedMagic() {
           $cacheIdentifier = $this->calculateCacheIdentifier();

           // If $entry is null, it hasn't been cached. Calculate the value and store it in the cache:
           if (($entry = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('myext_mycache')->get($cacheIdentifier)) === FALSE) {
               $entry = $this->calculateMagic();

               // [calculate lifetime and assigned tags]

               // Save value in cache
               GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('myext_mycache')->set($cacheIdentifier, $entry, $tags, $lifetime);
           }
           return $entry;
       }

.. tip::

   It isn't needed to call :code:`has()` before accessing cache entries with :code:`get()`
   as the latter returns :code:`FALSE` if no entry exists.
