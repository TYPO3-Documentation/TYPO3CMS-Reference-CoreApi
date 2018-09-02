.. include:: ../../../Includes.txt

.. _typo3ConfVars:

TYPO3_CONF_VARS
^^^^^^^^^^^^^^^

However the main configuration is achieved via a set of global settings
stored in a global array called :php:`$GLOBALS['TYPO3_CONF_VARS']`.

This chapter describes this global configuration in more details and hints
at other configuration possibilities.


.. _typo3ConfVars-localConfiguration:

File LocalConfiguration.php
"""""""""""""""""""""""""""

The global configuration is stored in file :file:`typo3conf/LocalConfiguration.php`.
This file overrides default settings from :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`.

.. important::

   Since configuration settings can be manipulated from within the
   TYPO3 CMS backend, the :file:`typo3conf/LocalConfiguration.php`
   must be writable by the web server user.

The local configuration file is basically a long array which is simply returned
when the file is included. It represents the global TYPO3 CMS configuration.
This configuration can be modified/extended/overridden by extensions,
by setting configuration options inside an extension's
:file:`ext_localconf.php` file. :ref:`See extension files and locations <extension-files-locations>`
for more details about extension structure.

A typical content of :file:`typo3conf/LocalConfiguration.php` looks like this:

.. code-block:: php

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
         'systemLogLevel' => 0,
      ],
   ];

As you can see, the array is structured on two main levels. The first level
corresponds roughly to a category, the second one being properties, which
may themselves be arrays.

The configuration categories are:

BE
  Options related to the TYPO3 CMS backend

DB
  Database connection configuration

EXTCONF
  Backend related language pack configuration resides here.

EXTENSIONS
  Extension specific settings

FE
  Frontend-related options.

GFX
  Options related to image manipulation.

MAIL
  Options related to the sending of emails (transport, server, etc.).

SYS
  General options which may affect both the frontend and the backend.

Details on the various configuration options can be found in the Install Tool
as well as the TYPO3 source at
:file:`typo3/sysext/core/Configuration/DefaultConfigurationDescription.yaml`.
The documentation shown in the Install Tool is automatically extracted from
those values of :file:`DefaultConfigurationDescription.yaml`.

The Install Tool provides various dedicated modules that change parts of
:file:`LocalConfiguration.php`, those can be found in **ADMIN TOOLS > Settings**,
most importantly section **Configure installation-wide options**:

.. figure:: ../../../Images/InstallToolAllConfiguration.png
   :alt: Configure installation-wide options in Install Tool with an active search



.. _typo3ConfVars-additionalConfiguration:

File AdditionalConfiguration.php
""""""""""""""""""""""""""""""""

Although you can manually edit the :file:`typo3conf/LocalConfiguration.php`
file, it is limited in scope because the file is expected to return
a PHP array. Also the file is rewritten every time an option is
changed in the Install Tool or some other operation (like changing
an extension configuration in the Extension Manager). Thus custom
code cannot reside in that file.

Such code should be placed in the :file:`typo3conf/AdditionalConfiguration.php`
file. This file is never touched by TYPO3, so any code will be
left alone.

Furthermore this file is loaded **after** :file:`typo3conf/LocalConfiguration.php`,
which means it represents an opportunity to change global configuration
values programmatically if needed.

:file:`typo3conf/AdditionalConfiguration.php` is a plain PHP file.
There are no specific rules about what it may contain. However since
the code it contains is included on **every** request to TYPO3 CMS
- whether frontend or backend - you should avoid inserting code
which requires heavy duty processing.


.. _typo3ConfVars-defaultConfiguration:

File DefaultConfiguration.php
"""""""""""""""""""""""""""""

TYPO3 CMS comes with some default settings, which are defined in
file :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`.

This is the base configuration, the other files like :file:`LocalConfiguration.php`
just overlay it.

Here is an extract of that file:

.. code-block:: php

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


You will probably find it interesting to take a look at that file,
which also contains values not displayed in the Install Tool and thus
not easily available for modification.


