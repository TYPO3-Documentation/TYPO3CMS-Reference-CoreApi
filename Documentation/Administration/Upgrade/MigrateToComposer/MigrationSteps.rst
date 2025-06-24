.. include:: /Includes.rst.txt
.. highlight:: bash

===============
Migration steps
===============

..  note::
    If you are not familiar with Composer, please read the following documents
    first:

    *   `Introduction to Composer <https://getcomposer.org/doc/00-intro.md>`__
    *   `Basic usage of Composer <https://getcomposer.org/doc/01-basic-usage.md>`__


It is recommended to perform a Composer migration using the latest TYPO3 major release to prevent
bugs and issues that have been solved in newer versions. If you
are using an older TYPO3 version in Classic mode, you have two options:

*   **Upgrade TYPO3 Classic mode installation first**, then migrate to Composer. This is probably
    more straight-forward as you can follow the :ref:`Classic mode Upgrade Guide <classic-mode-upgrade>`, and then this guide.
*   **Migrate the old TYPO3 version to Composer first**, then perform a :ref:`major upgrade <major>`.
    This might be a bit tricky, because you have to use older versions of
    `typo3/cms-composer-installers` and dependencies like `helhum/typo3-console`, or outdated
    extensions on Packagist.
    You will need to read through older versions of this guide that match
    your TYPO3 version (use the version selector of the documentation).


Delete files
============

..  warning:: Make sure to have a  working `backup <https://docs.typo3.org/permalink/t3coreapi:administration-backups>`_.

Yes, it's true that you will have to delete some files, because they will be newly created by
Composer in some of the next steps.

You will have to delete :file:`public/index.php`, :file:`public/typo3/` and any
extensions that you have downloaded from the TYPO3 Extension Repository (TER) or
other resources like GitHub in :file:`public/typo3conf/ext/`. Also, delete your own custom
extensions if they are published in a separate Git repository or included as a Git submodule.

Only keep your sitepackage extension and extensions which have been
explicitly built for your current project and do not have their own Git
repository.

Configure Composer
==================

Create a file named :ref:`composer.json <t3coreapi:files-composer-json>`
in your project root (not in your web root).

You can use the :file:`composer.json` file from `typo3/cms-base-distribution` as an
example. Use the file from the branch which matches your current version, for
example `12.x <https://github.com/typo3/TYPO3.CMS.BaseDistribution/tree/12.x/composer.json>`__.

However, this file may require extensions you don't need or omit extensions you do
need, so be sure to update the required extensions as described in the next
sections.

Other ways of creating the :file:`composer.json` file are via a :bash:`composer init` command,
the `TYPO3 Composer Helper <https://get.typo3.org/misc/composer/helper>`__
or advanced project builders like `CPS-IT project-builder <https://github.com/CPS-IT/project-builder>`__
which use a guided approach to create the file.

.. hint::

   If you see versions of the :file:`composer.json` for versions older than TYPO3 v12,
   you may see references to a `scripts` section that makes use of
   `helhum/typo3-console <https://packagist.org/packages/helhum/typo3-console>`__.
   This is optional.

   You can look at previous versions of the
   `Base Distribution's composer.json <https://github.com/typo3/TYPO3.CMS.BaseDistribution/tree/12.x/composer.json>`__
   for differences between the TYPO3 versions.


Add all required packages to your project
=========================================

You can add all your required packages with the Composer command :bash:`composer
require`. The full syntax is:

.. code-block:: shell
   :caption: typo3_root$

   composer require anyvendorname/anypackagename:version

**Example**:


.. code-block:: shell
   :caption: typo3_root$

   composer require "typo3/minimal:^12"

This uses the `Packagist <https://packagist.org>`__ repository by default,
which is the de-facto standard for Composer packages.


Composer packages follow a concept called `SemVer <https://semver.org/` (semantic
versioning). This splits version numbers into three parts:

*  Major version (1.x.x)
*  Minor version (x.1.x)
*  Patch-level (x.x.1)

Major versions should include intentional breaking changes (like a new API,
changed configuration directives, removed functionality).

New features are introduced in minor versions (unless it is breaking change).

Patch-level releases only fix bugs and security issues and should never add
features or breaking changes.

These Composer version constraints
allow you to continuously update your installed packages and get an expected outcome
(no breaking changes or broken functionality).

There are different ways to define the version of the package you want
to install. The most common syntaxes start with `^` (e.g.
`^12.4`) or with `~` (e.g. `~12.4.0`). Full documentation can be
found at https://getcomposer.org/doc/articles/versions.md

In short:

*  `^12.4` or `^12.4.0` tells Composer to add the newest package of
   version `12.\*` with at least `12.4.0`. When a package releases
   version `12.9.5`, you would receive that version. Version
   `13.0.1` would not be fetched. So this allows any new
   minor or patch-level version, but not a new major version.

