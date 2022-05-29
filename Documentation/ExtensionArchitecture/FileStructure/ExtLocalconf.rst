.. include:: /Includes.rst.txt
.. index::
   File; EXT:{extkey}/ext_localconf.php
.. _ext-localconf-php:

=======================================
:file:`ext_localconf.php`
=======================================

*-- optional*

:file:`ext_localconf.php` is always included in global scope of the script,
in the frontend, backend and CLI context.

It should contain additional configuration of :php:`$GLOBALS['TYPO3_CONF_VARS']`.

This file contains hook definitions and plugin configuration. It must
not contain a PHP encoding declaration.

All :file:`ext_localconf.php` files of loaded extensions are
included right  *after* the files :file:`typo3conf/LocalConfiguration.php`
and :file:`typo3conf/AdditionalConfiguration.php` during TYPO3
:ref:`bootstrap <bootstrapping>`.

Pay attention to the rules for the contents of these files.
For more details, see the :ref:`section below <extension-configuration-files>`.


Should not be used for
======================

While you *can* put functions and classes into :file:`ext_localconf.php`,
it considered bad practice because such classes and functions would *always* be
loaded. Move such functionality to services or utility classes instead.

Registering :ref:`hooks <hooks-concept>`, :ref:`XCLASSes
<xclasses>` or any simple array assignments to
:php:`$GLOBALS['TYPO3_CONF_VARS']` options will not work for the following:

*  class loader
*  package manager
*  cache manager
*  configuration manager
*  log manager (= :ref:`Logging Framework <logging>`)
*  time zone
*  memory limit
*  locales
*  stream wrapper
*  :ref:`error handler <error-handling-extending>`

This would not work because the extension files :file:`ext_localconf.php` are
included (:php:`loadTypo3LoadedExtAndExtLocalconf`) after the creation of the
mentioned objects in the :ref:`Bootstrap <bootstrapping>` class.

In most cases, these assignments should be placed in
:file:`typo3conf/AdditionalConfiguration.php`.

Example:

:ref:`Register an exception handler <error-handling-extending>`:

.. code-block:: php
   :caption: typo3conf/AdditionalConfiguration.php

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] =
       \Vendor\Ext\Error\PostExceptionsOnTwitter::class;

.. deprecated:: 11.5
   Icons should be registered in :ref:`extension-configuration-Icons-php`.

   See also: :ref:`IconRegistry <icon-registration>`

Should be used for
==================

These are the typical functions that extension authors should place within
file:`ext_localconf.php`

*  Registering :ref:`hooks <hooks-concept>`, :ref:`XCLASSes <xclasses>`
   or any simple array assignments to :php:`$GLOBALS['TYPO3_CONF_VARS']` options
*  Registering additional Request Handlers within the :ref:`Bootstrap <bootstrapping>`
*  Adding any :ref:`PageTSconfig <t3tsconfig:pagesettingdefaultpagetsconfig>`
*  Adding default TypoScript via :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility` APIs
*  Registering Scheduler Tasks
*  Adding reports to the reports module
*  Registering Services via the :ref:`Service API <services-developer-service-api>`


Examples
--------

Put a file called :file:`ext_localconf.php` in the main directory of your
Extension. It does not need to be registered anywhere but will be loaded
automatically as soon as the extension is installed.
The skeleton of the :file:`ext_localconf.php` looks like this:

.. code-block:: php
   :caption: EXT:site_package/ext_localconf.php

   <?php
   // all use statements must come first
   use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

   // Prevent Script from being called directly
   defined('TYPO3') or die();

   // encapsulate all locally defined variables
   (function () {
       // Add your code here
   })();


.. index:: Extension development; PageTSconfig

Adding default PageTSconfig
~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. todo: What about EXT:some_extension/Configuration/page.tsconfig? Starting with v12

Default PageTSconfig can be added inside :file:`ext_localconf.php`, see
:ref:`t3tsconfig:pagesettingdefaultpagetsconfig`:

.. code-block:: php
   :caption: EXT:site_package/ext_localconf.php

   //use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

   ExtensionManagementUtility::addPageTSConfig();

PageTSconfig available via static files can be added inside
:file:`Configuration/TCA/Overrides/pages.php`, see
:ref:`t3tsconfig:pagesettingstaticpagetsconfigfiles`:

.. code-block:: php
   :caption: EXT:site_package/Configuration/TCA/Overrides/pages.php

   ExtensionManagementUtility::registerPageTSConfigFile();


.. index:: Extension development; UserTSconfig

Adding default UserTSconfig
~~~~~~~~~~~~~~~~~~~~~~~~~~~

As for default PageTSconfig, UserTSconfig can be added inside
:file:`ext_localconf.php`, see:
:ref:`t3tsconfig:usersettingdefaultusertsconfig`:

.. code-block:: php
   :caption: EXT:site_package/ext_localconf.php

   //use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

   ExtensionManagementUtility::addUserTSConfig();

