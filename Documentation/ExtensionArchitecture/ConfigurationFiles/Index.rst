.. include:: /Includes.rst.txt

.. highlight:: php


.. _extension-configuration-files:


========================================================
Configuration Files (ext_tables.php & ext_localconf.php)
========================================================

Files :file:`ext_tables.php` and :file:`ext_localconf.php` are the two
most important files for the execution of extensions
within TYPO3. They contain configuration used by the system on almost
every request. They should therefore be optimized for speed.

See :ref:`extension-files-locations` for a full list of file and
directory names typically used in extensions.

.. important::

   Since the :file:`ext_tables.php` and :file:`ext_localconf.php` of
   every extension will be concatenated together by TYPO3, you MUST
   follow some rules, such as not use :php:`use` or :php:`declare(strict_types=1)`
   inside these files, see :ref:`rules_ext_tables_localconf_php`.

.. _ext-localconf-php:

ext_localconf.php
=================

*-- optional*

:file:`ext_localconf.php` is always included in global scope of the script,
either frontend or backend.



Should Not Be Used For
----------------------

While you *can* put functions and classes into :file:`ext_localconf.php`, it is a really bad
practice because such classes and functions would *always* be loaded. It is
better to have them included only as needed.

Registering :ref:`hooks or signals <hooks-concept>`, :ref:`XCLASSes
<xclasses>` or any simple array assignments to
:php:`$GLOBALS['TYPO3_CONF_VARS']` options will not work for the following:

* class loader
* package manager
* cache manager
* configuration manager
* log manager (= :ref:`Logging Framework <logging>`)
* time zone
* memory limit
* locales
* stream wrapper
* :ref:`error handler <error-handling-extending>`

This would not work because the extension files :file:`ext_localconf.php` are
included (:php:`loadTypo3LoadedExtAndExtLocalconf`) after the creation of the
mentioned objects in the :ref:`Bootstrap <bootstrapping>` class.

In most cases, these assignments should be placed in :file:`typo3conf/AdditionalConfiguration.php`.

Example:

:ref:`Register an exception handler <error-handling-extending>` in :file:`typo3conf/AdditionalConfiguration.php`::

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] = \Vendor\Ext\Error\PostExceptionsOnTwitter::class;

Should Be Used For
------------------

These are the typical functions that extension authors should place within :file:`ext_localconf.php`

* Registering :ref:`hooks or signals <hooks-concept>`, :ref:`XCLASSes <xclasses>`
  or any simple array assignments to :php:`$GLOBALS['TYPO3_CONF_VARS']` options
* Registering additional Request Handlers within the :ref:`Bootstrap <bootstrapping>`
* Adding any :ref:`PageTSconfig <t3tsconfig:pagesettingdefaultpagetsconfig>`
* Adding default TypoScript via :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility` APIs
* Registering Scheduler Tasks
* Adding reports to the reports module
* Registering Icons to the :ref:`IconRegistry <icon-registration>`
* Registering Services via the :ref:`Service API <services-developer-service-api>`

deprecated

* *Registering Extbase Command Controllers* (Extbase command controllers are deprecated since
  TYPO3 9. Use symfony commands as explained in :ref:`cli-mode`)

Examples
--------

Put a file called :file:`ext_localconf.php` in the main directory of your
Extension. It does not need to be registered anywhere but will be loaded
automatically as soon as the extension is installed.
The skeletton of the :file:`ext_localconf.php` looks like this::

   <?php

   // Prevent Script from beeing called directly
   defined('TYPO3_MODE') || die();

   // encapsulate all locally defined variables
   (function () {
       // Add your code here
   })();

Adding default PageTSconfig
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Default PageTSconfig can be added inside :file:`ext_localconf.php`, see
:ref:`t3tsconfig:pagesettingdefaultpagetsconfig`::

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig();

PageTSconfig available via static files can be added inside
:file:`Configuration/TCA/Overrides/pages.php`, see
:ref:`t3tsconfig:pagesettingstaticpagetsconfigfiles`::

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile();


Adding default UserTSconfig
~~~~~~~~~~~~~~~~~~~~~~~~~~~

As for default PageTSconfig, UserTSconfig can be added inside
:file:`ext_localconf.php`, see:
:ref:`t3tsconfig:usersettingdefaultusertsconfig`::

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig();

.. _ext-tables.php:

ext_tables.php
==============

*-- optional*

:file:`ext_tables.php` is *not* always included in the global scope of the
frontend context.

This file is only included when

* a TYPO3 Backend or CLI request is happening
* or the TYPO3 Frontend is called and a valid Backend User is authenticated

This file usually gets included later within the request and after TCA information is loaded,
and a Backend User is authenticated as well.

.. hint::

   In many cases, the file :file:`ext_tables.php` is no longer needed, since `TCA` definitions
   must be placed in :file:`Configuration/TCA/\*.php` files.


Should Not Be Used For
----------------------

* TCA configurations for new tables. They should go in :file:`Configuration/TCA/tablename.php`
* TCA overrides of existing tables. They should go in :file:`Configuration/TCA/Overrides/tablename.php`
* calling :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords()`
  as this might break the frontend. They should go in :file:`Configuration/TCA/Overrides/tablename.php`
