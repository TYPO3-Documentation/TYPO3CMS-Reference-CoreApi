..  include:: /Includes.rst.txt
..  index:: ! File; EXT:{extkey}/ext_tables.php
..  _database-exttables-sql:
..  _ext-tables-php:

================
`ext_tables.php`
================

..  typo3:file:: ext_tables.php
    :scope: extension
    :regex: /^.*ext\_tables\.php$/
    :shortDescription: This file is loaded in TYPO3 backend or CLI request only.

    :file:`ext_tables.php` is *not* always included in the global scope of the
    frontend context.

    This file is only included when

    *   a TYPO3 Backend or CLI request is happening
    *   or the TYPO3 Frontend is called and a valid backend user is authenticated

    This file usually gets included later within the request and after TCA
    information is loaded, and a backend user is authenticated.

    ..  hint::

        In many cases, the file :file:`ext_tables.php` is no longer needed,
        since `TCA` definitions must be placed in files located at
        :ref:`Configuration/TCA/ <extension-configuration-tca>`.


Should not be used for
======================

*   TCA configurations for new tables.
    They should go in :ref:`Configuration/TCA/sometable.php <extension-configuration-tca>`.
*   TCA overrides of existing tables. They should go in
    :ref:`Configuration/TCA/Overrides/somefile.php <extension-configuration-tca-overrides>`.
*   calling :php:`ExtensionManagementUtility::addToInsertRecords()`
    as this might break the frontend. They should go in
    :ref:`Configuration/TCA/Overrides/somefile.php <extension-configuration-tca-overrides>`.
*   calling :php:`ExtensionManagementUtility::addStaticFile()`
    as this might break the frontend. They should go in
    :file:`Configuration/TCA/Overrides/sys_template.php`

Should be used for
==================

These are the typical functions that should be placed inside :file:`ext_tables.php`

*  Registering a scheduler tasks:
   :ref:`extension-configuration-files-scheduler`
*  Registration of :ref:`custom page types <page-types-example>`
*  Extending the :ref:`Backend user settings <user-settings-extending>`

Examples
========

Put the following in a file called :file:`ext_tables.php` in the main directory
of your extension. The file does not need to be registered but will be loaded
automatically:

..  literalinclude:: _ext_tables.php
    :language: php
    :caption: EXT:site_package/ext_tables.php

Read :ref:`why the check for the TYPO3 constant is necessary <globals-constants-typo3>`.

..  index:: Extension development; Scheduler task registration
..  _extension-configuration-files-scheduler:

Registering a scheduler task
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Scheduler tasks get registered in :file:`ext_tables.php` as well. Note that the system extension "scheduler" has
to be installed for this to work.


..  literalinclude:: _ext_tables_scheduler.php
    :language: php
    :caption: EXT:site_package/ext_tables.php

..  index:: Extension development; Backend module registration
..  _extension-configuration-files-backend-module:

Registering a backend module
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  versionchanged:: 13.0
    The method
    :php:`\use TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule()`
    has been removed. Register modules in
    :ref:`extension-configuration-backend-modules`.


..  index:: Extension development; allowTableOnStandardPages
..  _extension-configuration-files-allow-table-standard:

Allowing a tables records to be added to Standard pages
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  versionchanged:: 13.0
    The method :php:`ExtensionManagementUtility::allowTableOnStandardPages()`
    has been removed. Use the TCA ctrl option
    :ref:`ignorePageTypeRestriction <t3tca:ctrl-security-ignorePageTypeRestriction>`
    instead.
