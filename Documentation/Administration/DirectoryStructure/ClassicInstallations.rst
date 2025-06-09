:navigation-title: Classic mode installation

..  include:: /Includes.rst.txt
..  index::
    Path; Classic mode installations
    see: Directory structure; Path
..  _legacy-directory-structure:
..  _classic-directory-structure:

===============================================
Classic mode installations: Directory structure
===============================================

The structure below describes the directory layout of a Classic TYPO3 installation
(without Composer), sometimes also called a legacy installation.

..  figure:: /Images/ManualScreenshots/Backend/ClassicMode.png
    :alt: The TYPO3 backend Extension Manager in Classic Mode: Buttons "Upload Extension" and "Deactivate" for some extensions are visible

    If the "Upload Extension" button is visible, TYPO3 is running in Classic mode.

..  contents:: Table of contents
    :depth: 1

..  seealso::

    *   `Composer mode: Directory structure <https://docs.typo3.org/permalink/t3coreapi:directory-structure-composer>`_
        for details on the structure in a Composer-based installation.

..  _classic-directory-project:
..  _legacy-directory-project:

Files on project level
======================

The project folder, usually at :path:`/path/to/your/webroot/`, must contain
:file:`index.php`. It may also include server config files like :file:`.htaccess`.

Additional files that should be available at the root of you web site like
:file:`robots.txt` can be placed here in single site installations.

In multi-site installations you should use
`Static routes <https://docs.typo3.org/permalink/t3coreapi:sitehandling-staticroutes>`_
in the site configuration to provide individualized files for each site.

..  _legacy-directory-directory:

Directories in a typical project
================================

..  contents::
   :local:

..  _classic-directory-fileadmin:
..  _legacy-directory-fileadmin:

:path:`fileadmin/`
------------------

This is a directory in which editors store files.
It is used for the same files like
:ref:`public/fileadmin/ <directory-public-fileadmin>` in the Composer-based directory
structure.

..  _classic-directory-typo3:
..  _legacy-directory-typo3:

:path:`typo3/`
--------------

Among others, this directory contains the two PHP files for accessing the TYPO3
backend (:file:`typo3/index.php`) and install tool (:file:`typo3/install.php`).

..  _classic-directory-typo3-sysext:
..  _legacy-directory-typo3-sysext:

:path:`typo3/sysext/`
~~~~~~~~~~~~~~~~~~~~~

All system extensions, supplied by the TYPO3 Core, are stored here.

..  _classic-directory-typo3_source:
..  _legacy-directory-typo3_source:

:path:`typo3_source/`
---------------------

It is a common practice in Classic mode installations to use symlinks to quickly
change between TYPO3 Core versions. In many installations you will find a symlink or folder
called :path:`typo3_source` that contains the folders :ref:`classic-directory-typo3`,
and :ref:`classic-directory-vendor` and the file :file:`index.php`. In this case,
those directories and files only symlink to :path:`typo3_source`. This way
the Core can be updated quickly by changing the symlink.

Assuming your webroot is a directory called :path:`public` you could have
the following symlink structure:

*   typo3_src-12.0.0

    *   typo3
    *   vendor
    *   index.php

*   public

    *   fileadmin
    *   typo3 -> typo3_src/typo3
    *   typo3_src -> ../typo3_src-12.0.0
    *   typo3conf
    *   typo3temp
    *   vendor ->  typo3_src/vendor
    *   index.php -> typo3_src/index.php


..  _classic-directory-typo3conf:
..  _legacy-directory-typo3conf:

:path:`typo3conf/`
------------------

This path can be retrieved from the Environment API, see
:ref:`Environment-config-path`.

..  _classic-directory-typo3conf-autoload:
..  _legacy-directory-typo3conf-autoload:

:path:`typo3conf/autoload/`
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Contains :ref:`autoloading <autoload>` information.
The files are updated each time an extension is installed via the
:guilabel:`Extension Manager`.

..  _classic-directory-typo3conf-ext:
..  _legacy-directory-typo3conf-ext:

:path:`typo3conf/ext/`
~~~~~~~~~~~~~~~~~~~~~~

Directory for third-party and custom TYPO3 extensions. Each subdirectory
contains one extension. The name of each directory **must** be the extension
key or the extension will not be loaded directly. You can put or symlink
custom extensions and sitepackages here.

See :ref:`extension files locations <extension-files-locations>`
for more information on how the extensions are structured.

..  _classic-directory-typo3conf-l10n:
..  _legacy-directory-typo3conf-l10n:

:path:`typo3conf/l10n/`
~~~~~~~~~~~~~~~~~~~~~~~

Directory for extension localizations. Contains all downloaded translation
files.

This path can be retrieved from the Environment API, see
:ref:`Environment-labels-path`.

..  _classic-directory-typo3conf-sites:
..  _legacy-directory-typo3conf-sites:

:path:`typo3conf/sites/`
~~~~~~~~~~~~~~~~~~~~~~~~

The folder :path:`typo3conf/sites/` contains subfolders, one for each site
in the installation. See chapter :ref:`site-folder`.

..  _classic-directory-typo3conf-system:
..  _legacy-directory-typo3conf-system:

:path:`typo3conf/system/`
~~~~~~~~~~~~~~~~~~~~~~~~~

The folder :path:`typo3conf/system/` contains the installation-wide
:ref:`configuration files <configuration-files>`:

*   :file:`settings.php`: :ref:`Configuration <typo3ConfVars-settings>` written
    by the :guilabel:`Admin Tools > Settings` backend module
*   :file:`additional.php`: :ref:`Manually created file <typo3ConfVars-additional>`
    which can override settings from :file:`settings.php` file

These files define a set of global settings stored in a global array called
:ref:`$GLOBALS['TYPO3_CONF_VARS'] <typo3ConfVars>`.

This path can be retrieved from the Environment API, see
:ref:`Environment-config-path`.

..  versionchanged:: 12.0
    For Classic mode installations the configuration files have been moved and
    renamed:

    *   :file:`typo3conf/LocalConfiguration.php` is now available in
        :file:`typo3conf/system/settings.php`
    *   :file:`typo3conf/AdditionalConfiguration.php` is now available in
        :file:`typo3conf/system/additional.php`

..  _classic-directory-typo3temp:
.. _legacy-directory-typo3temp:

:path:`typo3temp/`
------------------

Directory for temporary files. It contains subdirectories (see below)
for temporary files of extensions and TYPO3 components.

..  attention::

    Although it is a most common understanding in the TYPO3 world that
    :path:`typo3temp/` can be removed at any time, it is considered
    bad practice to remove the whole folder. Developers should selectively
    remove folders relevant to the changes made.

..  _classic-directory-typo3temp-assets:
..  _legacy-directory-typo3temp-assets:

:path:`typo3temp/assets/`
~~~~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files that should be publicly available
(e.g. generated images).

..  _classic-directory-typo3temp-var:
..  _legacy-directory-typo3temp-var:

:path:`typo3temp/var/`
~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files that should not be accessed through the web
(cache, log, etc).

..  _classic-directory-vendor:
..  _legacy-directory-vendor:

:path:`vendor/`
~~~~~~~~~~~~~~~

This directory contains third-party packages that are required by the
TYPO3 Core.
