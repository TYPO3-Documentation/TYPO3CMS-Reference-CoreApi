.. include:: /Includes.rst.txt

.. _configuration-files:

===================
Configuration files
===================


..  todo: Situation changed again with
    https://github.com/TYPO3-Documentation/Changelog-To-Doc/issues/204
    I will take care of this in a follow up.

The configuration files :file:`LocalConfiguration.php` and
:file:`AdditionalConfiguration.php` are located in the directory
:ref:`public/typo3conf/ <directory-public-typo3conf>` in Composer-based
installations. In legacy installations they are located in
:file:`typo3conf/`.

The most important configuration file is
:file:`LocalConfiguration.php`. It contains local settings of the
main global PHP array :php:`$GLOBALS['TYPO3_CONF_VARS']`, crucial settings
like database connect credentials are in here. The file is managed by the
:guilabel:`Admin Tools`.

The settings in the :file:`LocalConfiguration.php`  can be overridden in the
:file:`AdditionalConfiguration.php` file, which is never touched by TYPO3
internal management tools. Be aware that having settings within
:file:`AdditionalConfiguration.php` may prevent the system from performing
automatic upgrades and should be used with care and only if you know what
you are doing.
