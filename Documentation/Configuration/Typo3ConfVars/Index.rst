:navigation-title: System configuration

..  include:: /Includes.rst.txt
..  index::
    $GLOBALS; TYPO3_CONF_VARS
    TYPO3_CONF_VARS
..  _typo3ConfVars:

==================================================
System configuration and the global `settings.php`
==================================================

System configuration settings, such as database credentials, logging levels, mail
settings, etc, are stored in the central file :file:`system/settings.php`.

This file is primarily managed by TYPO3. Settings can be changed in
the :guilabel:`Admin Tools` modules by users with the
`system maintainer <https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_
role.

The file :file:`system/settings.php` is created during the
`setup process <https://docs.typo3.org/permalink/t3coreapi:installation-setup>`_.

Configuration options are stored internally in the global array
:php:`$GLOBALS['TYPO3_CONF_VARS']`.

They can be overridden in the file  :file:`system/additional.php`. Some settings
can also be overridden by installed extensions. They are then defined in extension file
`ext_localconf.php <https://docs.typo3.org/permalink/t3coreapi:ext-localconf-php>`_
for the frontend and backend contexts or in the extension
`ext_tables.php <https://docs.typo3.org/permalink/t3coreapi:ext-tables-php>`_
for the backend context only.

This chapter describes the global configuration in more detail and gives hints
about further configuration possibilities.

..  toctree::
    :titlesonly:
    :glob:
    :hidden:

    *

..  contents:: Table of contents

..  _configuration-files:

System configuration files
==========================

The configuration files :file:`settings.php` and
:file:`additional.php` are located in the directory
:ref:`directory-config-system` in Composer-based
installations. In classic installations they are located in
:ref:`legacy-directory-typo3conf-system`.

This path can be retrieved from the Environment API. See
:ref:`Environment-config-path` for both Composer-based and classic installations.


Global configuration is stored in file :file:`config/system/settings.php` in
Composer-based extensions and :file:`typo3conf/system/settings.php` in legacy
installations.

