:navigation-title: Configuration Files

..  include:: /Includes.rst.txt
..  index:: Extension development; Configuration Files
..  _extension-conventions-configuration-files:

========================================================
Configuration files (ext_tables.php & ext_localconf.php)
========================================================

The files :file:`ext_tables.php` and :file:`ext_localconf.php`
contain configuration used by the system and in
requests. They should therefore be optimized for speed.

See :ref:`extension-files-locations` for a full list of file and
directory names typically used in extensions.

..  warning::
    The content of the files :file:`ext_localconf.php` and
    :file:`ext_tables.php` **must not** be wrapped in a
    local namespace by extension authors. This would lead to nested namespaces
    causing PHP errors that can only be solved by clearing the caches via the
    Install Tool.

..  _rules_ext_tables_localconf_php:

Rules and best practices
========================

The following apply for both :php:`ext_tables.php` and :php:`ext_localconf.php`.

As a rule of thumb: Your :file:`ext_tables.php` and :file:`ext_localconf.php`
files must be designed in a way
that they can safely be read and subsequently imploded into one single
file with all configuration of other extensions.

-   You **must not** use a :php:`return` statement in the file's global scope -
    that would make the cached script concept break.

-   You **must not** rely on the PHP constant :php:`__FILE__` for detection of
    the include path of the script - the configuration might be executed from
    a cached file with a different location and therefore such information should
    be derived from, for example,
    :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName()` or
    :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath()`.

-   You **must not** wrap the file in a local namespace. This will result in
    nested namespaces.

    ..  code-block:: diff
        :caption: Diff of EXT:my_extension/ext_localconf.php | EXT:my_extension/ext_tables.php

        -namespace {
        -}

-   You **can** use :php:`use` statements starting with TYPO3 v11.4:

    ..  code-block:: diff
        :caption: Diff of EXT:my_extension/ext_localconf.php | EXT:my_extension/ext_tables.php

        // you can use use:
        +use TYPO3\CMS\Core\Resource\Security\FileMetadataPermissionsAspect;
        +
        +$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        +   FileMetadataPermissionsAspect::class;
        // Instead of the full class name:
        -$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        -   \TYPO3\CMS\Core\Resource\Security\FileMetadataPermissionsAspect::class;

-   You **can** use :php:`declare(strict_types=1)` and similar directives which
    must be placed at the very top of files. They will be stripped and added
    once in the concatenated cache file.

    ..  code-block:: diff
        :caption: Diff of EXT:my_extension/ext_localconf.php | EXT:my_extension/ext_tables.php

        // You can use declare strict and other directives
        // which must be placed at the top of the file
        +declare(strict_types=1);


-   You **must not** check for values of the removed :php:`TYPO3_MODE` or
    :php:`TYPO3_REQUESTTYPE` constants (for example,
    :php:`if (TYPO3_MODE === 'BE')`) or use the
    :php:`\TYPO3\CMS\Core\Http\ApplicationType` enum within these files as
    it limits the functionality to cache the whole configuration of the system.
    Any extension author should remove the checks, and re-evaluate if these
    context-depending checks could go inside the hooks / caller function
    directly, for example, do not:

    ..  code-block:: diff
        :caption: Diff of EXT:my_extension/ext_localconf.php | EXT:my_extension/ext_tables.php

        // do NOT do this:
        -if (TYPO3_MODE === 'BE')


-   You **should** check for the existence of the constant
    :php:`defined('TYPO3') or die();`
    at the top of :file:`ext_tables.php` and :file:`ext_localconf.php` files
    right after the use statements to make sure the file is
    executed only indirectly within TYPO3 context. This is a security measure
    since this code in global scope should not be executed through the web
    server directly as entry point.

    ..  code-block:: php
        :caption: EXT:my_extension/ext_localconf.php | EXT:my_extension/ext_tables.php

        <?php
        declare(strict_types=1);

        use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

        // put this at top of every ext_tables.php and ext_localconf.php right after
        // the use statements
        defined('TYPO3') or die();

-   You **must** use the extension name (for example, "tt_address") instead of
    :php:`$_EXTKEY` within the two configuration files as this variable is no
    longer loaded automatically.

-   However, due to limitations in the TYPO3 Extension Repository, the
    :php:`$_EXTKEY` option **must** be kept within an extension's
    :ref:`ext_emconf.php <extension-declaration>` file.

-   You **do not have to** use a directly called closure function after dropping
    TYPO3 v10.4 support.

The following example contains the complete code:

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php | EXT:my_extension/ext_tables.php


Additionally, it is possible to extend TYPO3 in a lot of different ways (adding
:ref:`TCA <t3tca:start>`, :ref:`backend routes <backend-routing>`,
:ref:`Symfony console commands <symfony-console-commands>`, etc), which do not
need to touch these files.

..  tip::
    :php:`\TYPO3\CMS\Core\Package\PackageManager::getActivePackages()` contains
    information about whether the module is loaded as *local* or *system* type
    in the `packagePath` key, including the proper paths you might use, absolute
    and relative.
