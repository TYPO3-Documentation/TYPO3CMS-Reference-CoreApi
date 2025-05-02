:navigation-title: System configuration

..  include:: /Includes.rst.txt
..  index::
    $GLOBALS; TYPO3_CONF_VARS
    TYPO3_CONF_VARS
..  _typo3ConfVars:

==================================================
System configuration and the global `settings.php`
==================================================

System configuration settings, like database credentials, logging levels, mail
settings etc are stored in a central file :file:`system/settings.php`.

This file is usually managed by TYPO3. Settings can be adjusted in
the :guilabel:`Admin Tools` modules available to user with
`system maintainers <https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_
role.

File :file:`system/settings.php` is created automatically during the
`setup process <https://docs.typo3.org/permalink/t3coreapi:installation-setup>`_.

Configuration options are internally stored in the global array
:php:`$GLOBALS['TYPO3_CONF_VARS']`.

They can be overridden in the file  :file:`system/additional.php`. Some settings
are also overridden in installed extensions. They are then defined in file
`ext_localconf.php <https://docs.typo3.org/permalink/t3coreapi:ext-localconf-php>`_
for the frontend and the backend context or in
`ext_tables.php <https://docs.typo3.org/permalink/t3coreapi:ext-tables-php>`_
for the backend context only.

This chapter describes this global configuration in more details and gives hints
to further configuration possibilities.

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

This path can be retrieved from the Environment API, see
:ref:`Environment-config-path` for both Composer-based and classic installations.


The global configuration is stored in file :file:`config/system/settings.php` in
Composer-based extensions, :file:`typo3conf/system/settings.php` in legacy
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
    :file:`settings.php`. It contains local settings of the
    main global PHP array :php:`$GLOBALS['TYPO3_CONF_VARS']`, crucial settings
    like database connect credentials are in here. The file is managed by the
    modules in section :guilabel:`Admin Tools`.

..  note::
    The :file:`settings.php` file can be read-only. In this case, the
    sections in the Install Tool that would write to this file inform a
    system maintainer that it is write-protected. All input fields are disabled
    and the save button not available.

The local configuration file is basically a long array which is simply returned
when the file is included. It represents the global TYPO3 configuration.
This configuration can be modified/extended/overridden by extensions
by setting configuration options inside an extension's
:file:`ext_localconf.php` file. :ref:`See extension files and locations <extension-files-locations>`
for more details about extension structure.

A typical content of :file:`config/system/settings.php` looks like this:

..  literalinclude:: _codesnippets/_settings.php
    :caption: config/system/settings.php | typo3conf/system/settings.php

As you can see, the array is structured on two main levels. The first level
corresponds roughly to a category, the second one being properties, which
may themselves be arrays.

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

..  index::
    ! File; config/system/additional.php
    Configuration; additional
..  _typo3ConfVars-additional:
..  _typo3ConfVars-additionalConfiguration:

File config/system/additional.php
---------------------------------

Although you can manually edit the :file:`config/system/settings.php`
file, it is limited in scope because the file is expected to return
a PHP array. Also the file is rewritten every time an option is
changed in the Install Tool or some other operation (like changing
an extension configuration in the Extension Manager). Thus custom
code cannot reside in that file.

Such code should be placed in the :file:`config/system/additional.php`
file. This file is never touched by TYPO3, so any code will be
left alone.

Furthermore this file is loaded **after** :file:`config/system/settings.php`,
which means it represents an opportunity to change global configuration
values programmatically if needed.

:file:`config/system/additional.php` is a plain PHP file.
There are no specific rules about what it may contain. However, since
the code is included on **every** request to TYPO3
- whether frontend or backend - you should avoid inserting code
which requires a lot of processing time.

**Example: Changing the database hostname for development machines**

..  literalinclude:: _codesnippets/_additional.php
    :caption: config/system/additional.php | typo3conf/system/additional.php


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
extracted from those values of :file:`DefaultConfigurationDescription.yaml`.

The :guilabel:`Admin Tools` module provides various dedicated sections that
change parts of :file:`config/system/settings.php`, those can be found in
:guilabel:`Admin Tools > Settings`, most importantly section
:guilabel:`Configure installation-wide options`:

..  include:: /Images/AutomaticScreenshots/AdminTools/AllConfiguration.rst.txt

..  include:: /Images/AutomaticScreenshots/AdminTools/InstallationWideOptions.rst.txt

..  index:: File; typo3/sysext/core/Configuration/DefaultConfiguration.php
..  _typo3ConfVars-defaultConfiguration:

File DefaultConfiguration.php
=============================

TYPO3 comes with some default settings, which are defined in
file :file:`EXT:core/Configuration/DefaultConfiguration.php`. View the
file on GitHub: :t3src:`typo3/sysext/core/Configuration/DefaultConfiguration.php`.

This file defines configuration defaults that can be overridden in the files
:file:`config/system/settings.php` and :file:`config/system/additional.php`.

..  literalinclude:: _codesnippets/_DefaultConfiguration.php
    :caption: vendor/typo3/cms-core/Configuration/DefaultConfiguration.php (Extract)

It is certainly interesting to take a look into this file, which also contains
values that are not displayed in the Install Tool and therefore cannot be
changed easily.
