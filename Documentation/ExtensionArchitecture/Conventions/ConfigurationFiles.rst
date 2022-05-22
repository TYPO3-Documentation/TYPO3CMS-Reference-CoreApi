.. include:: /Includes.rst.txt
.. highlight:: php
.. index:: Extension development; Configuration Files
.. _extension-conventions-configuration-files:

========================================================
Configuration Files (ext_tables.php & ext_localconf.php)
========================================================

The files :file:`ext_tables.php` and :file:`ext_localconf.php`
contain configuration used by the system and many
requests. They should therefore be optimized for speed.

See :ref:`extension-files-locations` for a full list of file and
directory names typically used in extensions.

.. versionchanged:: 10.0
   These variables are no longer declared in :file:`ext_tables.php`
   and :file:`ext_localconf.php` files: :php:`$_EXTKEY`, :php:`$_EXTCONF`,
   :php:`T3_SERVICES`, :php:`T3_VAR`, :php:`TYPO3_CONF_VARS`,
   :php:`TBE_MODULES`, :php:`TBE_MODULES_EXT`, :php:`TCA`,
   :php:`PAGES_TYPES`, :php:`TBE_STYLES`

.. versionchanged:: 11.4
   With 11.4 the files :file:`ext_localconf.php` and :file:`ext_tables.php`
   are scoped into the global namespace on being warmed up from the cache.
   Therefore :php:`use` statements can now be used inside these files.

.. warning::

   The content of the files :file:`ext_localconf.php` and
   :file:`ext_tables.php` **must not** be wrapped in a
   local namespace by extension authors. This would lead to nested namespaces
   causing PHP errors only solvable by clearing the caches via the
   Install Tool.

.. _rules_ext_tables_localconf_php:

Rules and best practices
========================

The following apply for both :php:`ext_tables.php` and :php:`ext_localconf.php`.

As a rule of thumb: Your :file:`ext_tables.php` and :file:`ext_localconf.php`
files must be designed in a way
that they can safely be read and subsequently imploded into one single
file with all configuration of other extensions.

-  You **MUST NOT** use a :php:`return` statement in the files global scope -
   that would make the cached script concept break.

-  You **MUST NOT** rely on the PHP constant :php:`__FILE__` for detection of
   include path of the script - the configuration might be executed from
   a cached file with a different location and therefore such information should be derived from
   e.g. :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName()` or
   :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath()`.

-  You **MUST NOT** wrap the file in a local namespace. This will result in
   nested namespaces.

   .. code-block:: diff

      -namespace {
      -}

-  You **CAN** use :php:`use` statements starting with TYPO3 11.4:

   .. code-block:: diff

      // you can use use:
      +use TYPO3\CMS\Core\Resource\Security\FileMetadataPermissionsAspect;
      +
      +$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
      +   FileMetadataPermissionsAspect::class;
       // Instead of the full class name:
      -$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
      -   \TYPO3\CMS\Core\Resource\Security\FileMetadataPermissionsAspect::class;

-  You **CAN** use :php:`declare(strict_types=1)` and similar directives which
   must be placed at the very top of files. They will be stripped and added
   once in the concatenated cache file.

.. code-block:: diff

   // You can use declare strict and other directives which must be placed at the top of the file
   +declare(strict_types=1)


-  You **MUST NOT** check for values of the removed :php:`TYPO3_MODE` or :php:`TYPO3_REQUESTTYPE`
   constants (e.g. :php:`if (TYPO3_MODE === 'BE')`) or the :php:`ApplicationType` within these files as
   it limits the functionality to cache the whole systems' configuration.
   Any extension author should remove the checks, and re-evaluate if these context-depending checks could go inside
   the hooks / caller function directly., e.g. do not do:

.. code-block:: diff

   // do NOT do this:
   -if (TYPO3_MODE === 'BE')


-  You **SHOULD** check for the existence of the constant :php:`defined('TYPO3') or die();`
   at the top of :file:`ext_tables.php` and :file:`ext_localconf.php` files
   right after the use statements to make sure the file is
   executed only indirectly within TYPO3 context. This is a security measure since this code in global
   scope should not be executed through the web server directly as entry point.

   .. code-block:: php
      :caption: EXT:site_package/ext_localconf.php

      <?php
      use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
      // put this at top of every ext_tables.php and ext_localconf.php right after
      // the use statements
      defined('TYPO3') or die();

-  You **MUST** use the extension name (e.g. "tt_address") instead of :php:`$_EXTKEY`
   within the two configuration files as this variable is no longer loaded automatically.

-  However, due to limitations to TER, the :php:`$_EXTKEY` option **MUST** be kept within an extension's
   :ref:`ext_emconf.php <extension-declaration>`.

-  You **SHOULD** use a directly called closure function to encapsulate all
   locally defined variables and thus keep them out of the surrounding scope. This
   avoids unexpected side-effects with files of other extensions.

The following example contains the complete code:

.. code-block:: php
   :caption: EXT:site_package/ext_localconf.php

    <?php
    use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
    defined('TYPO3') or die();

    (function () {
        // Add your code here
    })();


Additionally, it is possible to extend TYPO3 in a lot of different ways (adding TCA, Backend Routes,
Symfony Console Commands etc) which do not need to touch these files.

Additional tips:

-  :php:`TYPO3\CMS\Core\Package\PackageManager::getActivePackages()` contains information about
   whether the module is loaded as *local* or *system* type in the `packagePath` key,
   including the proper paths you might use, absolute and relative.