* calling :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile()`
  as this might break the frontend. They should go in :file:`Configuration/TCA/Overrides/sys_template.php`

For a descriptions of the changes for TCA (compared to older TYPO3 versions), please see
the blogpost `"Cleaning the hood: TCA" by Andreas Fernandez <https://scripting-base.de/blog/cleaning-the-hood-tca.html>`__.

More information can be found in the blogpost `Good practices in extensions
<https://usetypo3.com/good-practices-in-extensions.html>`__ (use TYPO3 blog).

.. hint::

   :file:`ext_tables.php` is cached.

Should Be Used For
------------------

These are the typical functions that should be placed inside :file:`ext_tables.php`

* Registering of :ref:`Backend modules <backend-modules-api>` or Adding a new Main Module :ref: 'Example <extension-configuration-files-backend-module>'
* Adding :ref:`Context-Sensitive-Help <csh-implementation>` to fields (via :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr()`) :ref:`Example <extension-configuration-files-csh>`
* Adding TCA descriptions (via :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr()`)
* Adding table options via :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages()` :ref:`Example <extension-configuration-files-allow-table-standard>`
* Registering a scheduler tasks `Scheduler Task <https://docs.typo3.org/c/typo3/cms-scheduler/master/en-us/DevelopersGuide/CreatingTasks/Index.html>`__ :ref:`Example <extension-configuration-files-scheduler>`
* Assignments to the global configuration arrays :php:`$GLOBALS['TBE_STYLES']` and :php:`$GLOBALS['PAGES_TYPES']`
* Extending the :ref:`Backend User Settings <user-settings-extending>`

Examples
--------
Put the following in a file called :file:`ext_tables.php` in the main directory of your extension. The
file does not need to be registered but will be loaded automatically::

   <?php
   defined('TYPO3_MODE') || die();

   (function () {
     // Add your code here
   })();

.. _extension-configuration-files-backend-module:

Registering a Backend Module
~~~~~~~~~~~~~~~~~~~~~~~~~~~~
You can register a new Backend Module for your extension via :php:`ExtensionUtility::registerModule()`::

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
      'Vendor.ExtensionName', // Vendor dot Extension Name in CamelCase
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

For more information on Backend Modules see :ref:`Backend Module API <backend-modules-api>`.

.. _extension-configuration-files-csh:

Adding Context Sensitive Help to fields
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Add the following to your extensions ext_tables.php in order to add Context Sensitive Help for
the corresponding field::

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
       'tx_domain_model_foo',
       'EXT:myext/Resources/Private/Language/locallang_csh_tx_domain_model_foo.xlf'
   );

For more information see :ref:`Context-Sensitive-Help <csh-implementation>`.

.. _extension-configuration-files-allow-table-standard:

Allowing a tables records to be added to Standard pages
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
By default new records of tables may only be added to Sysfolders in TYPO3. If you need to allow
new records of your table to be added on Standard pages call:

.. code-block:: php

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
      'tx_myextension_domain_model_mymodel'
   );

.. _extension-configuration-files-scheduler:

Registering a scheduler Task
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Scheduler tasks get registered in the ext_tables.php as well. Note that the Sysext "scheduler" has
to be installed for this to work.

