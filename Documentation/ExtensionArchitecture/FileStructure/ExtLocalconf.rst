.. include:: /Includes.rst.txt
.. index::
   File; EXT:{extkey}/ext_localconf.php
.. _ext-localconf-php:

=========================
:file:`ext_localconf.php`
=========================

*-- optional*

:file:`ext_localconf.php` is always included in global scope of the script,
in the frontend, backend and CLI context.

It should contain additional configuration of :php:`$GLOBALS['TYPO3_CONF_VARS']`.

This file contains hook definitions and plugin configuration. It must
not contain a PHP encoding declaration.

All :file:`ext_localconf.php` files of loaded extensions are
included right  *after* the files :file:`config/system/settings.php`
and :file:`config/system/additional.php` during TYPO3
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

*   class loader
*   package manager
*   cache manager
*   configuration manager
*   log manager (= :ref:`Logging Framework <logging>`)
*   time zone
*   memory limit
*   locales
*   stream wrapper
*   :ref:`error handler <error-handling-extending>`
*   Icon registration. Icons should be registered in :ref:`extension-configuration-Icons-php`.

This would not work because the extension files :file:`ext_localconf.php` are
included (:php:`loadTypo3LoadedExtAndExtLocalconf`) after the creation of the
mentioned objects in the :ref:`Bootstrap <bootstrapping>` class.

In most cases, these assignments should be placed in
:file:`config/system/additional.php`.

Example:

:ref:`Register an exception handler <error-handling-extending>`:

.. code-block:: php
   :caption: config/system/additional.php | typo3conf/system/additional.php

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] =
       \Vendor\Ext\Error\PostExceptionsOnTwitter::class;

Should be used for
==================

These are the typical functions that extension authors should place within
file:`ext_localconf.php`

*   Registering :ref:`hooks <hooks-concept>`, :ref:`XCLASSes <xclasses>`
    or any simple array assignments to :php:`$GLOBALS['TYPO3_CONF_VARS']` options
*   Registering additional Request Handlers within the :ref:`Bootstrap <bootstrapping>`
*   Adding any :ref:`page TSconfig <t3tsref:pagesettingdefaultpagetsconfig>`
*   Adding default TypoScript via :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility` APIs
*   Registering Scheduler Tasks
*   Adding reports to the reports module
*   Registering Services via the :ref:`Service API <services-developer-service-api>`


Examples
--------

Put a file called :file:`ext_localconf.php` in the main directory of your
Extension. It does not need to be registered anywhere but will be loaded
automatically as soon as the extension is installed.
The skeleton of the :file:`ext_localconf.php` looks like this:

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

Read :ref:`why the check for the TYPO3 constant is necessary <globals-constants-typo3>`.

.. index:: Extension development; PageTSconfig

Adding default page TSconfig
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  versionchanged:: 12.0
    Page TSconfig in a file :file:`EXT:some_extension/Configuration/page.tsconfig`
    is loaded globally.

Put all page TSconfig that must always be loaded into file
:file:`EXT:some_extension/Configuration/page.tsconfig`. If your extension should
also be compatible with TYPO3 v11, you can additionally load it in the
:file:`ext_localconf.php`: :ref:`Global page TSconfig, compatible
with TYPO3 11 and 12 <t3tsref:page-tsconfig-v11-v12>`:

Page TSconfig that can be added in the page settings should be added in the
file :file:`Configuration/TCA/Overrides/pages.php`, see
:ref:`t3tsref:pagesettingstaticpagetsconfigfiles`.

.. index:: Extension development; UserTSconfig

Adding default user TSconfig
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  deprecated:: 13.0
    The method
    :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig()`
    will be removed with TYPO3 v14.0. Use
    :ref:`Configuration/user.tsconfig <extension-configuration-user_tsconfig>`
    instead.

    Extensions with compatibility for both TYPO3 v12 and v13 should keep the old
    way and switch to the :file:`Configuration/user.tsconfig` file when v12
    support is dropped.

As for default page TSconfig, user TSconfig can be added inside
:file:`ext_localconf.php`, see:
:ref:`t3tsref:usersettingdefaultusertsconfig`:

..  literalinclude:: _ext_localconf_user_tsconfig.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

See also :ref:`Setting user TSconfig <t3tsref:setting-user-tsconfig>`.
