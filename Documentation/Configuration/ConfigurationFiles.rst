.. include:: /Includes.rst.txt

.. _configuration-files:

===================
Configuration files
===================

..  note::
    This page is about configuration for a general TYPO3 installation.
    There might be many other configuration directives, such as for
    RTE (Rich Text Editor), link handling or certain extensions.
    Those directives are not covered on this page.

The configuration files :file:`settings.php` and
:file:`additional.php` are located in the directory
:ref:`directory-config-system` in Composer-based
installations. In legacy installations they are located in
:ref:`legacy-directory-typo3conf-system`.

This path can be retrieved from the Environment API, see
:ref:`Environment-config-path` for both Composer-based and legacy installations.

The most important configuration file is
:file:`settings.php`. It contains local settings of the
main global PHP array :php:`$GLOBALS['TYPO3_CONF_VARS']`, crucial settings
like database connect credentials are in here. The file is managed by the
:guilabel:`Admin Tools`.

The settings in the :file:`settings.php`  can be overridden in the
:file:`additional.php` file, which is never touched by TYPO3
internal management tools. Be aware that having settings within
:file:`additional.php` may prevent the system from performing
automatic upgrades and should be used with care and only if you know what
you are doing.
