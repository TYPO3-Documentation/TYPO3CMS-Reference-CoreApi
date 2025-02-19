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
