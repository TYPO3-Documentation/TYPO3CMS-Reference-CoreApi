..  include:: /Includes.rst.txt
..  index::
    Path; Legacy installations
    see: Directory structure; Path
..  _legacy-directory-structure:

=========================================
Legacy installations: Directory structure
=========================================

.. _legacy-directory-project:

Files on project level
======================

This folder contains the main entry script :file:`index.php` and might contain
publicly available files like a :file:`robots.txt` and files needed for the
server configuration like a :file:`.htaccess`.


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

All system extensions, supplied by the TYPO3 Core, are stored here.  For example,
the `frontend` extension amongst other things contains the
"TypoScript library", the code for generating the website. In
each system extension the PHP files are located in the folder
:file:`Classes/`. See :ref:`extension files locations <extension-files-locations>`
for more information on how single extensions are structured.

In Composer-based installations the entry PHP files can be found in the directory
:ref:`public/typo3/ <directory-public-typo3>` all other files mentioned here
in the directory :ref:`vendor/ <directory-vendor>`.

.. _legacy-directory-typo3conf:

:file:`typo3conf/`
------------------

Amongst others, this directory contains the files :file:`LocalConfiguration.php` and
:file:`AdditionalConfiguration.php`. See chapter
:ref:`Configuration files <configuration-files>` for details.

This path can be retrieved from the Environment API, see :ref:`Environment-config-path`.

.. _legacy-directory-typo3conf-ext:

:file:`typo3conf/ext/`
~~~~~~~~~~~~~~~~~~~~~~

Directory for local TYPO3 extensions. Each subdirectory contains one extension.

In Composer-based installations the extensions are installed
in the directory :ref:`vendor/ <directory-vendor>`.

.. _legacy-directory-typo3conf-l10n:

:file:`typo3conf/l10n`
~~~~~~~~~~~~~~~~~~~~~~

Directory for extension localisations. Contains all downloaded translation
files.

This path can be retrieved from the Environment API, see
:ref:`Environment-labels-path`.

In Composer-based installations the localisations can be found in
in the directory :ref:`var/labels/ <directory-var-labels>`.

.. _legacy-directory-typo3temp:

:file:`typo3temp/`
------------------

Directory for temporary files. It contains subdirectories (see below)
for temporary files of extensions and TYPO3 components.

In Composer-based installations public temporary files can be found in
in the directory :ref:`public/typo3temp/ <directory-public-typo3temp>`.

.. _legacy-directory-typo3temp-assets:

:file:`typo3temp/assets/`
~~~~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files that should be publicly available
(e.g. generated images).

.. _legacy-directory-typo3temp-var:

:file:`typo3temp/var/`
~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files that contains private files (e.g. cached
Fluid templates) and should not be publicly available.
See also :ref:`Environment-configuring-paths` for a more detailed description.

In Composer-based installations private temporary files can be found in
in the directory :ref:`var/ <directory-var>`.
