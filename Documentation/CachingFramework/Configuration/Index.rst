.. include:: ../../Includes.txt



.. _caching-configuration:

Configuration
^^^^^^^^^^^^^

Caches are configured in the array :code:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']`.
The basic structure is predefined in :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`,
and consists of the single section:

- **cacheConfigurations**: Registry of all configured caches. Each cache is identified
  by its array key. Each cache can have the sub keys **frontend**, **backend**
  and **options** to configure the used frontend, backend and possible backend options.

.. _caching-configuration-cache:

Cache configurations
""""""""""""""""""""

Unfortunately in TYPO3 CMS, all :file:`ext_localconf.php` files are loaded **after** the instance specific
configuration from :file:`LocalConfiguration.php` and :file:`AdditionalConfiguration.php`. This
enables extensions to overwrite cache configuration already done for the instance. Any extension
should avoid this situation and should just define the very required minimum of cache configuration. This
boils down to define just the array key to populate a new cache to the system. Without further configuration,
the cache system fall back to default backend and default frontend settings:

.. code-block:: php

   if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'])) {
       $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache'] = array();
   }

Extensions like **extbase** define default caches this way, giving administrators full freedom for specific and
possibly quicker setups (eg. a memory driven cache for the extbase reflection cache).

Administrators can overwrite specific settings of the cache configuration in :file:`LocalConfiguration.php`,
example configuration to switch **cache_pages** to the **redis** backend using database 3:

.. code-block:: php

   return array(
      'SYS' => array(
         'caching' => array(
            'cache_pages' => array(
               'backend' => 'TYPO3\CMS\Core\Cache\Backend\RedisBackend',
               'options' => array(
                  'database' => 3,
               ),
            ),
         ),
      ),
   );


Some backends have mandatory as well as optional parameters (which are documented below).
If not all mandatory options are defined, the specific backend will throw an exception if accessed.

.. _caching-disable:

How to disable specific caches
""""""""""""""""""""""""""""""

During development, it can be convenient to disable certain caches.
This is especially helpful since TYPO3 CMS 4.6 for central caches like the language or autoloader cache.
This can be achieved by using the **null** backend (see below) as storage backend.

.. warning::

   Do not use this in production, it will strongly slow down the system!

Example entry to switch the *phpcode* cache (used for the autoloader cache) to use the **null** backend:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_phpcode']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
