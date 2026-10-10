:navigation-title: System configuration

..  include:: /Includes.rst.txt
..  index::
    $GLOBALS; TYPO3_CONF_VARS
    TYPO3_CONF_VARS
..  _typo3confvars:

==================================================
System configuration and the global `settings.php`
==================================================

System configuration settings, such as database credentials, logging levels, mail
settings, etc, are stored in the central file :file:`system/settings.php`.

This file is primarily managed by TYPO3. Settings can be changed in
the :guilabel:`System > Settings` module by users with the
`system maintainer <https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_
role.

The file :file:`system/settings.php` is created during the
`setup process <https://docs.typo3.org/permalink/t3coreapi:installation-setup>`_.

Configuration options are stored internally in the global array
:php:`$GLOBALS['TYPO3_CONF_VARS']`.

They can be overridden in the file  :file:`system/additional.php`. Some settings
can also be overridden by installed extensions. They are then defined in extension file
`ext_localconf.php <https://docs.typo3.org/permalink/t3coreapi:ext-localconf-php>`_
for the frontend and backend contexts.

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

The configuration files :file:`settings.php` and :file:`additional.php` are
located in the directory :ref:`config/system/ <directory-config-system>` in
Composer-based installations. In Classic mode installations they are located in
:ref:`typo3conf/system/ <classic-directory-typo3conf-system>`.

This path can be retrieved from the Environment API. See
:ref:`getConfigPath() <environment-config-path>` for both Composer-based and
Classic mode installations.


Global configuration is stored in file :file:`config/system/settings.php` in
Composer-based extensions and :file:`typo3conf/system/settings.php` in Classic mode
installations.

This file overrides default settings from
:file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`.

..  index::
    ! File; config/system/settings.php
..  _typo3confvars-settings:
..  _typo3confvars-localconfiguration:

File `config/system/settings.php`
---------------------------------

..  typo3:file:: settings.php
    :scope: project
    :regex: /^((.*\/)?(config|typo3conf)\/system\/)?settings\.php$/
    :composerPath: config/system/
    :classicPath: typo3conf/system/
    :shortDescription: Contains system wide settings, managed by the module "System Settings" / Install Tool.

    The most important configuration file is
    :file:`settings.php`. It contains local settings in the
    main global PHP array :php:`$GLOBALS['TYPO3_CONF_VARS']`, for example,
    important settings like database connection credentials are in here. The file
    is managed in the module :guilabel:`System > Settings`.

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
    :regex: /^((.*\/)?(config|typo3conf)\/system\/)?additional\.php$/
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
..  _typo3confvars-additional:
..  _typo3confvars-additionalconfiguration:

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


..  index::
    Configuration; Command line
    Console command; configuration
..  _configuration-files-cli:

Reading and writing the settings on the command line
----------------------------------------------------

..  versionadded:: 14.2
    :changelog: feature-108815-1738249200

Three commands read and write :file:`config/system/settings.php`, which lets a
deployment set a value without an editor and without the Install Tool. Address
a setting by its path, with a slash between the levels of the array:

..  code-block:: bash
    :caption: typo3_root$

    vendor/bin/typo3 configuration:show SYS/sitename
    vendor/bin/typo3 configuration:set SYS/sitename "My Site"
    vendor/bin/typo3 configuration:remove SYS/sitename

`configuration:show
<https://docs.typo3.org/permalink/t3coreapi:console-command-configuration-show>`_
    Prints the value. The option `--type=local` reads the file, and
    `--type=active` reads the value that the request uses, which differs
    where :file:`additional.php` overrides it. Without the option the command
    prints both and marks the difference. `--json` prints the value as JSON.

`configuration:set
<https://docs.typo3.org/permalink/t3coreapi:console-command-configuration-set>`_
    Writes the value into :file:`settings.php`. The command writes a string,
    so pass `--json` for a value of another type, for example
    `configuration:set BE/debug true --json` for a boolean.

`configuration:remove
<https://docs.typo3.org/permalink/t3coreapi:console-command-configuration-remove>`_
    Removes the value, so that the default of TYPO3 applies again. The
    command asks before it writes, and `--force` skips the question, which a
    script needs.

A value that :file:`additional.php` sets stays in force, because TYPO3 reads
that file after :file:`settings.php`. So `configuration:show` can report an
active value that `configuration:set` did not write, and that
`configuration:remove` cannot remove.

..  _typo3-conf-vars-system-configuration-categories:

System configuration categories
===============================

BE
    :ref:`Options related to the TYPO3 backend <typo3confvars-be>`.

DB
    :ref:`Database connection configuration <typo3confvars-db>`.

EXT
    :ref:`Extension installation options <typo3confvars-ext>`.

EXTCONF
    Backend-related language pack configuration resides here.

EXTENSIONS
    :ref:`Extension configuration <extension-configuration>`.

FE
    :ref:`Frontend-related options <typo3confvars-fe>`.

GFX
    :ref:`Options related to image manipulation. <typo3confvars-gfx>`.

HTTP
    :ref:`Settings for tuning HTTP requests <typo3confvars-http>` made by TYPO3.

LOG
    :ref:`Configuration of the logging system <logging-configuration>`.

MAIL
    :ref:`Options related to the sending of emails <typo3confvars-mail>`
    (transport, server, etc.).

SVCONF
    :ref:`Service API configuration <services-developer-service-api-getters>`.

SYS
    :ref:`General options <typo3confvars-sys>` which may affect both the
    frontend and the backend.

T3_SERVICES
    :ref:`Service registration configuration <services-configuration-registration-changes>`
    and the backend.

Further details on the various configuration options can be found in the
:guilabel:`System > Settings` module as well as the TYPO3 source at
:file:`EXT:core/Configuration/DefaultConfigurationDescription.yaml`.
The documentation shown in the :guilabel:`System > Settings` module is automatically
extracted from those values in :file:`DefaultConfigurationDescription.yaml`.

The :guilabel:`System > Settings` module provides various sections that
change parts of :file:`config/system/settings.php`. They can be found in
:guilabel:`System > Settings` - most importantly section
:guilabel:`Configure installation-wide options`:

..  figure:: /Images/ManualScreenshots/AdminTools/AllConfiguration.png
    :zoom: lightbox

    Configure installation-wide options :guilabel:`System > Settings`

..  figure:: /Images/ManualScreenshots/AdminTools/InstallationWideOptions.png
    :zoom: lightbox

    Configure installation-wide options with an active search

..  index:: File; typo3/sysext/core/Configuration/DefaultConfiguration.php
..  _typo3confvars-defaultconfiguration:

File `DefaultConfiguration.php`
===============================

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
