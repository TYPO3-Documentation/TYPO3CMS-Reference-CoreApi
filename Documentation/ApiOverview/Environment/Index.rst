.. include:: ../../Includes.txt

.. _Environment:

===========
Environment
===========

Since version 9.x the TYPO3 CMS core includes an environment class.
This class contains all environment specific information, e.g. paths within the
filesystem. This implementation replaces previously used global variables and
constants like :php:`PATH_site`.

The fully qualified class name is :php:`\TYPO3\CMS\Core\Core\Environment`. The
class provides static methods to access the necessary information.

Also for testing, the :php:`initialize()` method can be called to adjust the
information.

.. _Environment-project-path:

project path
------------

The environment provides the path to the folder containing the
:file:`composer.json`, or public web folder for non composer projects.

The path is available through :php:`getProjectPath()` method.

.. _Environment-public-path:

public path
-----------

The environment provides the path to the public web folder with
:file:`index.php` for TYPO3 frontend. This was previously :php:`PATH_site`.

For non composer setups, this is equal to :ref:`Environment-project-path`.

The path is available through :php:`getPublicPath()` method.

.. _Environment-var-path:

var path
--------

The environment provides the path to :file:`var` folder. This folder contains
data like logs, sessions, locks and cache files.

The folder is, by default, :file:`typo3temp/var` for setups where the project
path is equal to public path, e.g. "classic" installation without composer.

For setups where project path and public path are not equal, the default is
:file:`$projectPath/var`. This way these files are not available to the public.

The path is available through :php:`getVarPath()` method.

.. _Environment-config-path:

config path
-----------

The environment provides the path to :file:`typo3conf`. This folder contains all
TYPO3 global configuration files and folders, e.g. :file:`LocalConfiguration.php`.

The folder is, by default, :file:`typo3conf` for setups where the project
path is equal to public path, e.g. "classic" installation without composer.

For setups where project path and public path are not equal, the default is
:file:`$projectPath/config`. This way these files are not available to the
public. See :ref:`Environment-project-path`.

The path is available through :php:`getConfigPath()` method.

.. _Environment-labels-path:

labels path
-----------

The environment provides the path to :file:`labels`, respective :file:`l10n`
folder. This folder contains downloaded translation files.

The folder is, by default, :file:`typo3temp/l10n` for setups where the project
path is equal to public path, e.g. "classic" installation without composer.

For setups where project path and public path are not equal, the default is
:file:`$varPath/labels`. This way these files are not available to the public.
See :ref:`Environment-var-path`.

The path is available through :php:`getLabelsPath()` method.
