.. include:: /Includes.rst.txt
.. index::
   ! Path
   see: Directory structure; Path
.. _directory-structure:

===================
Directory structure
===================

The overview below describes the directory structure in a typical
Composer-based TYPO3 installation. For the structure in a legacy installation
see :ref:`Legacy installations: Directory structure <legacy-directory-structure>`.

Also see :ref:`Environment` for further information, especially how to retrieve
the paths within PHP code.

Files on project level
======================

On the top-most level, the project level, you can find the files
:file:`composer.json` which contains requirements for the TYPO3 installation
and the :file:`composer.lock` which contains information about the concrete
installed versions of each package.

Directories in a typical project
================================

.. contents::
   :local:

.. _directory-config:

:file:`config/`
---------------

TYPO3 configuration directory. This directory
contains installation-wide configuration.

.. _directory-config-sites:

:file:`config/sites/`
~~~~~~~~~~~~~~~~~~~~~

The folder :file:`config/sites` contains
subfolders for each :ref:`site configuration <sitehandling>`.


.. _directory-local_packages:

:file:`local_packages/`
-----------------------

Each web site which is run on TYPO3 **should**
have a sitepackage, an extension with a special purpose containing all
templates, styles, images, etc. needed for the theme.

It is usually stored locally and then symlinked into the :ref:`directory-vendor`
folder. Many projects also need custom extensions that can be stored here.

The folder for local packages has to be defined in the project's :file:`composer.json`
to be used:

..  code-block:: json
    :caption: composer.json

    {
        "name": "myvendor/my-project",
        "repositories": {
            "my_local_packages": {
                "type": "path",
                "url": "local_packages/*"
            }
        },
        "...": "..."
    }

.. _directory-public:

:file:`public/`
---------------

We assume here that your web root points to a folder called :file:`public` in
a Composer-based installation as is commonly done.
Otherwise, replace  :file:`public` with the path to your web root.

..  note::
    If you find a directory called :file:`_assets/` in this directory, you are
    running either :ref:`composer-installer-v4` or
    :ref:`TYPO3 v12 <t3coreapi12:directory-structure>` and above.

.. _directory-public-fileadmin:

:file:`public/fileadmin/`
~~~~~~~~~~~~~~~~~~~~~~~~~

This is a directory in which editors store files. Typically images,
PDFs or video files appear in this directory and/or its subdirectories.

Note this is only the default editor's file storage. This directory
is handled via the :ref:`FAL API <fal>` internally, there may be
further storage locations configured outside of :file:`fileadmin/`, even
pointing to different servers or using 3rd party digital asset management
systems.

..  note::
    This directory is meant for editors! Integrators should
    *not* locate frontend website layout related files in here: Storing
    HTML templates, logos, Css and similar files used to build the website
    layout in here is considered bad practice. Integrators should locate
    and ship these files within a project specific extension.


.. _directory-public-typo3:

:file:`public/typo3/`
~~~~~~~~~~~~~~~~~~~~~

TYPO3 Backend directory. This directory contains most of the files
coming with the TYPO3 Core. The files are arranged logically in the
different system extensions in the :file:`sysext/` directory,
according to the application area of the particular file. For example,
the ":code:`frontend`" extension amongst other things contains the
"TypoScript library", the code for generating the Frontend website. In
each system extension the PHP files are located in the folder
:file:`Classes/`. See :ref:`extension files locations <extension-files-locations>`
for more information on how single extensions are structured.

..  note::
    If you cannot find the TYPO3 Core source in the directory
    :file:`public/typo3/sysext/` you are running either :ref:`composer-installer-v4` or
    :ref:`TYPO3 v12 <t3coreapi12:directory-structure>` and above.

.. _directory-public-typo3conf:

:file:`public/typo3conf/`
~~~~~~~~~~~~~~~~~~~~~~~~~

Amongst others, this directory contains the files :file:`LocalConfiguration.php` and
:file:`AdditionalConfiguration.php`. See chapter
:ref:`Configuration files <configuration-files>` for details.

.. _directory-public-typo3conf-ext:

