.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt



.. _caching-quickstart:

Quick start for Integrators
^^^^^^^^^^^^^^^^^^^^^^^^^^^

This section gives come simple instructions for getting started with using
the caching framework without giving the whole details under the hood.


.. _caching-quickstart-enable:

Enabling in TYPO3 CMS 4.5 and below
"""""""""""""""""""""""""""""""""""

To enable the caching framework for core caches, the Install Tool option
:code:`useCachingFramework` must be enabled. This translates to the :file:`localconf.php`
setting :code:`$TYPO3_CONF_VARS['SYS']['useCachingFramework'] = true`.
All caches should be cleared before to make sure that the cache tables do not contain old and unused data.
This setting is obsolete since TYPO3 CMS 4.6; it triggers a deprecation warning and should be removed when upgrading.

In TYPO3 CMS 4.5 and below, the default database backend requires a manual table setup
that can be achieved via the Install Tool.


.. _caching-quickstart-tuning:

Change specific cache options
"""""""""""""""""""""""""""""

By default, most core caches use the database backend. Default cache configurations
are defined in :file:`t3lib/config_default.php` (:file:`t3lib/stddb/DefaultConfiguration.php`,
since TYPO3 CMS 6.0) and can be overridden in :file:`localconf.php`
(:file:`AdditionalConfiguration.php`, since TYPO3 CMS 6.0).

If, for example, the pages cache grows very large, data compression for the pages cache
with the database backend can be enabled in :file:`localconf.php` (:file:`AdditionalConfiguration.php`):


.. code-block:: php

   if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_pages']['options'])) {
       $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_pages']['options'] = array();
   }
   $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_pages']['options']['compression'] = true;

.. warning::
   Cache configurations in :file:`localconf.php` should **not** overwrite the whole configuration array,
   see below for details. The proper code to use is as above. **Never** write somewthing like::

      $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'] = array(...);


.. _caching-quickstart-garbage:

Garbage collection task
"""""""""""""""""""""""

The Scheduler provides a garbage collection task, which should be activated,
especially if using the database backend. This helps to keep caches clean and small.
