.. include:: ../../Includes.txt


.. _extension-configuration-files:


===================
Configuration files
===================

Files :file:`ext_tables.php` and :file:`ext_localconf.php` are the two
most important files for the execution of extensions
within TYPO3. They contain configuration used by the system on almost
every request. They should therefore be optimized for speed.

ext_localconf.php
=================

:file:`ext_localconf.php` is always included in global scope of the script,
either frontend or backend.

Should not be used for
----------------------

While you *can* put functions and classes into
the script, it is a really bad practice because
such classes and functions would *always* be loaded.
It is better to have them included only as needed.

Should be used for
------------------

These are the typical functions that extension authors should place within :file:`ext_localconf.php`

* Registering hooks or any simple array assignments to :php:`$GLOBALS['TYPO3_CONF_VARS']` options
* Registering additional Request Handlers within the Bootstrap
* Adding any PageTSconfig or Default TypoScript via :php:`ExtensionManagementUtility` APIs
* Registering Extbase Command Controllers
* Registering Scheduler Tasks
* Adding reports to the reports module
* Adding slots to signals via Extbase's SignalSlotDispatcher
* Registering Icons to the IconRegistry
* Registering Services via the Service API

ext_tables.php
==============

:file:`ext_tables.php` is *not* always included in the global scope of the
frontend context.

This file is only included when
  
* a TYPO3 Backend or CLI request is happening
* or the TYPO3 Frontend is called and a valid Backend User is authenticated

This file usually gets included later within the request and after TCA information is loaded,
and a Backend User is authenticated as well.

Should be used for
------------------

These are the typical functions that should be placed inside :file:`ext_tables.php`

* Registering of Backend modules or Backend module functions
* Adding Context-Sensitive-Help docs via ExtensionManagementUtility API
* Adding TCA descriptions (via :php:`ExtensionManagementUtility::addLLrefForTCAdescr()`)
* Adding table options via :php:`ExtensionManagementUtility::allowTableOnStandardPages`
* Assignments to the global configuration arrays :php:`$TBE_STYLES` and :php:`$PAGES_TYPES`
* Adding new fields to User Settings ("Setup" Extension)

Best practices
--------------

Additionally, it is possible to extend TYPO3 in a lot of different ways (adding TCA, Backend Routes,
Symfony Console Commands etc) which do not need to touch these files.

It is heavily recommended to AVOID any checks on :php:`TYPO3_MODE` or :php:`TYPO3_REQUESTTYPE` constants
(e.g. :php:`if(TYPO3_MODE === 'BE')`) within these files as it limits the functionality to cache the
whole systems' configuration. Any extension author should remove the checks if not explicitly
necessary, and re-evaluate if these context-depending checks could go inside the hooks / caller
function directly.

Additionally, it is recommended to use the extension name (e.g. "tt_address") instead of :php:`$_EXTKEY`
within the two configuration files as this variable will be removed in the future. This also applies
to :php:`$_EXTCONF`.

However, due to limitations to TER, the :php:`$_EXTKEY` option should be kept within an extension's
:file:`ext_emconf.php`.

See any system extension for best practice on this behaviour.

- :php:`$GLOBALS['TYPO3_LOADED_EXT'][extensionKey]` contains information about
  whether the module is loaded as *local* or *system* type,
  including the proper paths you might use, absolute and relative.
- Your :file:`ext_tables.php` and :file:`ext_localconf.php` files must be designed so
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


Best practices for :php:`ext_tables.php` and :php:`ext_localconf.php`
=====================================================================

It is a good practice to use directly called closure function to encapsulate all
locally defined variables and thus keep them out of the surrounding scope. This
avoids unexpected side-effects with files of other extensions.

The following example contains the complete code::

    <?php
    defined('TYPO3_MODE') or die();

    (function () {
        // Add your code here
    })();

In most cases, the file :file:`ext_tables.php` is no longer needed, since most of
the code can be placed in :file:`Configuration\\TCA\\*.php` files.
