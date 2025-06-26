..  include:: /Includes.rst.txt
..  index:: ! File; EXT:{extkey}/ext_tables.php
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


..  _ext-tables-php-not-use:

ext_tables.php must not be used for
===================================

The :file:`ext_tables.php` **must not be used** for the following settings:

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
*   ..  versionchanged:: 12.0
        Adding table options via :php:`ExtensionManagementUtility::allowTableOnStandardPages()`
        :ref:`Example <extension-configuration-files-allow-table-standard>`

You can use the :ref:`admin-tools-upgrade-tca-ext-tables` tool to find extensions
with :file:`ext_tables.php` files that change the TCA.

..  _ext-tables-php-usage:

ext_tables.php should be used for
=================================

These are typical functions that should be in :file:`ext_tables.php`:

*   Registering scheduler tasks:
    :ref:`extension-configuration-files-scheduler`
*   Registration of :ref:`custom page types <page-types-example>`
*   Extending :ref:`Backend user settings <user-settings-extending>`

Before you use a utility method in :file:`ext_tables.php`, refer to the method's
PHP doc comment. Unless it explicitly states that you can use the method in context
of :file:`ext_tables.php` they should not be used here.

..  _ext-tables-php-examples:

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

..  versionchanged:: 12.0
    The usage of :php:`ExtensionManagementUtility::registerModule()` is
    deprecated. In TYPO3 v12 it is not evaluated anymore. Register modules in
    :ref:`extension-configuration-backend-modules`.

If your extension needs to provide compatibility with TYPO3 v11 as well as v12
you can check which version is loaded in the :file:`ext_tables.php` and call
:php:`ExtensionUtility::registerModule` for v11 to register an Extbase backend
module:

.. code-block:: php
   :caption: EXT:my_extension/ext_tables.php

   // use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

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

..  index:: Extension development; allowTableOnStandardPages
..  _extension-configuration-files-allow-table-standard:

Allowing a tables records to be added to Standard pages
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  versionchanged:: 12.0
    The usage of :php:`ExtensionManagementUtility::allowTableOnStandardPages()` is
    deprecated. The method will be removed in TYPO3 v13.0. Use TCA ctrl option
    :ref:`ignorePageTypeRestriction <t3tca:ctrl-security-ignorePageTypeRestriction>`
    instead.

If your extension needs to provide compatibility with TYPO3 v11 as well as v12
you can check which version is loaded in the :file:`ext_tables.php` and call
:php:`allowTableOnStandardPages` for v11:

..  literalinclude:: _ext_tables_allowonstandardpages.php
    :language: php
    :caption: EXT:site_package/ext_tables.php

..  note::
    Use :ref:`ignorePageTypeRestriction <t3tca:ctrl-security-ignorePageTypeRestriction>`
    to achieve the same functionality for TYPO3 v12.
