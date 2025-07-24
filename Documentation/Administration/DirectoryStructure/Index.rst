:navigation-title: Directory structure

..  include:: /Includes.rst.txt
..  index::
    ! Path
    see: Directory structure; Path
..  _directory-structure:

==============================================
Directory structure of a typical TYPO3 project
==============================================

The typical directory structure of a TYPO3 installation differs fundamentally
between Composer mode and Classic mode. It can also vary depending on the TYPO3
version. Use the version switch to select the correct documentation version.

This structural difference remains even when deploying TYPO3 to a production
server without Composer, and without deploying :file:`composer.json` or
:file:`composer.lock`. To make matters more confusing, the presence of these
files **does not** guarantee that TYPO3 is running in Composer mode.

..  figure:: /Images/ManualScreenshots/Backend/ComposerMode.png
    :alt: The TYPO3 backend Extension Manager with message "Composer mode: The system is set to composer mode. Please notice that this list is for informational purpose only. To modify which extensions are part of the system, use Composer. To set extensions up, use the TYPO3 cli (extension:setup)"

    This info box in the Extension Manager confirms the installation is running
    in Composer mode.

..  contents:: Table of contents
    :depth: 1

.. seealso::

    If your installation is running in Classic mode (also called Non-Composer or
    Legacy mode), see the following for details on the directory structure:

    *   `Classic mode installations: Directory structure <https://docs.typo3.org/permalink/t3coreapi:classic-directory-structure>`_


..  _directory-structure-composer:

Directories in a typical Composer mode TYPO3 project
====================================================

The overview below describes the directory structure of a typical
Composer-based TYPO3 installation.

Also see the chapter :ref:`Environment` for details on how to retrieve paths in
PHP code.

..  note::

    Most paths listed here are configurable, as TYPO3 is highly flexible.

    Depending on the `deployment method <https://docs.typo3.org/permalink/t3coreapi:deployment>`_,
    especially in `CI/CD automation setups <https://docs.typo3.org/permalink/t3coreapi:ci-cd-for-typo3-projects>`_,
    symbolic links may be used in place of actual directories.

..  contents::
    :local:

..  _directory-config:

:path:`config/`
---------------

TYPO3 configuration directory. This directory
contains folder :path:`config/system/` for installation-wide configuration and
:path:`config/sites/` for the site configuration and
`Site settings <https://docs.typo3.org/permalink/t3coreapi:sitehandling-settings>`_.

..  _directory-config-sites:

:path:`config/sites/`
~~~~~~~~~~~~~~~~~~~~~

The folder :path:`config/sites/` contains subfolders, one for each site
in the installation. See chapter :ref:`site-folder`.

..  _directory-config-system:

:path:`config/system/`
~~~~~~~~~~~~~~~~~~~~~~

The folder :path:`config/system/` contains the installation-wide
:ref:`configuration files <configuration-files>`:

*   :path:`settings.php`: :ref:`Configuration <typo3ConfVars-settings>` written
    by the :guilabel:`Admin Tools > Settings` backend module
*   :file:`additional.php`: :ref:`Manually created file <typo3ConfVars-additional>`
    which can override settings from :file:`settings.php` file

These files define a set of global settings stored in a global array called
:ref:`$GLOBALS['TYPO3_CONF_VARS'] <typo3ConfVars>`.

This path can be retrieved from the Environment API, see
:ref:`Environment-config-path`.

..  _directory-packages:

:file:`packages/`
-----------------

If you installed TYPO3 using the base distribution `composer create "typo3/cms-base-distribution"`
this folder is automatically created and registered as repository in the the :path:`composer.json`.

You can put your site package and other extensions to be installed locally here. Then you can just
install the extension with `composer install myvendor/my-sitepackage`.

If you did not use the base-distribution, create the directory and add it to your repositories
manually:

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

..  _directory-public:

:path:`public/`
---------------

