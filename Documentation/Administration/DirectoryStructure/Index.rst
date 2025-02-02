.. include:: /Includes.rst.txt
.. index::
   ! Path
   see: Directory structure; Path
.. _directory-structure:

===================
Directory structure
===================

The overview below describes the directory structure in a typical
Composer-based TYPO3 installation. For the structure in a Classic installation
see :ref:`Classic installations: Directory structure <classic-directory-structure>`.

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

The folder :file:`config/sites/` contains subfolders for each site.

The following files are processed:

*   :file:`config.yaml` for the :ref:`site configuration <sitehandling>`
*   :file:`settings.yaml` for the :ref:`site settings <sitehandling-settings>`
*   :file:`csp.yaml` for a
    :ref:`site-specific Content Security Policy <content-security-policy-site>`


.. _directory-config-system:

:file:`config/system/`
~~~~~~~~~~~~~~~~~~~~~~

The folder :file:`config/system/` contains the installation-wide
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
    For Composer-based installations the configuration files have been moved and
    renamed:

    *   :file:`public/typo3conf/LocalConfiguration.php` is now available in
        :file:`config/system/settings.php`
    *   :file:`public/typo3conf/AdditionalConfiguration.php` is now available
        in :file:`config/system/additional.php`

.. _directory-packages:

:file:`packages/`
-----------------

If you installed TYPO3 using the base distribution `composer create "typo3/cms-base-distribution"`
this folder is automatically created and registered as repository in the the :file:`composer.json`.

You can put your site package and other extensions to be installed locally here. Then you can just
install the extension with `composer install myvendor/my-sitepackage`.

If you did not use the base-distribution, create the directory and add it to your repositories
manualy:

..  code-block:: diff
    :caption: composer.json (diff)

      {
         "name": "myvendor/my-project",
         "repositories": [
     +       {
     +           "type": "path",
     +           "url": "packages/*"
             }
         ],
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

.. _directory-public-assets:

:file:`public/_assets/`
~~~~~~~~~~~~~~~~~~~~~~~

This directory includes symlinks to resources of extensions (stored in the
:file:`Resources/Public/` folder), as consequence of this and further structure
changes the folder :file:`typo3conf/ext/` is not created or used anymore.
So all files like CSS, JavaScript, icons, fonts, images, etc. of extensions
are not referenced anymore directly to the extension folders but to the
directory :file:`_assets/`.

..  note::
    TYPO3 v12 requires `typo3/cms-composer-installers` in version
    5. Therefore the publicly available files provided by
    extensions are now always referenced via this directory.

..  tip::
    When creating an extension without a :file:`Resources/Public/` folder, the
    corresponding :file:`_assets/` folder for that extension can not be symlinked
    as the extension's :file:`Resources/Public/` folder does not exist. When you
    create it later after the installation of the extension, run a
    :bash:`composer dumpautoload` and the :file:`Resources/Public/` folder for
    that extension is symlinked to :file:`_assets/`.

..  todo:: This may be fixed/addressed with this issue: https://review.typo3.org/c/Packages/TYPO3.CMS/+/84383

..  warning::
    The :file:`_assets/` directory is not meant to be manually changed. Also, it
    is important for local development that all its subdirectories are symlinks
    to the specific Composer packages. Do not synchronize this directory
    from a production instance back to your development instance (only the other
    way round). Thus, the whole :file:`_assets/` directory should always be removable and
    can be re-created with proper contents via :bash:`composer dumpautoload`.
    This will create symlinks for all installed TYPO3 Composer packages containing public
    assets.

    If the :file:`_assets/` directory would not contain symlinks, any Composer update
    would never refer to updated versions of any JavaScript and CSS assets
    (including TYPO3 backend system extension), leading to incompatible code
    being loaded and causing errors in both backend and frontend.

..  seealso::

    -   :ref:`<migrate-public-assets>`
    -   `TYPO3 and Composer — we've come a long way <https://b13.com/core-insights/typo3-and-composer-weve-come-a-long-way>`__
    -   `Composer changes for TYPO3 v11 and v12 <https://usetypo3.com/composer-changes-for-typo3-v11-and-v12.html>`__
    -   `Migration to typo3/composer-cms-installers version 4+ <https://brotkrueml.dev/migration-typo3-composer-cms-installers-version-4/>`__


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

Depending on the configuration in
:ref:`$GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir'] <typo3ConfVars_be_fileadminDir>`
another folder name than :file:`fileadmin/` can be in use.

..  note::
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

.. _directory-public-typo3temp:

:file:`public/typo3temp/`
~~~~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files. It contains subdirectories (see below)
for temporary files of extensions and TYPO3 components.

..  attention::

    Although it is a most common understanding in the TYPO3 world that
    :file:`public/typo3temp/` can be removed at any time, it is considered
    bad practice to remove the whole folder. Developers should selectively
    remove folders relevant to the changes made.

.. _directory-public-typo3temp-assets:

:file:`public/typo3temp/assets/`
""""""""""""""""""""""""""""""""

The directory :file:`typo3temp/assets/` contains temporary files that should be
public available. This includes generated images and compressed CSS and
JavaScript files.

.. _directory-var:

:file:`var/`
------------

Directory for temporary files that contains private files (e.g.
cache and logs files) and should not be publicly available.

..  attention::

    Although it is a most common understanding in the TYPO3 world that
    :file:`var/` can be removed at any time, it is considered
    bad practice to remove the whole folder. Developers should selectively
    remove folders relevant to the changes made.

.. _directory-var-cache:

:file:`var/cache/`
~~~~~~~~~~~~~~~~~~

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
~~~~~~~~~~~~~~~~

This directory contains log files like the
TYPO3 log, the deprecations log and logs generated by extensions.

.. _directory-vendor:

:file:`vendor/`
---------------

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
:ref:`packages <directory-packages>`.
Upon installation , Composer creates a symlink from packages to
:file:`vendor/myvendor/my-extension`.


..  toctree::
    :titlesonly:
    :hidden:

    ClassicInstallations
