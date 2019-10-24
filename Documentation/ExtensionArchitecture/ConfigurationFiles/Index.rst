.. include:: ../../Includes.txt


.. _extension-configuration-files:


========================================================
Configuration Files (ext_tables.php & ext_localconf.php)
========================================================

Files :file:`ext_tables.php` and :file:`ext_localconf.php` are the two
most important files for the execution of extensions
within TYPO3. They contain configuration used by the system on almost
every request. They should therefore be optimized for speed.


.. _ext-localconf-php:

ext_localconf.php
=================

:file:`ext_localconf.php` is always included in global scope of the script,
either frontend or backend.

Should Not Be Used For
----------------------

* While you *can* put functions and classes into the script, it is a really bad
  practice because such classes and functions would *always* be loaded. It is
  better to have them included only as needed.
* Registering :ref:`hooks or signals <hooks-concept>`, :ref:`XCLASSes
  <xclasses>` or any simple array assignments to
  :php:`$GLOBALS['TYPO3_CONF_VARS']` options will not work for the following:

 * class loader
 * package manager
 * cache manager
 * configuration manager
 * log manager
 * time zone
 * memory limit
 * locales
 * stream wrapper
 * error handler

 This would not work because the extension files :file:`ext_localconf.php` are
 included (:php:`loadTypo3LoadedExtAndExtLocalconf`) after the creation of the
 mentioned objects in the Bootstrap class.

Should Be Used For
------------------

These are the typical functions that extension authors should place within :file:`ext_localconf.php`

* Registering :ref:`hooks or signals <hooks-concept>`, :ref:`XCLASSes <xclasses>` or any simple array assignments to :php:`$GLOBALS['TYPO3_CONF_VARS']` options
* Registering additional Request Handlers within the :ref:`Bootstrap <bootstrapping>`
* Adding any PageTSconfig or Default TypoScript via :php:`ExtensionManagementUtility` APIs
* Registering Scheduler Tasks
* Adding reports to the reports module
* Adding slots to signals via Extbase's SignalSlotDispatcher
* Registering Icons to the :ref:`IconRegistry <icon-registration>`
* Registering Services via the :ref:`Service API <services-developer-service-api>`

deprecated

* *Registering Extbase Command Controllers* (Extbase command controllers are deprecated since
  TYPO3 9. Use symfony commands as explained in :ref:`cli-mode`)


.. _ext-tables.php:

ext_tables.php
==============

:file:`ext_tables.php` is *not* always included in the global scope of the
frontend context.

This file is only included when
  
* a TYPO3 Backend or CLI request is happening
* or the TYPO3 Frontend is called and a valid Backend User is authenticated

This file usually gets included later within the request and after TCA information is loaded,
and a Backend User is authenticated as well.

.. hint::

   In many cases, the file :file:`ext_tables.php` is no longer needed, since `TCA` definitions
   must be placed in :file:`Configuration/TCA/*.php` files nowadays.


Should Not Be Used For
----------------------

* TCA configurations for new tables. They should go in :file:`Configuration/TCA/tablename.php`
* TCA overrides of existing tables. They should go in :file:`Configuration/TCA/Overrides/tablename.php`
* calling :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords()`
  as this might break the frontend. They should go in :file:`Configuration/TCA/Overrides/tablename.php`
* calling :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile()`
  as this might break the frontend. They should go in :file:`Configuration/TCA/Overrides/sys_template.php`

For a descriptions of the changes for TCA (compared to older TYPO3 versions), please see
the blogpost `"Cleaning the hood: TCA" by Andreas Fernandez <https://scripting-base.de/blog/cleaning-the-hood-tca.html>`__

More information can be found in the blogpost `"Good practices in extensions
<https://usetypo3.com/good-practices-in-extensions.html>`__ (use TYPO3 blog).

.. hint::

   ext_tables.php is not cached. The files in Configuration/TCA are cached.

Should Be Used For
------------------

These are the typical functions that should be placed inside :file:`ext_tables.php`

* Registering of Backend modules or Backend module functions
* Adding Context-Sensitive-Help docs via ExtensionManagementUtility API
* Adding TCA descriptions (via :php:`ExtensionManagementUtility::addLLrefForTCAdescr()`)
* Adding table options via :php:`ExtensionManagementUtility::allowTableOnStandardPages`
* Assignments to the global configuration arrays :php:`$TBE_STYLES` and :php:`$PAGES_TYPES`
* Adding new fields to User Settings ("Setup" Extension)

Best Practices for :php:`ext_tables.php` and :php:`ext_localconf.php`
=====================================================================

Additionally, it is possible to extend TYPO3 in a lot of different ways (adding TCA, Backend Routes,
Symfony Console Commands etc) which do not need to touch these files.

It is recommended to AVOID checks for values on :php:`TYPO3_MODE` or :php:`TYPO3_REQUESTTYPE`
constants (e.g. :php:`if (TYPO3_MODE === 'BE')`) within these files as it limits the functionality
to cache the whole systems' configuration. Any extension author should remove the checks if not
explicitly necessary, and re-evaluate if these context-depending checks could go inside
the hooks / caller function directly.

It is recommended to check for the existence of the constants :php:`defined('TYPO3_MODE') or die();`
at the top of :file:`ext_tables.php` and :file:`ext_localconf.php` files to make sure the file is
executed only indirectly within TYPO3 context. This is a security measure since this code in global
scope should not be executed through the web server directly as entry point.

Additionally, it is recommended to use the extension name (e.g. "tt_address") instead of :php:`$_EXTKEY`
within the two configuration files as this variable will be removed in the future. This also applies
to :php:`$_EXTCONF`.

However, due to limitations to TER, the :php:`$_EXTKEY` option should be kept within an extension's
:file:`ext_emconf.php`.

See any system extension for best practice on this behaviour.

- :php:`TYPO3\CMS\Core\Package\PackageManager::getActivePackages()` contains information about
  whether the module is loaded as *local* or *system* type in the `packagePath` key,
  including the proper paths you might use, absolute and relative.
- Your :file:`ext_tables.php` and :file:`ext_localconf.php` files must be designed in a way
  that they can safely be read and subsequently imploded into one single
  file with all the other configuration scripts!
- You must **never** use a "return" statement in the files global scope -
  that would make the cached script concept break.
- You must **never** use a "use" statement in the files global scope -
  that would make the cached script concept break and could conflict with other extensions.
- You should **not** rely on the PHP constant :php:`__FILE__` for detection of
  include path of the script - the configuration might be executed from
  a cached script and therefore such information should be derived from
  e.g. :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName()` or
  :php:`ExtensionManagementUtility::extPath()`.

It is a good practice to use a directly called closure function to encapsulate all
locally defined variables and thus keep them out of the surrounding scope. This
avoids unexpected side-effects with files of other extensions.

The following example contains the complete code::

    <?php
    defined('TYPO3_MODE') or die();

    (function () {
        // Add your code here
    })();

