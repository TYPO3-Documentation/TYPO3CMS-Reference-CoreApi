.. include:: /Includes.rst.txt
.. index:: ! File; EXT:{extkey}/ext_tables.php
.. _ext-tables-php:

=======================================
:file:`ext_tables.php`
=======================================

*-- optional*

:file:`ext_tables.php` is *not* always included in the global scope of the
frontend context.

This file is only included when

*  a TYPO3 Backend or CLI request is happening
*  or the TYPO3 Frontend is called and a valid backend user is authenticated

This file usually gets included later within the request and after TCA
information is loaded, and a backend user is authenticated.

.. hint::

   In many cases, the file :file:`ext_tables.php` is no longer needed,
   since `TCA` definitions must be placed in files located at
   :ref:`Configuration/TCA/ <extension-configuration-tca>`.


Should not be used for
======================

*  TCA configurations for new tables.
   They should go in :ref:`Configuration/TCA/sometable.php <extension-configuration-tca>`.
*  TCA overrides of existing tables. They should go in
   :ref:`Configuration/TCA/Overrides/somefile.php <extension-configuration-tca-overrides>`.
*  calling :php:`ExtensionManagementUtility::addToInsertRecords()`
   as this might break the frontend. They should go in
   :ref:`Configuration/TCA/Overrides/somefile.php <extension-configuration-tca-overrides>`.
*  calling :php:`ExtensionManagementUtility::addStaticFile()`
   as this might break the frontend. They should go in
   :file:`Configuration/TCA/Overrides/sys_template.php`
*  .. versionchanged:: 12.0
   Adding table options via :php:`ExtensionManagementUtility::allowTableOnStandardPages()`
   :ref:`Example <extension-configuration-files-allow-table-standard>`


Should be used for
==================

These are the typical functions that should be placed inside :file:`ext_tables.php`

*  Registering of :ref:`backend modules <backend-modules-api>` or adding a new
   main module :ref:`Example <extension-configuration-files-backend-module>`
*  Registering a scheduler tasks:
   :ref:`extension-configuration-files-scheduler`
*  Assignments to the global configuration arrays :php:`$GLOBALS['TBE_STYLES']`
   and :php:`$GLOBALS['PAGES_TYPES']`
*  Extending the :ref:`Backend user settings <user-settings-extending>`

Examples
========

Put the following in a file called :file:`ext_tables.php` in the main directory
of your extension. The file does not need to be registered but will be loaded
automatically:

.. code-block:: php
   :caption: EXT:site_package/ext_tables.php

   <?php
   // all use statements must come first
   use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

   defined('TYPO3') or die();

   (function () {
     // Add your code here
   })();

.. index:: Extension development; Backend module registration
.. _extension-configuration-files-backend-module:

Registering a backend module
~~~~~~~~~~~~~~~~~~~~~~~~~~~~
You can register a new backend module for your extension via :php:`ExtensionUtility::registerModule()`:

.. code-block:: php
   :caption: EXT:my_extension/ext_tables.php

   // use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

   ExtensionUtility::registerModule(
      'ExtensionName', // Extension Name in CamelCase
      'web', // the main module
      'mysubmodulekey', // Submodule key
      'bottom', // Position
      [
          'MyController' => 'list,show,new',
      ],
      [
          'access' => 'user,group',
          'icon'   => 'EXT:my_extension/ext_icon.svg',
          'labels' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang_statistics.xlf',
      ]
   );

For more information on backend modules see :ref:`backend module API <backend-modules-api>`.

.. index:: Extension development; allowTableOnStandardPages
.. _extension-configuration-files-allow-table-standard:

Allowing a tables records to be added to Standard pages
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  versionchanged:: 12.0
    The usage of :php:`ExtensionManagementUtility::allowTableOnStandardPages()` is
    deprecated. The method will be removed in TYPO3 v13.0. Use TCA ctrl option
    :ref:`ignorePageTypeRestriction <t3tca:ctrl-security-ignorePageTypeRestriction>`
    instead.

By default new records of tables may only be added to Sysfolders in TYPO3. If you need to allow
new records of your table to be added on Standard pages call:

.. code-block:: php
   :caption: EXT:site_package/ext_tables.php

   // use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

   ExtensionManagementUtility::allowTableOnStandardPages(
      'tx_myextension_domain_model_mymodel'
   );

.. index:: Extension development; Scheduler task registration
.. _extension-configuration-files-scheduler:

Registering a scheduler task
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Scheduler tasks get registered in the ext_tables.php as well. Note that the Sysext "scheduler" has
to be installed for this to work.

.. code-block:: php
   :caption: EXT:site_package/ext_tables.php

   // use TYPO3\CMS\Scheduler\Task\CachingFrameworkGarbageCollectionTask;
   // use TYPO3\CMS\Scheduler\Task\CachingFrameworkGarbageCollectionAdditionalFieldProvider;

   // Add caching framework garbage collection task
   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][CachingFrameworkGarbageCollectionTask::class] = array(
        'extension' => 'your_extension_key',
        'title' => 'LLL:EXT:your_extension_key/locallang.xlf:cachingFrameworkGarbageCollection.name',
        'description' => 'LLL:EXT:your_extension_key/locallang.xlf:cachingFrameworkGarbageCollection.description',
        'additionalFields' => \CachingFrameworkGarbageCollectionAdditionalFieldProvider::class
   );

For more information see the documentation of the Sys-Extension scheduler.
