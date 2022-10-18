..  include:: /Includes.rst.txt
..  index::
    Path; Legacy installations
    see: Directory structure; Path
..  _legacy-directory-structure:

=========================================
Legacy installations: Directory structure
=========================================

The structure below describes the directory structure in a legacy
TYPO3 installation without Composer. For the structure in a Composer-based installation
see :ref:`Composer-based installations: Directory structure <directory-structure>`.

.. _legacy-directory-project:

Files on project level
======================

This folder contains the main entry script :file:`index.php` and might contain
publicly available files like a :file:`robots.txt` and files needed for the
server configuration like a :file:`.htaccess` file.

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

Among others, this directory contains the two PHP files for accessing the TYPO3
backend (:file:`typo3/index.php`) and install tool (:file:`typo3/install.php`).


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

Contains subfolders for each :ref:`site configuration <sitehandling>`.

.. _legacy-directory-typo3conf-system:

:file:`typo3conf/system/`
~~~~~~~~~~~~~~~~~~~~~~~~~

The folder :file:`typo3conf/system/` contains the
:ref:`Configuration files <configuration-files>` :file:`typo3conf/system/settings.php`
and :file:`typo3conf/system/additional.php`.

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
