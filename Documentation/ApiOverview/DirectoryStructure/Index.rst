..  include:: /Includes.rst.txt
..  index::
    ! Path
    see: Directory structure; Path
..  _directory-structure:

===================
Directory structure
===================

The structure below describes the directory structure in a typical
Composer-based TYPO3 installation. For the structure in a legacy installation
see :ref:`Legacy installations: Directory structure <legacy-directory-structure>`.

Also see :ref:`Environment` for further information, especially how to retrieve
the paths within PHP code.


.. _directory-project:

Files on project level
======================

On the top most level, the project level, you can find the files
:file:`composer.json` which contains requirements for the TYPO3 installation
and the :file:`composer.lock` which contains information about the concretely
installed versions of each package.

Directories in a typical project
================================

.. contents::
   :local:

.. _directory-config:

:file:`config/`
---------------

TYPO3 configuration directory. This directory contains installation-wide
configuration.

.. _directory-config-sites:

:file:`config/sites/`
~~~~~~~~~~~~~~~~~~~~~

The folder :file:`config/sites` contains subfolders for each
:ref:`site configuration <sitehandling>`.

.. _directory-local_packages:

:file:`local_packages/`
-----------------------

Each web site which is run on TYPO3 **should** have a sitepackage, an
extension with a special purpose containing all templates, styles, images,
etc. needed for the theme.

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

This folder contains all files that are publicly available. Your webserver's
web root **must** point here.

This folder contains the main entry script :file:`index.php` created by Composer
and might contain publicly available files like a :file:`robots.txt` and
files needed for the server configuration like a :file:`.htaccess`.

If required, this directory can be renamed by setting `extra > typo3/cms > web-dir`
in the composer.json, for example to :file:`web`:

..  code-block:: json
    :caption: composer.json

    {
        "extra": {
            "typo3/cms": {
                "web-dir": "web"
            }
        },
        "...": "..."
    }

This directory contains the following subdirectories:

.. contents::
   :local:

.. _directory-public-_assets:

:file:`public/_assets/`
~~~~~~~~~~~~~~~~~~~~~~~

This directory includes symlinks to the :file:`Resources/Public` folder of extensions, as consequence
of this and further structure changes the folders :file:`typo3conf/ext/` and :file:`typo3/sysext/` are
not created or used anymore.
So all files like CSS, JavaScript, icons, fonts, images, etc. of extensions
are not linked anymore directly to the extension folders but to the directory
:file:`_assets/`.

..  note::
    In TYPO3 v12 using the `typo3/cms-composer-installers` in version
    5 is mandatory. Therefore the publicly available files provided by
    extensions are now always referenced via this directory.

.. _directory-public-fileadmin:

:file:`public/fileadmin/`
~~~~~~~~~~~~~~~~~~~~~~~~~

This is the default directory in which editors store files. Typically images,
PDFs or video files appear in this directory and/or its subdirectories.

Note that this is only the default editor's file storage. This directory
is handled via the :ref:`FAL API <fal>` internally, there may be
further storage locations configured outside of :file:`fileadmin/`, even
pointing to different servers or using 3rd party digital asset management
systems.

.. note::
    This directory is meant for editors! Integrators should
    *not* locate frontend website layout related files in here: Storing
    HTML templates, logos, CSS and similar files used to build the website
    layout in here is considered bad practice. Integrators should locate
    and ship these files within a project specific extension.

.. _directory-public-typo3:

:file:`public/typo3/`
~~~~~~~~~~~~~~~~~~~~~

This directory contains the two PHP files for accessing the TYPO3
backend (:file:`typo3/index.php`) and install tool (:file:`typo3/install.php`).

..  versionchanged:: 12.0
    Starting with TYPO3 v12 (or v11 using `typo3/cms-composer-installers` v4)
    the system extensions are not located in this directory anymore. They can now
    be found in the :ref:`directory-vendor` folder.

.. _directory-public-typo3conf:

:file:`public/typo3conf/`
~~~~~~~~~~~~~~~~~~~~~~~~~

This directory contains the files :file:`LocalConfiguration.php` and
:file:`AdditionalConfiguration.php`. See chapter
:ref:`Configuration files <configuration-files>` for details.

..  versionchanged:: 12.0
    Starting with TYPO3 v12 (or v11 using `typo3/cms-composer-installers` v4)
    the installed extensions are not located in the directory
    :file:`typo3conf/ext/` anymore. They can now be found in the
    :ref:`directory-vendor` folder.

.. _directory-public-typo3temp:

:file:`public/typo3temp/`
~~~~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files. It contains subdirectories (see below)
for temporary files of extensions and TYPO3 components.

.. _directory-public-typo3temp-assets:

:file:`public/typo3temp/assets`
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Directory :file:`typo3temp/assets/` contains temporary files that should be
public available. This includes generated images and compressed CSS and
JavaScript files.

.. _directory-var:

:file:`var/`
------------

Directory for temporary files that contains private files (e.g.
cache and logs files) and should not be publicly available.
See also :ref:`Environment-configuring-paths` for a more detailed description.

.. _directory-var-labels:

:file:`var/labels/`
~~~~~~~~~~~~~~~~~~~

The directory :file:`var/labels/` is for extension localisations. It contains all
downloaded translation files.

This path can be retrieved from the Environment API, see :ref:`Environment-labels-path`.

.. _directory-vendor:

:file:`vendor/`
---------------

In this directory, which lies outside of the webroot, all extensions (system,
third-party and local) are installed as Composer packages.

The directory contains folders for each required vendor and inside each
vendor directory there is a folder with the different project names.

For example the system extension `core` has the complete package name
`typo3/cms-core` and will therefore be installed into the directory
:file:`vendor/typo3/cms-core`. The extension `news`, package name
`georgringer/news` will be installed into the folder
:file:`vendor/georgringer/news`.

Never put or symlink your extensions manually into this directory as they would
not be found. Local extensions and sitepackages should be kept in a separate
folder outside the web root, for example
:ref:`local_packages <directory-local_packages>`. 
Upon installation , Composer creates a symlink from local_packages to 
:file:`vendor/myvendor/my-extension`.

..  toctree::
    :titlesonly:
    :hidden:

    LegacyInstallations
