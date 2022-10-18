.. include:: /Includes.rst.txt
.. index:: ! Environment
.. _Environment:

===========
Environment
===========

The TYPO3 Core includes an environment class that contains all
environment-specific information, mostly paths within the
filesystem. This implementation replaces previously used global variables and
constants like :php:`PATH_site` that have been removed with TYPO3 v10.

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

The environment provides the path to the :file:`var/` folder. This folder contains
data like logs, sessions, locks, and cache files.

For Composer-based installations, it returns :ref:`directory-var`, in legacy
installations :ref:`legacy-directory-typo3temp-var`.

..  code-block:: php

    use TYPO3\CMS\Core\Core\Environment;

    // Composer-based installations: '/path/to/my-project/var/`
    // Legacy installations: '/path/to/my-project/typo3temp/var/'
    $pathToLabels = Environment::getVarPath();


.. index::
   Environment; getConfigPath
   Path; typo3conf
   Path; config
.. _Environment-config-path:

getConfigPath()
---------------

In Composer-based installation this method provides the path
:ref:`directory-config`, in legacy installations
:ref:`legacy-directory-typo3conf`.

The directory returned by this method contains the folders :file:`system/`
containing the :ref:`configuration files <configuration-files>`
:file:`system/settings.php` and :file:`system/additional.php` and the folder
:file:`sites/` containing the :ref:`site configurations <sitehandling>`.

..  code-block:: php

    use TYPO3\CMS\Core\Core\Environment;

    // Composer-based installations: '/path/to/my-project/config/system/settings.php`
    // Legacy installations: '/path/to/my-project/typo3conf/system/settings.php'
    $pathToSetting = Environment::getConfigPath() . 'system/settings.php';

    // Composer-based installations: '/path/to/my-project/config/sites/mysite/config.yaml`
    // Legacy installations: '/path/to/my-project/typo3conf/sites/mysite/config.yaml'
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
folder in legacy installations. This folder contains downloaded translation files.

..  code-block:: php

    use TYPO3\CMS\Core\Core\Environment;

    // Composer-based installations: '/path/to/my-project/var/labels/`
    // Legacy installations: '/path/to/my-project/typo3conf/l10n/'
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