This folder contains all files that are publicly available. Your webserver's
web root **must** point here.

This folder contains the main entry script :file:`index.php` created by Composer
and might contain publicly available files like a :file:`robots.txt` and
files needed for the server configuration like a :file:`.htaccess`.

If required, this directory can be renamed by setting `extra > typo3/cms > web-dir`
in the composer.json, for example to :path:`web`:

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

..  _directory-public-assets:

:path:`public/_assets/`
~~~~~~~~~~~~~~~~~~~~~~~

This directory includes symlinks to resources of extensions (stored in the
:path:`Resources/Public/` folder), as consequence of this and further structure
changes the folder :path:`typo3conf/ext/` is not created or used anymore.
So all files like CSS, JavaScript, icons, fonts, images, etc. of extensions
are not referenced anymore directly to the extension folders but to the
directory :path:`_assets/`.

..  note::
    TYPO3 v12 requires `typo3/cms-composer-installers` in version
    5. Therefore the publicly available files provided by
    extensions are now always referenced via this directory.

..  tip::
    When creating an extension without a :path:`Resources/Public/` folder, the
    corresponding :path:`_assets/` folder for that extension can not be symlinked
    as the extension's :path:`Resources/Public/` folder does not exist. When you
    create it later after the installation of the extension, run a
    :bash:`composer dumpautoload` and the :path:`Resources/Public/` folder for
    that extension is symlinked to :path:`_assets/`.

..  todo:: This may be fixed/addressed with this issue: https://review.typo3.org/c/Packages/TYPO3.CMS/+/84383

..  warning::
    The :path:`_assets/` directory is not meant to be manually changed. Also, it
    is important for local development that all its subdirectories are symlinks
    to the specific Composer packages. Do not synchronize this directory
    from a production instance back to your development instance (only the other
    way round). Thus, the whole :path:`_assets/` directory should always be removable and
    can be re-created with proper contents via :bash:`composer dumpautoload`.
    This will create symlinks for all installed TYPO3 Composer packages containing public
    assets.

    If the :path:`_assets/` directory would not contain symlinks, any Composer update
    would never refer to updated versions of any JavaScript and CSS assets
    (including TYPO3 backend system extension), leading to incompatible code
    being loaded and causing errors in both backend and frontend.

..  seealso::

    *   :ref:`<migrate-public-assets>`
    *   `TYPO3 and Composer — we've come a long way <https://b13.com/core-insights/typo3-and-composer-weve-come-a-long-way>`__
    *   `Composer changes for TYPO3 v11 and v12 <https://usetypo3.com/composer-changes-for-typo3-v11-and-v12.html>`__
    *   `Migration to typo3/composer-cms-installers version 4+ <https://brotkrueml.dev/migration-typo3-composer-cms-installers-version-4/>`__


..  _directory-public-fileadmin:

:path:`public/fileadmin/`
~~~~~~~~~~~~~~~~~~~~~~~~~

This is a directory in which editors store files. Typically images,
PDFs or video files appear in this directory and/or its subdirectories.

Note this is only the default editor's file storage. This directory
is handled via the :ref:`FAL API <fal>` internally, there may be
further storage locations configured outside of :path:`fileadmin/`, even
pointing to different servers or using 3rd party digital asset management
systems.

Depending on the configuration in
:ref:`$GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir'] <typo3ConfVars_be_fileadminDir>`
another folder name than :path:`fileadmin/` can be in use.

..  note::
    This directory is meant for editors! Integrators should
    *not* locate frontend website layout related files in here: Storing
    HTML templates, logos, CSS and similar files used to build the website
    layout in here is considered bad practice. Integrators should locate
    and ship these files within a project specific extension.


..  _directory-public-typo3:

:path:`public/typo3/`
~~~~~~~~~~~~~~~~~~~~~

If :composer:`typo3/cms-install` is installed, this directory contains the PHP
file for accessing the install tool (:file:`public/typo3/install.php`).

