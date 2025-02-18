:navigation-title: Configuration files

.. include:: /Includes.rst.txt
.. _configuration-files:

==========================
System configuration files
==========================

..  typo3:file:: settings.php
    :scope: project
    :regex: /^(.*\/config\/system\/settings\.php|.*\/typo3conf\/system\/settings\.php|settings\.php)$/
    :composerPath: config/system/
    :classicPath: typo3conf/system/
    :shortDescription: Contains system wide settings, managed by the Admin Tools / Install Tool.

    The most important configuration file is
    :file:`settings.php`. It contains local settings of the
    main global PHP array :php:`$GLOBALS['TYPO3_CONF_VARS']`, crucial settings
    like database connect credentials are in here. The file is managed by the
    modules in section :guilabel:`Admin Tools`.

..  typo3:file:: additional.php
    :scope: project
    :composerPath: config/system/
    :classicPath: typo3conf/system/
    :regex: /^(.*\/config\/system\/additional\.php|.*\/typo3conf\/system\/additional\.php|additional\.php)$/
    :shortDescription: Contains system wide settings. Overrides settings.php and is not touched by TYPO3.

    The settings in the :file:`settings.php`  can be overridden in the
    :file:`additional.php` file, which is never touched by TYPO3
    internal management tools. Be aware that having settings within
    :file:`additional.php` may prevent the system from performing
    automatic upgrades and should be used with care and only if you know what
    you are doing.

The configuration files :file:`settings.php` and
:file:`additional.php` are located in the directory
:ref:`directory-config-system` in Composer-based
installations. In classic installations they are located in
:ref:`legacy-directory-typo3conf-system`.

This path can be retrieved from the Environment API, see
:ref:`Environment-config-path` for both Composer-based and classic installations.

.. _configuration-files-migration:

Migration
=========

..  versionchanged:: 12.0
    For Composer-based installations the configuration files have been moved and
    renamed:

    *   :file:`public/typo3conf/LocalConfiguration.php` is now available in
        :file:`config/system/settings.php`
    *   :file:`public/typo3conf/AdditionalConfiguration.php` is now available
        in :file:`config/system/additional.php`

    For legacy installations to:

    *   :file:`typo3conf/system/settings.php`
    *   :file:`typo3conf/system/additional.php`

This path can be retrieved from the Environment API, see
:ref:`Environment-config-path` for both Composer-based and legacy installations.

The configuration files are automatically moved with TYPO3 v12.0 to their new
locations, so no manual process is needed.

Projects working with a versioning control system such as Git might need to adapt
their :file:`.gitignore` file or their deployment strategies.

In addition, TYPO3 projects relying on the file locations and their structures
might need adaptions.

.. _configuration-files-history:

History
=======

Until TYPO3 v12 every installation required a mandatory file named
:file:`typo3conf/LocalConfiguration.php`.

Historically, the very original
name was :file:`typo3conf/localconf.php` (this is also where the extensions' file
name :file:`ext_localconf.php` comes from). This file was renamed in TYPO3 v6.0
to :php:`LocalConfiguration.php`  and since then returns a PHP array with
settings then available in :php:`$TYPO3_CONF_VARS`.

Specific PHP code with additional logic (e.g. context-specific conditions) was
available in :php:`typo3conf/AdditionalConfiguration.php`.

With TYPO3 v12, the names for both files and their location have been changed.

The prefix "Local" in :php:`LocalConfiguration.php` originates from the
three-divided location of "system", "global" and "local" extensions - the latter
is "specific to a TYPO3 installation" where as other extensions and configuration
could be shared with multiple TYPO3 installations.

TYPO3 v12 has a strong support for Composer and TYPO3's own code base has
progressed since 2012, when TYPO3 v6.0 was released. TYPO3 Core itself now
only consists of extensions which are available as native Composer packages.
The concept of global extensions has been phased out over the past versions.

Instead, TYPO3 installations now distinguish between "dependencies" such as
custom extensions, TYPO3 Core extensions or extensions from packagist.org or
TYPO3 Extension Repository, and "project-specific" configuration. This
project-specific configuration - as known from other PHP frameworks - is now
placed in a settings configuration file and additional configuration file.

Newcomers or users from other PHP projects might understand the concept of a file
with certain settings much better, so the file locations and the file names
have been changed.

Composer-based TYPO3 projects by default have the possibility to place certain
files from outside the document root, and using the document root such as :ref:`directory-public`
as a subfolder. This way, Composer-based TYPO3 projects can restrict direct public
access to such files via the webserver.

TYPO3 in its Composer mode already creates a folder named :ref:`directory-config` on the
project root level, where e.g. the site configuration is stored. Within the
:file:`config/` folder, the configuration files are placed starting with TYPO3
v12:

*   :file:`public/typo3conf/LocalConfiguration.php` is now available in
    :file:`config/system/settings.php`
*   :file:`public/typo3conf/AdditionalConfiguration.php` is now available in
    :file:`config/system/additional.php`


For legacy installations the file names are:

*   :file:`typo3conf/LocalConfiguration.php` is now available in
    :file:`typo3conf/system/settings.php`
*   :file:`typo3conf/AdditionalConfiguration.php` is now available in
    :file:`typo3conf/system/additional.php`

TYPO3 v12 automatically moves the :file:`typo3conf/LocalConfiguration.php` and
:file:`typo3conf/AdditionalConfiguration.php` to their respective new places on
the first PHP request. The old file is not evaluated anymore, as soon as the file
in the new location is available.