.. code-block:: php

   // Add caching framework garbage collection task
   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\TYPO3\CMS\Scheduler\Task\CachingFrameworkGarbageCollectionTask::class] = array(
        'extension' => 'your_extension_key',
        'title' => 'LLL:EXT:your_extension_key/locallang.xlf:cachingFrameworkGarbageCollection.name',
        'description' => 'LLL:EXT:your_extension_key/locallang.xlf:cachingFrameworkGarbageCollection.description',
        'additionalFields' => \TYPO3\CMS\Scheduler\Task\CachingFrameworkGarbageCollectionAdditionalFieldProvider::class
   );

For more information see the documentation of the Sys-Extension scheduler.


.. _rules_ext_tables_localconf_php:

Rules and best practices
========================

The following apply for both :php:`ext_tables.php` and :php:`ext_localconf.php`.

.. important::

   Since the :file:`ext_tables.php` and :file:`ext_localconf.php` of
   every extension will be concatenated together by TYPO3, you MUST
   follow some rules, such as not use :php:`use` or :php:`declare(strict_types=1)`
   inside these files. More information below:

As a rule of thumb: Your :file:`ext_tables.php` and :file:`ext_localconf.php` files must be designed in a way
that they can safely be read and subsequently imploded into one single
file with all configuration of other extensions!

-  You **MUST NOT** use a :php:`return` statement in the files global scope -
   that would make the cached script concept break.

-  You **MUST NOT** rely on the PHP constant :php:`__FILE__` for detection of
   include path of the script - the configuration might be executed from
   a cached file with a different location and therefore such information should be derived from
   e.g. :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName()` or
   :php:`ExtensionManagementUtility::extPath()`.


-  You **MUST NOT** use :php:`use` inside :file:`ext_localconf.php` or :file:`ext_tables.php` since this can lead to conflicts with other :php:`use` in files of other extensions.

.. code-block:: diff

   // do NOT use use:
   -use TYPO3\CMS\Core\Resource\Security\FileMetadataPermissionsAspect;
   -
   -$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = FileMetadataPermissionsAspect::class;
   +$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = \TYPO3\CMS\Core\Resource\Security\FileMetadataPermissionsAspect::class;

- You **MUST NOT** use :php:`declare(strict_types=1)` and similar directives which must be placed
  at the very top of files: once all files of all extensions are merged, this condition is not
  fulfilled anymore leading to errors. So these must **never** be used here.

.. code-block:: diff

   // do NOT use declare strict and other directives which MUST be placed at the top of the file
   -declare(strict_types=1)


-  You **MUST NOT** check for values of :php:`TYPO3_MODE` or :php:`TYPO3_REQUESTTYPE`
   constants (e.g. :php:`if (TYPO3_MODE === 'BE')`) within these files as it limits the functionality
   to cache the whole systems' configuration. Any extension author should remove the checks if not
   explicitly necessary, and re-evaluate if these context-depending checks could go inside
   the hooks / caller function directly., e.g. do not do::

.. code-block:: diff

   // do NOT do this:
   -if (TYPO3_MODE === 'BE')

-  You **SHOULD** check for the existence of the constants :php:`defined('TYPO3_MODE') or die();`
   at the top of :file:`ext_tables.php` and :file:`ext_localconf.php` files to make sure the file is
   executed only indirectly within TYPO3 context. This is a security measure since this code in global
   scope should not be executed through the web server directly as entry point.

.. code-block:: php

   <?php
   // put this at top of every ext_tables.php and ext_localconf.php
   defined('TYPO3') or die();

-  You **SHOULD** use the extension name (e.g. "tt_address") instead of :php:`$_EXTKEY`
   within the two configuration files as this variable will be removed in the future. This also applies
   to :php:`$_EXTCONF`.

-  However, due to limitations to TER, the :php:`$_EXTKEY` option **MUST** be kept within an extension's
   :ref:`ext_emconf.php <extension-declaration>`.

-  You **SHOULD** use a directly called closure function to encapsulate all
   locally defined variables and thus keep them out of the surrounding scope. This
   avoids unexpected side-effects with files of other extensions.

The following example contains the complete code::

    <?php
    defined('TYPO3_MODE') or die();

    (function () {
        // Add your code here
    })();


Additionally, it is possible to extend TYPO3 in a lot of different ways (adding TCA, Backend Routes,
Symfony Console Commands etc) which do not need to touch these files.

Additional tips:

-  :php:`TYPO3\CMS\Core\Package\PackageManager::getActivePackages()` contains information about
   whether the module is loaded as *local* or *system* type in the `packagePath` key,
   including the proper paths you might use, absolute and relative.