..  versionchanged:: 14.0
    The TYPO3 backend entry point PHP file :file:`public/typo3/index.php` has
    been removed. The backend can be accessed via the :ref:`backend-entry-point`.

..  _directory-public-typo3temp:

:path:`public/typo3temp/`
~~~~~~~~~~~~~~~~~~~~~~~~~

Directory for temporary files. It contains subdirectories (see below)
for temporary files of extensions and TYPO3 components.

..  attention::

    **Do not delete the entire** :path:`public/typo3temp/` **directory.**  

    Removing the entire directory may lead to problems during runtime or deployment.
    
    Developers should only delete specific subfolders that are safe to remove  
    and can be regenerated automatically.
    
    For proper handling and steps to safely regenerate required subdirectories,  
    see: :ref:`typo3temp-regeneration-guide` (section to be written)

..  _directory-public-typo3temp-assets:

:path:`public/typo3temp/assets/`
""""""""""""""""""""""""""""""""

The directory :path:`typo3temp/assets/` contains temporary files that should be
public available. This includes generated images and compressed CSS and
JavaScript files.

..  _directory-var:

:path:`var/`
------------

Directory for temporary files that contains private files (e.g.
cache and logs files) and should not be publicly available.

..  attention::

    **Do not delete the entire** :path:`var/` **directory.**  

    Removing the entire directory may lead to problems during runtime or deployment.
    
    Developers should only delete specific subfolders that are relevant to the  
    changes they have made and that can be safely regenerated.
    
    For more information and instructions on safely handling this directory, see:  
    :ref:`regeneration-temporary-folders`.

..  _directory-var-cache:

:path:`var/cache/`
~~~~~~~~~~~~~~~~~~

This directory contains internal files needed for the cache.

..  _directory-var-labels:

:path:`var/labels/`
~~~~~~~~~~~~~~~~~~~

The directory :path:`var/labels/` is for extension
localizations. It contains all downloaded translation files.

This path can be retrieved from the Environment API, see
:ref:`Environment-labels-path`.

..  _directory-var-log:

:path:`var/log/`
~~~~~~~~~~~~~~~~

This directory contains log files like the
TYPO3 log, the deprecations log and logs generated by extensions.

..  _directory-vendor:

:path:`vendor/`
---------------

In this directory, which lies outside of
the webroot, all extensions (system, third-party and custom) are installed
as Composer packages.

The directory contains folders for each required vendor and inside each
vendor directory there is a folder with the different project names.

For example the system extension `core` has the complete package name
`typo3/cms-core` and will therefore be installed into the directory
:path:`vendor/typo3/cms-core`. The extension `news`, package name
`georgringer/news` will be installed into the folder
:path:`vendor/georgringer/news`.

Never put or symlink your extensions manually into this directory as it is
managed by Composer and any manual changes are getting lost,
for example on deployment. Local extensions and sitepackages
should be kept in a separate folder outside the web root, for example
:ref:`packages <directory-packages>`.
Upon installation , Composer creates a symlink from packages to
:path:`vendor/myvendor/my-extension`.

..  _regeneration-temporary-folders:

Regenerating temporary folders
==============================

TYPO3 requires certain folders under :path:`var/` and :path:`public/typo3temp/`  
to exist. If they are missing, the system may not function correctly.

To safely restore these folders, use one of the following methods:

..  _typo3temp-regeneration-guide-command:

Command line: install:fixfolderstructure
----------------------------------------

Run the following command to recreate missing directories:

..  code-block:: bash

    vendor/bin/typo3 install:fixfolderstructure

..  _typo3temp-regeneration-guide-gui:

Admin tools: Directory Status
-----------------------------

Alternatively, a system maintainer can go to :guilabel:`Admin Tools > Environment > Directory Status`
and recreate the missing folders with the necessary permissions

..  toctree::
    :titlesonly:
    :hidden:
    :glob:

    ClassicInstallations
    *
