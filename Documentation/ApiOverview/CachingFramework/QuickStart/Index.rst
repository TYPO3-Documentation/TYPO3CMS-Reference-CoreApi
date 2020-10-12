.. include:: ../../../Includes.txt



.. _caching-quickstart:

===========================
Quick Start for Integrators
===========================

This section gives some simple instructions for getting started using
the caching framework without giving the whole details under the hood.


.. _caching-quickstart-tuning:

Change Specific Cache Options
=============================

By default, most core caches use the database backend. Default cache configuration
is defined in :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`
and can be overridden in :file:`LocalConfiguration.php`.

If specific settings should be applied to the configuration, they should be added to :file:`LocalConfiguration.php`.
All settings in :file:`LocalConfiguration.php` will be merged with :file:`DefaultConfiguration.php`. The easiest way to see
the final cache configuration is to use the TYPO3 Backend module **SYSTEM > Configuration > $GLOBALS['TYPO3_CONF_VARS']** (with installed lowlevel system extension).

Example for a configuration of redis cache backend on redis database number 42 instead of the default
database backend with compression for the pages cache:


.. code-block:: php

   return [
   // ...
      'SYS' => [
      // ...
         'caching' => [
            // ...
            'pages' => [
               'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
               'options' => [
                  'database' => 42,
               ],
            ],
         ],
      ],
   ];

.. _caching-quickstart-garbage:

Garbage Collection Task
=======================

Most cache backends do not have an internal system to remove old cache entries that exceeded their lifetime.
A cleanup must be triggered externally to find and remove those entries, otherwise caches could grow to
arbitrary size. This could lead to a slow website performance, might sum up to significant hard disk or
memory usage and could render the server system unusable.

It is advised to always enable the scheduler and run the "Caching framework garbage collection" task to retain
clean and small caches. This housekeeping could be done once a day when the system is otherwise mostly idle.
