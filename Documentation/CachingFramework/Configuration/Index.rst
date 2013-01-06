.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt



.. _caching-configuration:

Configuration
^^^^^^^^^^^^^

Caches are configured in the array :code:`$TYPO3_CONF_VARS['SYS']['caching']`.
The basic structure is predefined in :file:`t3lib/config_default.php`
(:file:`t3lib/stddb/DefaultConfiguration.php`, since TYPO3 CMS 6.0)
and consists of the single section:

- **cacheConfigurations***: Registry of all configured caches, used frontends,
  backends and backend options.

In TYPO3 4.5 and below two other sub arrays exist to register available frontends and backends
(since TYPO3 4.6 the autoloader is used and rendered this registry obsolete):

- **cacheFrontends**: Registry of all available frontends (Removed, obsolete since 4.6)
- **cacheBackends**: Registry of all available backends (Removed, obsolete since 4.6)


.. _caching-configuration-cache:

Cache configurations
""""""""""""""""""""

Some backends have mandatory as well as optional parameters (which are documented below).
If not all mandatory options are defined, the backend will throw an exception on the first access.

In TYPO3 CMS 4.5 and below the settings **backend** and **frontend** are mandatory,
since TYPO3 CMS 4.6 a fallback to the *VariableFrontend* and *DbBackend* is implemented.

Example configuration to switch the *pages* cache to the **redis** backend:

.. code-block:: php

   $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_pages']['backend'] = 't3lib_cache_backend_RedisBackend';
   $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_pages']['options'] = array(
       'database' => 3,
  );


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

   $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_phpcode']['backend'] = 't3lib_cache_backend_NullBackend';
