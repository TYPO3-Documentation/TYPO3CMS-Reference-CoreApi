..  include:: /Includes.rst.txt
..  index::
    $GLOBALS; TYPO3_CONF_VARS
    TYPO3_CONF_VARS
..  _typo3ConfVars:

===============
TYPO3_CONF_VARS
===============

The main configuration is achieved via a set of global settings
stored in a global array called :php:`$GLOBALS['TYPO3_CONF_VARS']`.

This chapter describes this global configuration in more details and gives hints
to further configuration possibilities.

..  note::
    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`

..  toctree::
    :titlesonly:
    :glob:
    :hidden:

    *

..  index::
    ! File; config/system/settings.php
..  _typo3ConfVars-settings:
..  _typo3ConfVars-localConfiguration:

File :file:`config/system/settings.php`
=======================================

..  todo: We are describing these files also in Configuration/ConfigurationFiles.rst
    Merge those two chapters?
    https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/2289

The global configuration is stored in file :file:`config/system/settings.php` in
Composer-based extensions, :file:`typo3conf/system/settings.php` in legacy
installations.

This file overrides default settings from
:file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`.

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

..  code-block:: php
    :caption: config/system/settings.php | typo3conf/system/settings.php

    <?php
    return [
       'BE' => [
          'debug' => true,
          'explicitADmode' => 'explicitAllow',
          'installToolPassword' => '$P$Cbp90UttdtIKELNrDGjy4tDxh3uu9D/',
          'loginSecurityLevel' => 'normal',
       ],
       'DB' => [
          'Connections' => [
             'Default' => [
                'charset' => 'utf8',
                'dbname' => 'empty_typo3',
                'driver' => 'mysqli',
                'host' => '127.0.0.1',
                'password' => 'foo',
                'port' => 3306,
                'user' => 'bar',
             ],
          ],
       ],
       'EXTCONF' => [
           'lang' => [
               'availableLanguages' => [
                   'de',
                   'eo',
               ],
           ],
       ],
       'EXTENSIONS' => [
           'backend' => [
               'backendFavicon' => '',
               'backendLogo' => '',
               'loginBackgroundImage' => '',
               'loginFootnote' => '',
               'loginHighlightColor' => '',
               'loginLogo' => '',
           ],
           'extensionmanager' => [
               'automaticInstallation' => '1',
               'offlineMode' => '0',
           ],
           'scheduler' => [
               'maxLifetime' => '1440',
               'showSampleTasks' => '1',
           ],
       ],
       'FE' => [
          'debug' => true,
          'loginSecurityLevel' => 'normal',
       ],
       'GFX' => [
          'jpg_quality' => '80',
       ],
       'MAIL' => [
          'transport_sendmail_command' => '/usr/sbin/sendmail -t -i ',
       ],
       'SYS' => [
          'devIPmask' => '*',
          'displayErrors' => 1,
          'encryptionKey' => '0396e1b6b53bf48b0bfed9e97a62744158452dfb9b9909fe32d4b7a709816c9b4e94dcd69c011f989d322cb22309f2f2',
          'exceptionalErrors' => 28674,
          'sitename' => 'New TYPO3 site',
       ],
    ];

As you can see, the array is structured on two main levels. The first level
corresponds roughly to a category, the second one being properties, which
may themselves be arrays.

The configuration categories are:

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

.. include:: /Images/AutomaticScreenshots/AdminTools/AllConfiguration.rst.txt

.. include:: /Images/AutomaticScreenshots/AdminTools/InstallationWideOptions.rst.txt


.. index::
   ! File; config/system/additional.php
   Configuration; additional
.. _typo3ConfVars-additional:
.. _typo3ConfVars-additionalConfiguration:

File config/system/additional.php
=================================

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

.. code-block:: php
   :caption: config/system/additional.php | typo3conf/system/additional.php

   <?php

   $applicationContext = \TYPO3\CMS\Core\Core\Environment::getContext();
   if ($applicationContext->isDevelopment()) {
       $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'] = 'mysql-be';
   }


.. index:: File; typo3/sysext/core/Configuration/DefaultConfiguration.php
.. _typo3ConfVars-defaultConfiguration:

File DefaultConfiguration.php
=============================

TYPO3 comes with some default settings, which are defined in
file :file:`EXT:core/Configuration/DefaultConfiguration.php`.

This is the base configuration, the other files like :file:`config/system/settings.php`
just overlay it.

Here is an extract of that file:

..  code-block:: php

    return [
        'GFX' => [
            'thumbnails' => true,
            'thumbnails_png' => true,
            'gif_compress' => true,
            'imagefile_ext' => 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai,svg',
            // ...
        ],
        // ...
    ];


It is certainly interesting to take a look into this file, which also contains
values that are not displayed in the Install Tool and therefore cannot be
changed easily.
