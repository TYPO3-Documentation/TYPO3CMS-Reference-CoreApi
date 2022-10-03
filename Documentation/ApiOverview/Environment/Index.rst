.. include:: /Includes.rst.txt
.. index:: ! Environment
.. _Environment:

===========
Environment
===========

This class contains all environment-specific information, including paths within the
filesystem.

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

The method provides the path to the :ref:`top most directory <directory-project>`
containing the project's :file:`composer.json` file.

For legacy installations, this is equal to :ref:`Environment-public-path`.

.. index::
   Environment; getPublicPath
   PATH_site
.. _Environment-public-path:

getPublicPath()
---------------

The method provides the path to the :ref:`public web folder <directory-public>`
with :file:`index.php` for the TYPO3 frontend.

For legacy installations it point to the
:ref:`project directory <legacy-directory-project>`, this is equal to
:ref:`Environment-project-path`.

.. index::
   Environment; getVarPath
   Path; var
   Path; typo3temp/var
.. _Environment-var-path:

getVarPath()
------------

The method provides the path to the :ref:`var <directory-var>` folder.
This directory contains private temporary files like logs, sessions, locks,
and cache files.

For projects with Composer setup, the value is :php:`getProjectPath() . '/var'`,
so it is outside of the web document root - not within :php:`getPublicPath()`.

In legacy installations, the value is :php:`getPublicPath() . '/typo3temp/var'`, so within
the web document root - a situation that is not optimal from a security point of view.

.. index::
   Environment; getConfigPath
   Path; typo3conf
.. _Environment-config-path:

getConfigPath()
---------------

The environment provides the path to :file:`typo3conf`. This folder contains TYPO3
global configuration files and folders, e.g. :file:`LocalConfiguration.php`.

For projects with Composer setup, the value is :php:`getProjectPath() . '/config'`,
so it is outside of the web document root - not within :php:`getPublicPath()`.

Without Composer, the value is :php:`getPublicPath() . '/typo3conf'`, so within
the web document root - a situation that is not optimal from a security point of view.


.. index::
   Environment; getConfigPath
   Path; var/labels
   Path; typo3conf/l10n
.. _Environment-labels-path:

getLabelsPath()
---------------

The method provides the path to :ref:`var/labels/ <directory-var-labels>`,
folder. This folder contains downloaded translation files.

For projects with Composer setup, the value is :php:`getVarPath() . '/labels'`,
so it is outside of the web document root - not within :php:`getPublicPath()`.

In legacy installations it returns the path to :ref:`typo3conf/l10n/
<legacy-directory-typo3conf-l10n>`, which is located in the web document root.

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
   :caption: typo3conf/AdditionalConfiguration.php

   // use \TYPO3\CMS\Core\Core\Environment;

   $applicationContext = Environment::getContext();
   if ($applicationContext->isProduction()) {
      // do something only when in production context
   }