:file:`public/typo3conf/ext/`
"""""""""""""""""""""""""""""

Directory for third-party and custom TYPO3 extensions. Each subdirectory
contains one extension.

..  note::
    If you cannot find the directory called :file:`public/typo3conf/ext/` you are
    running either :ref:`composer-installer-v4` or
    :ref:`TYPO3 v12 <t3coreapi12:directory-structure>` and above.

.. _directory-public-typo3temp:

:file:`public/typo3temp/`
~~~~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files. It contains subdirectories (see below)
for temporary files of extensions and TYPO3 components.

.. _directory-public-typo3temp-assets:

:file:`public/typo3temp/assets/`
""""""""""""""""""""""""""""""""

Directory for temporary files that should be public available
(e.g. generated images).

.. _directory-var:

:file:`var/`
------------

Directory for temporary files that contains private files (e.g.
cache and logs files) and should not be publicly available.
See also :ref:`Environment-configuring-paths` for a more detailed description.

.. _directory-var-cache:

:file:`var/cache/`
~~~~~~~~~~~~~~~~~~~

This directory contains internal files needed for the cache.

.. _directory-var-labels:

:file:`var/labels/`
~~~~~~~~~~~~~~~~~~~

The directory :file:`var/labels/` is for extension
localizations. It contains all downloaded translation files.

This path can be retrieved from the Environment API, see
:ref:`Environment-labels-path`.

.. _directory-var-log:

:file:`var/log/`
~~~~~~~~~~~~~~~~~~~

This directory contains log files like the
TYPO3 log, the deprecations log and logs generated by extensions.

.. _directory-vendor:

:file:`vendor/`
---------------

In this directory, which lies outside of
the webroot, third-party dependencies that are not TYPO3 extensions are
installed.

If optional :ref:`Composer installers v4 <composer-installer-v4>`
is used, TYPO3 extensions are also installed here.

.. _composer-installer-v4:

TYPO3 v11 with Composer installers v4
=====================================

The Composer plugin `typo3/cms-composer-installers` in version 4+ was created
for TYPO3 version 12 and back-ported for **optional usage**
in TYPO3 version 11. Therefore the version has to be explicitly set
if the new directory structure shall already be used:

.. code-block:: bash

   composer req typo3/cms-composer-installers:"^4.0@dev"

If the Composer installers v4 is used the directory structure of the TYPO3
project is similar to the :ref:`directory structure of TYPO3
v12 <t3coreapi12:directory-structure>`.

Most notably public assets provided by extensions will be available in
:ref:`directory-public-assets`

.. _directory-public-assets:

:file:`public/_assets/` (Composer installer v4)
-----------------------------------------------

This directory includes symlinks to public resources of extensions, as consequence
of this and further structure changes the folder :file:`typo3conf/ext/` is
not created or used anymore.
So all files like CSS, JavaScript, Icons, Fonts, Images, etc. of extensions
which are stored in the folder :file:`Resources/Public/` are not available anymore directly to the extension folders but linked into the directory
:file:`_assets/`.

.. _directory-vendor-installer-v4:

:file:`vendor/` (Composer installer v4)
---------------------------------------

In this directory, which lies outside of
the webroot, all extensions (system, third-party and custom) are installed
as Composer packages.

The directory contains folders for each required vendor and inside each
vendor directory there is a folder with the different project names.

For example the system extension `core` has the complete package name
`typo3/cms-core` and will therefore be installed into the directory
:file:`vendor/typo3/cms-core`. The extension `news`, package name
`georgringer/news` will be installed into the folder
:file:`vendor/georgringer/news`.

Never put or symlink your extensions manually into this directory as it is
managed by Composer and any manual changes are getting lost,
for example on deployment. Local extensions and sitepackages
should be kept in a separate folder outside the web root, for example
:ref:`local_packages <directory-local_packages>`.
Upon installation , Composer creates a symlink from local_packages to
:file:`vendor/myvendor/my-extension`.

..  toctree::
    :titlesonly:
    :hidden:

    LegacyInstallations
