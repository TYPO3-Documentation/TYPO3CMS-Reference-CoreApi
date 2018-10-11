.. include:: ../../Includes.txt

.. _Environment:

===========
Environment
===========

Since version 9.x the TYPO3 core includes an environment class.
This class contains all environment specific information, e.g. paths within the
filesystem. This implementation replaces previously used global variables and
constants like :php:`PATH_site`.

The fully qualified class name is :php:`\TYPO3\CMS\Core\Core\Environment`. The
class provides static methods to access the necessary information.

Also for testing, the :php:`initialize()` method can be called to adjust the
information.


.. _Environment-project-path:

getProjectPath()
----------------

The environment provides the path to the folder containing the :file:`composer.json`.
For projects without Composer setup, this is equal to :ref:`Environment-public-path`.


.. _Environment-public-path:

getPublicPath()
---------------

The environment provides the path to the public web folder with
:file:`index.php` for TYPO3 frontend. This was previously :php:`PATH_site`.
For projects without Composer setup, this is equal to :ref:`Environment-project-path`.


.. _Environment-var-path:

getVarPath()
------------

The environment provides the path to :file:`var` folder. This folder contains
data like logs, sessions, locks and cache files.

For projects with Composer setup, the value is :php:`getProjectPath() . '/var'`,
so it is outside of the web document root - not within :php:`getPublicPath()`.

Without Composer, the value is :php:`getPublicPath() . '/typo3temp/var'`, so within
the web document root - a situation that is not optimal from a security point of view.


.. _Environment-config-path:

getConfigPath()
---------------

The environment provides the path to :file:`typo3conf`. This folder contains TYPO3
global configuration files and folders, e.g. :file:`LocalConfiguration.php`.

For projects with Composer setup, the value is :php:`getProjectPath() . '/typo3conf'`,
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