*  `~12.4.0` tells Composer to add the newest package of version
   `12.4.\*` with at least `12.4.0`, but not version `12.5.0` or `13.0.1`.
   This would only fetch newer patch-level versions of a package.

You have to decide which syntax best fits your needs.

This applies to TYPO3 Core packages, extension packages and dependencies unrelated
to TYPO3.

As a first step, you should only pick the TYPO3 Core extensions to
ensure your setup works, and add third-party dependencies later.

.. _composer-migration-require-all:
.. _composer-migration-require-subtree-packages:

Install the Core
----------------

Once the :file:`composer.json` is updated,
install additional system extensions:

.. code-block:: shell
   :caption: typo3_root$

   composer require typo3/minimal:^12.4
   composer require typo3/cms-scheduler:^12.4
   composer require ...

Or, in one line:

.. code-block:: shell
   :caption: typo3_root$

   composer require typo3/minimal:^12.4 typo3/cms-scheduler:^12.4 ...

To find the correct package names, either take a look in the
:file:`composer.json` of that system extension or follow the naming
convention
:file:`typo3/cms-<extension name with dash "-" instead of underscore "_">`,
e.g. :file:`typo3/cms-fluid-styled-content`. You can also go to `Packagist <https://packagist.org/>`__
and search for `typo3/cms-` to see all listed packages.

.. note::

    To find all TYPO3 Core packages, you can visit the TYPO3 Composer Helper website.
    https://get.typo3.org/misc/composer/helper
    This website allows you to select TYPO3 Core Packages and generate
    the Composer command to require them.


Install extensions from Packagist
---------------------------------

You know the `TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`__
and have used it to install extensions? Fine.
However, with Composer the **required way** is now to install extensions
directly from `Packagist <https://packagist.org>`__.

This is the usual method for most extensions used today. Alternatively, some extension
authors and commercial providers offer a custom Composer repository that you can
use (:ref:`see below <composer-require-repository>`). Installation is the
same - :bash:`composer require`.

To install a TYPO3 extension you need to know the package name. There are multiple
ways to find it out:

Notice on extension's TER page
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Extension maintainers can link their TYPO3 extension in TER with the
Composer package name on `Packagist <https://packagist.org>`__. Most maintainers
have done this and if you search for the extension in TER you will see which
command and Composer package name can be used to install the extension.

.. include:: /Images/ExternalImages/Upgrade/TerComposerCommand.rst.txt

.. note::

    The command :bash:`composer req` is short for :bash:`composer require`. Both commands
    do exactly the same thing and are interchangeable.

Search on Packagist
~~~~~~~~~~~~~~~~~~~

`Packagist <https://packagist.org>`__ has a quick and flexible search function. Often you can
search by TYPO3 extension key or name of the extension and you will most likely
find the package you are looking for.

Check manually
~~~~~~~~~~~~~~

This is the most exhausting way - but it will work, even if the extension maintainer
has not explicitly provided the command.

#. Search for and open the extension you want to install, in
   `TER <https://extensions.typo3.org>`__.

#. Click button "Take a look into the code".

   .. include:: /Images/ExternalImages/Upgrade/TerCodeLink.rst.txt

#. Open file :file:`composer.json`.

   .. include:: /Images/ExternalImages/Upgrade/GithubComposerFile.rst.txt

#. Search for line with property `"name"`. Its value should be
   formatted like `vendor/package`.

   .. include:: /Images/ExternalImages/Upgrade/GithubComposerName.rst.txt

#. Check if the package can be found on
   `Packagist <https://packagist.org>`__.

   .. include:: /Images/ExternalImages/Upgrade/PackagistMask.rst.txt

**Example:**
To install the mask extension version 8.3.\*, type:

.. code-block:: shell
   :caption: typo3_root$

   composer require mask/mask:~8.3.0

.. _composer-require-repository:

Install extension from version control system (e.g. GitHub, Gitlab, ...)
------------------------------------------------------------------------

In some cases, you will have to install a TYPO3 extension that is not
available on Packagist or TER. For example:

*  a non-public extension only used in your company.
*  you forked and modified an existing extension.
*  commercial plugin / licensed download / Early Access (EAP)

As a first step, define the repository in the `repositories` section of your
:file:`composer.json`. In this example the
additional lines are added to the top of :file:`composer.json`:

.. code-block:: json
   :caption: /composer.json

    {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/foo/bar.git"
            }
        ],
        "extra": {
            "typo3/cms": {
                "web-dir": "public"
            }
        }
    }

Ideally, you should not edit a :file:`composer.json` file manually, but instead use
Composer commands to make the changes, like this:

.. code-block:: shell
   :caption: typo3_root$

   composer config repositories.foo-bar vcs https://github.com/foo/bar.git

The Git repository must point to a TYPO3 extension with a
:file:`composer.json`.

See :ref:`t3coreapi:files-composer-json` for details on what these files should look like.

Git tags in the repository are used as version numbers.