This file overrides default settings from
:file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`.

..  index::
    ! File; config/system/settings.php
..  _typo3ConfVars-settings:
..  _typo3ConfVars-localConfiguration:

File :file:`config/system/settings.php`
---------------------------------------

..  typo3:file:: settings.php
    :scope: project
    :regex: /^(.*\/config\/system\/settings\.php|.*\/typo3conf\/system\/settings\.php|settings\.php)$/
    :composerPath: config/system/
    :classicPath: typo3conf/system/
    :shortDescription: Contains system wide settings, managed by the Admin Tools / Install Tool.

    The most important configuration file is
    :file:`settings.php`. It contains local settings in the
    main global PHP array :php:`$GLOBALS['TYPO3_CONF_VARS']`, for example,
    important settings like database connection credentials are in here. The file
    is managed in :guilabel:`Admin Tools`.

..  versionchanged:: 12.0
    For Composer-based installations the configuration files have been moved and
    renamed:

    *   :file:`public/typo3conf/LocalConfiguration.php` is now available in
        :file:`config/system/settings.php`

    For legacy installations to:

    *   :file:`typo3conf/system/settings.php`


..  note::
    The :file:`settings.php` file can be read-only. In this case, the
    sections in the Install Tool that would write to this file inform a
    system maintainer that it is write-protected. All input fields are disabled
    and the save button not available.

The local configuration file is basically a long array which is returned
when the file is included. It represents the global TYPO3 configuration.
This configuration can be modified/extended/overridden by extensions
by setting configuration options inside an extension's
:file:`ext_localconf.php` file. :ref:`See extension files and locations <extension-files-locations>`
for more details about extension structure.

:file:`config/system/settings.php` typically looks like this:

..  literalinclude:: _codesnippets/_settings.php
    :caption: config/system/settings.php | typo3conf/system/settings.php

As you can see, the array is structured on two main levels. The first level
corresponds roughly to categories and the second level to properties, which
may themselves be arrays.

..  typo3:file:: additional.php
    :scope: project
    :composerPath: config/system/
    :classicPath: typo3conf/system/
    :regex: /^(.*\/config\/system\/additional\.php|.*\/typo3conf\/system\/additional\.php|additional\.php)$/
    :shortDescription: Contains system wide settings. Overrides settings.php and is not touched by TYPO3.

    The settings in :file:`settings.php`  can be overridden by changes in the
    :file:`additional.php` file, which is never touched by TYPO3
    internal management tools. Be aware that having settings within
    :file:`additional.php` may prevent the system from performing
    automatic upgrades and should be used with care and only if you know what
    you are doing.

..  index::
    ! File; config/system/additional.php
    Configuration; additional
..  _typo3ConfVars-additional:
..  _typo3ConfVars-additionalConfiguration:

File config/system/additional.php
---------------------------------

Although you can manually edit the :file:`config/system/settings.php`
file, the changes that you can make are limited because the file is expected to return
a PHP array. Also, the file is rewritten every time an option is
changed in the Install Tool or other operations (like changing
an extension configuration in the Extension Manager) so do not put custom
code in this file.

Custom code should be placed in the :file:`config/system/additional.php`
file. This file is never touched by TYPO3, so any code will be
left alone.

As this file is loaded **after** :file:`config/system/settings.php`,
you can make programmatic changes to global configuration values here.

:file:`config/system/additional.php` is a plain PHP file.
There are no specific rules about what it may contain. However, since
the code is included in **every** request to TYPO3
- whether frontend or backend - you should avoid inserting code
which requires a lot of processing time.

**Example: Changing the database hostname for development machines**

..  literalinclude:: _codesnippets/_additional.php
    :caption: config/system/additional.php | typo3conf/system/additional.php

..  versionchanged:: 12.0
    For Composer-based installations the configuration files have been moved and
    renamed:

    *   :file:`public/typo3conf/AdditionalConfiguration.php` is now available
        in :file:`config/system/additional.php`

    For legacy installations to:

    *   :file:`typo3conf/system/additional.php`


System configuration categories
===============================

BE
    :ref:`Options related to the TYPO3 backend <typo3ConfVars_be>`.

DB
    :ref:`Database connection configuration <typo3ConfVars_db>`.

EXT
    :ref:`Extension installation options <typo3ConfVars_ext>`.

EXTCONF
    Backend-related language pack configuration resides here.

EXTENSIONS
    :ref:`Extension configuration <extension-configuration>`.

FE
    :ref:`Frontend-related options <typo3ConfVars_fe>`.

GFX
    :ref:`Options related to image manipulation. <typo3ConfVars_gfx>`.

HTTP
    :ref:`Settings for tuning HTTP requests <typo3ConfVars_http>` made by TYPO3.

LOG
    :ref:`Configuration of the logging system <logging-configuration>`.

MAIL
    :ref:`Options related to the sending of emails <typo3ConfVars_mail>`
    (transport, server, etc.).

SVCONF
    :ref:`Service API configuration <services-developer-service-api-getters>`.

SYS
    :ref:`General options <typo3ConfVars_sys>` which may affect both the
    frontend and the backend.

T3_SERVICES
    :ref:`Service registration configuration <services-configuration-registration-changes>`
    and the backend.

Further details on the various configuration options can be found in the
:guilabel:`Admin Tools` module as well as the TYPO3 source at
:file:`EXT:core/Configuration/DefaultConfigurationDescription.yaml`.
The documentation shown in the :guilabel:`Admin Tools` module is automatically
extracted from those values in :file:`DefaultConfigurationDescription.yaml`.

The :guilabel:`Admin Tools` module provides various sections that
change parts of :file:`config/system/settings.php`. They can be found in
:guilabel:`Admin Tools > Settings` - most importantly section
:guilabel:`Configure installation-wide options`:

..  include:: /Images/AutomaticScreenshots/AdminTools/AllConfiguration.rst.txt

..  include:: /Images/AutomaticScreenshots/AdminTools/InstallationWideOptions.rst.txt

..  index:: File; typo3/sysext/core/Configuration/DefaultConfiguration.php
..  _typo3ConfVars-defaultConfiguration:

File DefaultConfiguration.php
=============================

TYPO3 comes with some default settings which are defined in
file :file:`EXT:core/Configuration/DefaultConfiguration.php`. View the
file on GitHub: :t3src:`typo3/sysext/core/Configuration/DefaultConfiguration.php`.

This file defines configuration defaults that can be overridden in the files
:file:`config/system/settings.php` and :file:`config/system/additional.php`.

..  literalinclude:: _codesnippets/_DefaultConfiguration.php
    :caption: vendor/typo3/cms-core/Configuration/DefaultConfiguration.php (Extract)

It is interesting to take a look at this file, which also contains
values that are not displayed in the Install Tool and therefore cannot be
changed easily.
