.. include:: ../../Includes.txt

.. _Environment:

===========
Environment
===========

Since version 9.x the TYPO3 core includes an environment class.
This class contains all environment-specific information, e.g. paths within the
filesystem. This implementation replaces previously used global variables and
constants like :php:`PATH_site`.

The fully qualified class name is :php:`\TYPO3\CMS\Core\Core\Environment`. The
class provides static methods to access the necessary information.

To simulate environments in testing scenarios, the :php:`initialize()`-method can
be called to adjust the information.

.. _Environment-php-api:

Environment PHP API
===================

.. _Environment-project-path:

getProjectPath()
----------------

The environment provides the path to the folder containing the :file:`composer.json`.
For projects without Composer setup, this is equal to :ref:`Environment-public-path`.


.. _Environment-public-path:

getPublicPath()
---------------

The environment provides the path to the public web folder with
:file:`index.php` for the TYPO3 frontend. This was previously :php:`PATH_site`.
For projects without Composer setup, this is equal to :ref:`Environment-project-path`.


.. _Environment-var-path:

getVarPath()
------------

The environment provides the path to the :file:`var` folder. This folder contains
data like logs, sessions, locks, and cache files.

For projects with Composer setup, the value is :php:`getProjectPath() . '/var'`,
so it is outside of the web document root - not within :php:`getPublicPath()`.

Without Composer, the value is :php:`getPublicPath() . '/typo3temp/var'`, so within
the web document root - a situation that is not optimal from a security point of view.


.. _Environment-config-path:

getConfigPath()
---------------

The environment provides the path to :file:`typo3conf`. This folder contains TYPO3
global configuration files and folders, e.g. :file:`LocalConfiguration.php`.

For projects with Composer setup, the value is :php:`getProjectPath() . '/config'`,
so it is outside of the web document root - not within :php:`getPublicPath()`.

Without Composer, the value is :php:`getPublicPath() . '/typo3conf'`, so within
the web document root - a situation that is not optimal from a security point of view.


.. _Environment-labels-path:

getLabelsPath()
---------------

The environment provides the path to :file:`labels`, respective :file:`l10n`
folder. This folder contains downloaded translation files.

For projects with Composer setup, the value is :php:`getVarPath() . '/labels'`,
so it is outside of the web document root - not within :php:`getPublicPath()`.

Without Composer, the value is :php:`getPublicPath() . '/typo3conf/l10n'`, so within
the web document root - a situation that is not optimal from a security point of view.

.. _Environment-current-script:

getCurrentScript()
------------------

Returns the path and filename to the current PHP script.

.. _Environment-configuring-paths:

Configuring Environment Paths
=============================

The TYPO3 constant :php:`PATH_site` acts as a basis for any PHP entry point. It
can be overwritten via the environment variable :php:`TYPO3_PATH_ROOT`.

The variable :php:`TYPO3_PATH_ROOT` is automatically calculated and set for any Composer-based TYPO3 installation,
making it possible to e.g. run the TYPO3 command line interface from any location.

The environment variable called :php:`TYPO3_PATH_APP` is used
to allow to store **data** outside of the document root.

All Composer-based installations benefit from this functionality, as data that was previously
stored and hard-coded within :file:`typo3temp/var/` is now stored within the **project root** folder :file:`var/`.

For non-composer installations (Classic Mode), it is possible to set the environment variable to a folder, usually one level
upwards than the regular **webroot**. This increases security for any TYPO3 installation as files are not
publicly accessible (for example via web browser) anymore.

A typical example:

- :php:`TYPO3_PATH_APP` is set to :file:`/var/www/my-project`.
- The web folder is then set to :php:`TYPO3_PATH_ROOT` :file:`/var/www/my-project/public`.

Non-public files are then put to

- :file:`/var/www/my-project/var/session` (like Maintenance Tool Session files)
- :file:`/var/www/my-project/var/cache` (Caching Framework data)
- :file:`/var/www/my-project/var/lock` (Files related to locking)
- :file:`/var/www/my-project/var/log` (Files related to logging)
- :file:`/var/www/my-project/var/extensionmanager` (Files related to extension manager data)
- :file:`/var/www/my-project/var/transient` (Files related to import/export, core updater, FAL)

For installations without this setting, there are minor differences in the folder structure:

- :file:`typo3temp/var/cache` is used instead of :file:`typo3temp/var/Cache`
- :file:`typo3temp/var/log` is used instead of :file:`typo3temp/var/logs`
- :file:`typo3temp/var/lock` is used instead of :file:`typo3temp/var/locks`
- :file:`typo3temp/var/session` is used instead of :file:`typo3temp/var/InstallToolSessions`
- :file:`typo3temp/var/extensionmanager` is used instead of :file:`typo3temp/var/ExtensionManager`

.. important::

   Although it is a most common understanding in the TYPO3 world that :file:`typo3temp/` can be removed at any time,
   it is considered bad practice to remove the whole folder. Developers should selectively remove
   folders relevant to the changes made.

