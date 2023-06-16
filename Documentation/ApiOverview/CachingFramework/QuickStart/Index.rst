..  include:: /Includes.rst.txt

..  _caching-quickstart:

===========================
Quick start for integrators
===========================

This section gives some simple instructions for getting started using
the caching framework without going into all the details under the hood.


..  _caching-quickstart-tuning:

Change specific cache options
=============================

By default, most Core caches use the :ref:`database backend <caching-backend-db>`.
The default cache configuration is defined in
:t3src:`core/Configuration/DefaultConfiguration.php` and can be overridden in
:file:`config/system/settings.php`.

If specific settings should be applied to the configuration, they should be
added to :file:`config/system/settings.php`. All settings in
:file:`config/system/settings.php` will be merged with
:file:`DefaultConfiguration.php`. The easiest way to see the final cache
configuration is to use the TYPO3 backend module
:guilabel:`System > Configuration > $GLOBALS['TYPO3_CONF_VARS']`
(with installed lowlevel system extension).

Example for a configuration of a
:ref:`Redis cache backend <caching-backend-redis>` on Redis database number 42
instead of the default database backend with compression for the pages cache:

..  code-block:: php
    :caption: config/system/settings.php

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

..  _caching-quickstart-garbage:

Garbage collection task
=======================

Most cache backends do not have an internal system to remove old cache entries
that exceeded their lifetime. A cleanup must be triggered externally to find and
remove those entries, otherwise caches could grow to arbitrary size. This could
lead to a slow website performance, might sum up to significant hard disk or
memory usage and could render the server system unusable.

It is advised to always enable the :doc:`scheduler <ext_scheduler:Index>` and
run the "Caching framework garbage collection" task to retain clean and small
caches. This housekeeping could be done once a day when the system is otherwise
mostly idle.