Instead of adding a single Git repository, it is also possible to add Composer repositories
that aggregate multiple packages through tools like `Satis <https://github.com/composer/satis>`__,
or `Private Packagist <https://packagist.com/>`__ repositories.

If these requirements are fulfilled, you can add your extension in the
normal way:

.. code-block:: shell
   :caption: typo3_root$

   composer require foo/bar:~1.0.0

.. _mig-composer-include-individual-extensions:

Include individual extensions like site packages
================================================

A project will often contain custom extensions, such as a :ref:`sitepackage <t3sitepackage:start>`
which provides TYPO3-related project templates and configuration.

Before TYPO3 v12, these extensions were stored in the `typo3conf` directory :file:`typo3conf/ext/my_sitepackage`.
Composer mode allows you to easily add a custom repository to your project
by using the `path` type. This means you can require your local sitepackage as if it was
a normal package without publishing it to a repository like
GitHub or on Packagist.

Usually these extensions are in a directory like :file:`<project_root>/packages/`
or :file:`<project_root>/extensions/` (and no longer in :file:`typo3conf/ext/`), so you would use:

.. code-block:: shell
   :caption: typo3_root$

   composer config repositories.local_packages path './packages/*'
   composer require myvendor/sitepackage

Your sitepackage needs to be contained in its own directory like
:file:`<project_root>/packages/my_sitepackage/` and provide a :file:`composer.json` file
in that directory. The :file:`composer.json` file needs to list all the possible
autoloading information for PHP classes that your sitepackage uses:

.. code-block:: json
   :caption: EXT:my_sitepackage/composer.json

   {
        "autoload": {
            "psr-4": {
                "MyVendor\\Sitepackage\\": "Classes/"
            }
        }
   }

Directory locations are always relative to where the extension-specific :file:`composer.json` is
stored.

Do not mix up the project-specific :file:`composer.json` file with the package-specific :file:`composer.json`
file. Autoloading information is specific to an extension, so it is not usually listed in the
project file.

Now our example project's :file:`composer.json` would look like this:

.. code-block:: json
   :caption: typo3_root/composer.json

   {
       "repositories": [
           {
               "type": "vcs",
               "url": "https://github.com/foo/bar.git"
           },
           {
               "type": "path",
               "url": "./packages/*"
           },
       ],
       "extra": {
           "typo3/cms": {
               "web-dir": "public"
           }
       }
   }

After adding or changing paths in the autoload section you should run :bash:`composer dumpautoload`. This command
will re-generate the autoload information and should be run anytime you add new paths to the autoload section
in the :file:`composer.json`.

After all custom extensions have been moved out of :file:`typo3conf/ext/` you can delete the directory
from your project. You may also want to adapt your :file:`.gitignore` file to remove any entries
related to that old directory.

New file locations
==================

Finally, some files will need to be moved because the location will have
changed for your site since moving to Composer.

The files listed below are internal files that should not be exposed to
the webserver, so they are should be moved outside the :file:`public/` structure.

At a minimum, the site configuration and the translations should be moved.

Move files:

.. code-block:: shell
   :caption: typo3_root$

   mv public/typo3conf/sites config/sites
   mv public/typo3temp/var var
   mv public/typo3conf/l10n var/labels

.. important::

   The :file:`var` directory may already exist. In that case, move the files
   individually. You can also delete the "old" files in
   :file:`public/typo3temp/var`, unless you need to keep the log files
   or anything else that may still be relevant.

These locations have changed. Note that TYPO3 v12+ moved more configuration
files to a new directory than TYPO3 v11:

+------------------------------------------------------+-----------------------------------------------------------------+
| Before                                               | After                                                           |
+======================================================+=================================================================+
| :file:`public/typo3conf/sites`                       | :file:`config/sites`                                            |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3temp/var`                         | :file:`var`                                                     |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3conf/l10n`                        | :file:`var/labels`                                              |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3conf/LocalConfiguration.php`      | :file:`config/system/settings.php`                              |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3conf/AdditionalConfiguration.php` | :file:`config/system/additional.php`                            |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3conf/system/settings.php`         | :file:`config/system/settings.php`                              |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3conf/system/additional.php`       | :file:`config/system/additional.php`                            |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3`                                 | :file:`vendor/typo3/`                                           |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3conf/PackageStates.php`           | removed                                                         |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3conf/ext`                         | removed (replaced by :file:`vendor` and e.g. :file:`packages`)  |
+------------------------------------------------------+-----------------------------------------------------------------+
| :file:`public/typo3conf/ext/.../Resources/Public`    | :file:`public/_assets` (new)                                    |
+------------------------------------------------------+-----------------------------------------------------------------+

The directory :file:`public/_assets/` and how to migrate public web assets from extensions and your
:ref:`sitepackage <t3sitepackage:start>` is described in: :ref:`migrate-public-assets` .

Have a look at :ref:`t3coreapi:directory-structure` in "TYPO3 Explained". Developers
should also be familiar with the :ref:`Environment API <t3coreapi:Environment>`.
