.. include:: /Includes.rst.txt

.. _configuration-files:

===================
Configuration files
===================

The configuration files :file:`LocalConfiguration.php` and
:file:`AdditionalConfiguration.php` are located in the directory
:ref:`public/typo3conf/ <directory-public-typo3conf>` in Composer-based
installations. In legacy installations they are located in
:ref:`typo3conf/ <legacy-directory-typo3conf>`.

The most important configuration file is
:file:`LocalConfiguration.php`. It contains local settings of the
main global PHP array :php:`$GLOBALS['TYPO3_CONF_VARS`], crucial settings
like database connect credentials are in here. The file is managed by the
:guilabel:`Admin Tools`.

The file :file:`LocalConfiguration.php` can be overridden by settings in the file
:file:`AdditionalConfiguration.php` which is never touched by TYPO3
internal management tools. Be aware that having settings within
:file:`AdditionalConfiguration.php` may prevent the system from doing
automatic upgrades and should be used with care and only if you know what
you are doing.
