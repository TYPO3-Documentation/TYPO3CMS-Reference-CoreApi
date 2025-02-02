:navigation-title: Classic installation

..  include:: /Includes.rst.txt
..  index::
    Path; Classic installations
    see: Directory structure; Path
..  _legacy-directory-structure:
..  _classic-directory-structure:

==========================================
Classic installations: Directory structure
==========================================

The structure below describes the directory structure in a Classic
TYPO3 installation without Composer. For the structure in a Composer-based installation
see :ref:`Composer-based installations: Directory structure <directory-structure>`.

.. _legacy-directory-project:

Files on project level
======================

The project folder is usually at :file:`/path/to/your/webroot/` (web application root).
It must contain the main entry script :file:`index.php`.
It might contain a file for server configuration like  :file:`.htaccess`.

.. note::

   Further files might be useful depending on the server or the purpose.
   It is for example common to place an authentication file in the web root for a search engine.
   Also different files for server configuration might be possible.

   Note that TYPO3 has the possibility to provide one or more virtual file(s) :file:`robots.txt`.
   This option can be found in the backend module 'Sites' in 'Site Management' and
   is especially advised when different domains shall be hosted in one TYPO3 installation.
   Like this it's possible to provide for each domain an individual :file:`robots.txt`.


Directories in a typical project
================================

.. contents::
   :local:

.. _legacy-directory-fileadmin:

:file:`fileadmin/`
------------------

This is a directory in which editors store files.
It is used for the same files like
:ref:`public/fileadmin/ <directory-public-fileadmin>` in the Composer-based directory
structure.

.. _legacy-directory-typo3:

:file:`typo3/`
--------------

Among others, this directory contains the PHP
file for accessing the install tool (:file:`public/typo3/install.php`).

..  versionchanged:: 14.0
    The TYPO3 backend entry point PHP file :file:`typo3/index.php` has
    been removed. The backend can be accessed via the :ref:`backend-entry-point`.


.. _legacy-directory-typo3-sysext:

:file:`typo3/sysext/`
~~~~~~~~~~~~~~~~~~~~~

All system extensions, supplied by the TYPO3 Core, are stored here.

.. _legacy-directory-typo3_source:

:file:`typo3_source/`
---------------------

It is a common practice in legacy installations to use symlinks to quickly
change between TYPO3 Core versions. In many installations you will find a symlink or folder
called :file:`typo3_source` that contains the folders :ref:`legacy-directory-typo3`,
and :ref:`legacy-directory-vendor` and the file :file:`index.php`. In this case,
those directories and files only symlink to :file:`typo3_source`. This way
the Core can be updated quickly by changing the symlink.

Assuming your webroot is a directory called :file:`public` you could have
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


.. _legacy-directory-typo3conf:

:file:`typo3conf/`
------------------

This path can be retrieved from the Environment API, see
:ref:`Environment-config-path`.

.. _legacy-directory-typo3conf-autoload:

:file:`typo3conf/autoload/`
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Contains :ref:`autoloading <autoload>` information.
The files are updated each time an extension is installed via the
:guilabel:`Extension Manager`.

.. _legacy-directory-typo3conf-ext:

:file:`typo3conf/ext/`
~~~~~~~~~~~~~~~~~~~~~~

Directory for third-party and custom TYPO3 extensions. Each subdirectory
contains one extension. The name of each directory **must** be the extension
key or the extension will not be loaded directly. You can put or symlink
custom extensions and sitepackages here.

See :ref:`extension files locations <extension-files-locations>`
for more information on how the extensions are structured.

.. _legacy-directory-typo3conf-l10n:

:file:`typo3conf/l10n/`
~~~~~~~~~~~~~~~~~~~~~~~

Directory for extension localizations. Contains all downloaded translation
files.

This path can be retrieved from the Environment API, see
:ref:`Environment-labels-path`.

.. _legacy-directory-typo3conf-sites:

:file:`typo3conf/sites/`
~~~~~~~~~~~~~~~~~~~~~~~~

The folder :file:`typo3conf/sites/` contains subfolders for each site.

The following files are processed:

*   :file:`config.yaml` for the :ref:`site configuration <sitehandling>`
*   :file:`settings.yaml` for the :ref:`site settings <sitehandling-settings>`
*   :file:`csp.yaml` for a
    :ref:`site-specific Content Security Policy <content-security-policy-site>`

.. _legacy-directory-typo3conf-system:

:file:`typo3conf/system/`
~~~~~~~~~~~~~~~~~~~~~~~~~

The folder :file:`typo3conf/system/` contains the installation-wide
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
    For legacy installations the configuration files have been moved and
    renamed:

    *   :file:`typo3conf/LocalConfiguration.php` is now available in
        :file:`typo3conf/system/settings.php`
    *   :file:`typo3conf/AdditionalConfiguration.php` is now available in
        :file:`typo3conf/system/additional.php`

.. _legacy-directory-typo3temp:

:file:`typo3temp/`
------------------

Directory for temporary files. It contains subdirectories (see below)
for temporary files of extensions and TYPO3 components.

..  attention::

    Although it is a most common understanding in the TYPO3 world that
    :file:`typo3temp/` can be removed at any time, it is considered
    bad practice to remove the whole folder. Developers should selectively
    remove folders relevant to the changes made.

.. _legacy-directory-typo3temp-assets:

:file:`typo3temp/assets/`
~~~~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files that should be publicly available
(e.g. generated images).

.. _legacy-directory-typo3temp-var:

:file:`typo3temp/var/`
~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files that should not be accessed through the web
(cache, log, etc).

.. _legacy-directory-vendor:

:file:`vendor/`
~~~~~~~~~~~~~~~

This directory contains third-party packages that are required by the
TYPO3 Core.
