.. include:: /Includes.rst.txt
.. index:: ! Environment
.. _Environment:

===========
Environment
===========

Since version 9.x the TYPO3 Core  includes an environment class.
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

.. tip::
   A comprehensive list of methods can be found in the
   `Class Reference <https://api.typo3.org/main/class_t_y_p_o3_1_1_c_m_s_1_1_core_1_1_core_1_1_environment.html>`__.

.. index::
   Environment; getProjectPath
   File; composer.json
.. _Environment-project-path:

getProjectPath()
----------------

The environment provides the path to the folder containing the :file:`composer.json`.
For projects without Composer setup, this is equal to :ref:`Environment-public-path`.


.. index::
   Environment; getPublicPath
   PATH_site
.. _Environment-public-path:

getPublicPath()
---------------

The environment provides the path to the public web folder with
:file:`index.php` for the TYPO3 frontend. This was previously :php:`PATH_site`.
For projects without Composer setup, this is equal to :ref:`Environment-project-path`.


.. index::
   Environment; getVarPath
   Path; var
   Path; typo3temp/var
.. _Environment-var-path:

getVarPath()
------------

The environment provides the path to the :file:`var` folder. This folder contains
data like logs, sessions, locks, and cache files.

For Composer-based installations, the it returns :ref:`directory-var`, in legacy
installations :ref:`legacy-directory-typo3temp-var`.

..  code-block:: php

    use TYPO3\CMS\Core\Core\Environment;

    // Composer-based installations: '/home/www/my-project/var/`
    // Legacy installations: '/home/www/my-project/typo3temp/var/'
    $pathToLabels = Environment::getVarPath();


.. index::
   Environment; getConfigPath
   Path; typo3conf
   Path; config
.. _Environment-config-path:

getConfigPath()
---------------

In Composer based installation this method provides the path
:ref:`directory-config`, in legacy installations
:ref:`legacy-directory-typo3conf`.

The directory returned by this method contains the folders :file:`system/`
containing the :ref:`configuration files <configuration-files>`
:file:`system/settings.php` and :file:`system/additional.php` and the folder
:file:`sites/` containing the :ref:`site configuration <sitehandling>`.

..  code-block:: php

    use TYPO3\CMS\Core\Core\Environment;

    // Composer-based installations: '/home/www/my-project/config/system/settings.php`
    // Legacy installations: '/home/www/my-project/typo3conf/system/settings.php'
    $pathToSetting = Environment::getConfigPath() . 'system/settings.php';

    // Composer-based installations: '/home/www/my-project/config/sites/mysite/config.yaml`
    // Legacy installations: '/home/www/my-project/typo3conf/sites/mysite/config.yaml'
    $pathToSiteConfig = Environment::getConfigPath() . 'sites/' . $siteKey . '/config.yaml';


.. index::
   Environment; getConfigPath
   Path; var/labels
   Path; typo3conf/l10n
.. _Environment-labels-path:

getLabelsPath()
---------------

The environment provides the path to :ref:`directory-var-labels` in
Composer-based installations, respective :ref:`legacy-directory-typo3conf-l10n`
folder in Legacy installations. This folder contains downloaded translation files.

..  code-block:: php

    use TYPO3\CMS\Core\Core\Environment;

    // Composer-based installations: '/home/www/my-project/var/labels/`
    // Legacy installations: '/home/www/my-project/typo3conf/l10n/'
    $pathToLabels = Environment::getLabelsPath();

.. index:: Environment; getCurrentScript
.. _Environment-current-script:

getCurrentScript()
------------------

Returns the path and filename to the current PHP script.

.. index::
   Environment; getContext
   Application context
   TYPO3_CONTEXT
.. _Environment-context:

getContext()
------------

Returns the current :ref:`application-context`, usually defined via the `TYPO3_CONTEXT` environment variable.
May be one of `Production`, `Testing`, or `Development` with optional sub-contexts like `Production/Staging`.

Example, test for production context:

.. code-block:: php
   :caption: config/system/additional.php | typo3conf/system/additional.php

   use TYPO3\CMS\Core\Core\Environment;

   $applicationContext = Environment::getContext();
   if ($applicationContext->isProduction()) {
      // do something only when in production context
   }

.. index::
   Environment; Configuration
   PATH_site
   TYPO3_PATH_ROOT
   TYPO3_PATH_APP
.. _Environment-configuring-paths:

Configuring environment paths
=============================

..  todo: the constants where removed, this section must be reviewed.

The TYPO3 constant :php:`PATH_site` acts as a basis for any PHP entry point. It
can be overwritten via the environment variable :php:`TYPO3_PATH_ROOT`.

The variable :php:`TYPO3_PATH_ROOT` is automatically calculated and set for any Composer-based TYPO3 installation,
making it possible to e.g. run the TYPO3 command line interface from any location.

The environment variable called :php:`TYPO3_PATH_APP` is used
to allow to store **data** outside of the document root.

All Composer-based installations benefit from this functionality, as data that was previously
stored and hard-coded within :file:`typo3temp/var/` is now stored within the **project root** folder :file:`var/`.

For non-Composer installations (Classic Mode), it is possible to set the environment variable to a folder, usually one level
upwards than the regular **webroot**. This increases security for any TYPO3 installation as files are not
publicly accessible (for example via web browser) anymore.

A typical example:

- :php:`TYPO3_PATH_APP` is set to :file:`/home/www/my-project`.
- The web folder is then set to :php:`TYPO3_PATH_ROOT` :file:`/home/www/my-project/public`.

Non-public files are then put to

- :file:`/home/www/my-project/var/session` (like Maintenance Tool Session files)
- :file:`/home/www/my-project/var/cache` (Caching Framework data)
- :file:`/home/www/my-project/var/lock` (Files related to locking)
- :file:`/home/www/my-project/var/log` (Files related to logging)
- :file:`/home/www/my-project/var/extensionmanager` (Files related to extension manager data)
- :file:`/home/www/my-project/var/transient` (Files related to import/export, Core updater, FAL)

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
