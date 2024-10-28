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
facing bugs and issues that have been solved already in newer versions. In case you
are using an older TYPO3 version in Legacy installation mode, you have two viable options:

*   **Upgrade TYPO3 Legacy first**, then do the migration to Composer. This is probably
    more straight-forward, as you can follow the :ref:`Legacy Upgrade Guide <legacy>`, and then this guide.
*   **Migrate old TYPO3 version to Composer first**, then perform the :ref:`major upgrade <major>`.
    This might cause some friction, because you have to utilize older versions of
    `typo3/cms-composer-installers` and dependencies like `helhum/typo3-console` or outdated
    extensions on Packagist.
    You will also need to inspect older versions of this guide that matches your old TYPO3
    version, using the version selector of the documentation.


Delete files
============

.. include:: /Administration/Upgrade/Major/PreupgradeTasks/Backup.rst.txt

Yes, that's true. You have to delete some files, because they will be created by
Composer in some of the next steps.

You have to delete :file:`public/index.php`, :file:`public/typo3/` and all the
extensions inside :file:`public/typo3conf/ext/` that you have downloaded from the TYPO3 Extension Repository (TER) or any
other resources like GitHub. You even have to delete your own extensions, if
they are available in a separate Git repository and, for example, included as
Git submodule.

Please keep only your sitepackage extension or any other extension, which was
explicitly built for your current project and does not have an own Git
repository.

Configure Composer
==================

Create a file with name :ref:`composer.json <t3coreapi:files-composer-json>`
in your project root, not inside your web root.

You can use the :file:`composer.json` from `typo3/cms-base-distribution` as an
example. Use the file from the branch which matches your current version, for
example `12.x <https://github.com/typo3/TYPO3.CMS.BaseDistribution/tree/12.x/composer.json>`__.

However, this may require extensions you don't need or omit extensions you do
need, so be sure to update the required extensions as described in the next
sections.

You can also create the :file:`composer.json` file via a :bash:`composer init` command.
Or use the `TYPO3 Composer Helper <https://get.typo3.org/misc/composer/helper>`__.
Also advanced project builders like `CPS-IT project-builder <https://github.com/CPS-IT/project-builder>`__
help you to initialize this most vital file of a Composer project with a
guided approach.

.. hint::

   If you see versions of the :file:`composer.json` for versions older than TYPO3 v12,
   you may see references to a `scripts` section that would make use of
   `helhum/typo3-console <https://packagist.org/packages/helhum/typo3-console>`__, and which
   also would need to be required as a package in your newly created :file:`composer.json`.
   This is optional.

   You can look at previous versions of the
   `Base Distribution's composer.json <https://github.com/typo3/TYPO3.CMS.BaseDistribution/tree/12.x/composer.json>`__,
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

This will utilize the `Packagist <https://packagist.org>`__ repository by default,
which is the de-facto standard for any Composer package.


Composer packages usually rely on a concept called `SemVer <https://semver.org/` (semantic
versioning). This splits any version number into three parts:

*  Major version (1.x.x)
*  Minor version (x.1.x)
*  Patch-level (x.x.1)

Only a major version should have intentional breaking changes (like new API,
changed configuration directives, removed functionality).

New features can only be introduced via a new minor version (unless it is breaking).

Patch-level releases only fix bugs and security issues and should never add
relevant features or even breaking changes.

By relying on this, the Composer version constraints of any installed package
allow you to continuously update involved packages with an expected outcome
(no breaking changes or non-working functionality).

There are different ways to define the version of the package you want
to install. The most common syntaxes start with `^` (e.g.
`^12.4`) or with `~` (e.g. `~12.4.0`). A full documentation can be
found at https://getcomposer.org/doc/articles/versions.md

In short:

*  `^12.4` or `^12.4.0` tells Composer to add newest package of
   version `12.\*` with at least `12.4.0`. When a package releases
   version `12.9.5`, you would receive that version. A version
   `13.0.1` would not be fetched. So this allows any new
   minor or patch-level version, but no new major version.

*  `~12.4.0` tells Composer to add the newest package of version
   `12.4.\*` with at least `12.4.0`, but not version `12.5.0` or `13.0.1`.
   This would only fetch newer patch-level versions of a package.

You have to decide by yourself, which syntax fits best to your needs.

This applies to both the TYPO3 Core packages as well as extension
packages, or even TYPO3-unrelated dependencies.

As a first step, you should only pick the TYPO3 Core extensions to
ensure your setup works, and add third-party dependencies later.

.. _composer-migration-require-all:
.. _composer-migration-require-subtree-packages:

Install the Core
----------------

Once the :file:`composer.json` is updated accordingly, you can
install additional system extensions:

.. code-block:: shell
   :caption: typo3_root$

   composer require typo3/minimal:^12.4
   composer require typo3/cms-scheduler:^12.4
   composer require ...

Or in one line:

.. code-block:: shell
   :caption: typo3_root$

   composer require typo3/minimal:^12.4 typo3/cms-scheduler:^12.4 ...

To find the correct package names, you can either take a look in the
:file:`composer.json` of the related system extension or follow the naming
convention
:file:`typo3/cms-<extension name with dash "-" instead of underscore "_">`,
e.g. :file:`typo3/cms-fluid-styled-content`. You can also go to `Packagist <https://packagist.org/>`__
and search for `typo3/cms-` to see all listed packages.

.. note::

    To find out all TYPO3 Core packages, you can visit the TYPO3 Composer Helper website.
    https://get.typo3.org/misc/composer/helper
    From this website, you can select TYPO3 Core Packages you need and generate
    the Composer command to require them.


Install extensions from Packagist
---------------------------------

You already know the `TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`__ and always used it to install extensions? Fine.
But with Composer, the **required way** is to install extensions
directly from `Packagist <https://packagist.org>`__.

This is the usual way for most extensions used today. Alternatively, some extension
authors or commercial providers offer a custom Composer repository that you can
use (:ref:`see below <composer-require-repository>`). The usage via :bash:`composer require` remains the same.

To install any TYPO3 extension, you need to know the package name. There are multiple ways to find it:

Notice on extension's TER page
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Extension maintainers optionally can link their TYPO3 extension in TER with the
according Composer package name on `Packagist <https://packagist.org>`__. Most maintainers already did that and if you
search the extension in TER, you will see a message, which command and Composer
package name you can use to install this extension.

.. include:: /Images/ExternalImages/Upgrade/TerComposerCommand.rst.txt

.. note::

    The command :bash:`composer req` is short for :bash:`composer require`. Both commands
    exactly do the same and are interchangeable.

Search on Packagist
~~~~~~~~~~~~~~~~~~~

`Packagist <https://packagist.org>`__ provides a flexible and quick search. Often you can
search for the known TYPO3 extension key or name of the extension, and you will most likely
find the package you are looking for.

Check manually
~~~~~~~~~~~~~~

This is the most exhausting way. But it will work, even if the extension maintainer
does not provide additional information.

#. Search and open the extension, you want to install, in
   `TER <https://extensions.typo3.org>`__.

#. Click button "Take a look into the code".

   .. include:: /Images/ExternalImages/Upgrade/TerCodeLink.rst.txt

#. Open file :file:`composer.json`.

   .. include:: /Images/ExternalImages/Upgrade/GithubComposerFile.rst.txt

#. Search for line with property `"name"`, it's value should be
   formatted like `vendor/package`.

   .. include:: /Images/ExternalImages/Upgrade/GithubComposerName.rst.txt

#. Check, if the package can be found on
   `Packagist <https://packagist.org>`__.

   .. include:: /Images/ExternalImages/Upgrade/PackagistMask.rst.txt

**Example:**
To install the mask extension in version 8.3.\*, type:

.. code-block:: shell
   :caption: typo3_root$

   composer require mask/mask:~8.3.0

.. _composer-require-repository:

Install extension from version control system (e.g. GitHub, Gitlab, ...)
------------------------------------------------------------------------

In some cases, you will have to install a TYPO3 extension, which is not
available on Packagist or in the TER. Examples could be:

*  non-public extension only used by your company.
*  you forked and modified an existing extension.
*  commercial plugin / licensed download / Early Access (EAP)

As first step, you have to define the repository in your
:file:`composer.json` section `repositories`. In this example, you find the
additional lines added to the :file:`composer.json` from above:

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

Ideally you should not manually edit a :file:`composer.json` file, but instead
utilize the Composer command to manipulate the file, like this:

.. code-block:: shell
   :caption: typo3_root$

   composer config repositories.foo-bar vcs https://github.com/foo/bar.git

The Git repository must point to a TYPO3 extension that provides a
:file:`composer.json` itself.

See :ref:`t3coreapi:files-composer-json` for details on how these files should look like.

Git tags of the repository will be used as version numbers.

Apart from only adding a single Git repository, you can also add Composer repositories
that aggregate multiple packages through tools like `Satis <https://github.com/composer/satis>`__,
or also `Private Packagist <https://packagist.com/>`__ repositories.

If you fulfill these requirements, you can add your extension in the
same way like the other examples:

.. code-block:: shell
   :caption: typo3_root$

   composer require foo/bar:~1.0.0

.. _mig-composer-include-individual-extensions:

Include individual extensions like site packages
================================================

A project will often contain custom extensions, and at the least a :ref:`sitepackage <t3sitepackage:start>`
that provides the TYPO3-related project templates and configuration.

Before TYPO3 v12, these extensions were stored in a directory like :file:`typo3conf/ext/my_sitepackage`.
In Composer mode, you can easily add a custom repository within your project
of the type `path`. This allows you to require your sitepackage as if it was
a normal package. By doing this, you do not need to publish your sitepackage to a repository like
GitHub, or publish a package on Packagist.

Usually these extensions are saved in a directory like :file:`<project_root>/packages/`
or :file:`<project_root>/extensions/` (and no longer in :file:`typo3conf/ext/`), so you would use:

.. code-block:: shell
   :caption: typo3_root$

   composer config repositories.local_packages path './packages/*'
   composer require myvendor/sitepackage

This also means that your sitepackage needs to be contained in its own directory like
:file:`<project_root>/packages/my_sitepackage/` and provide a :file:`composer.json` file
within that directory. That :file:`composer.json` file would also list all the possible
autoloading information of PHP classes that your sitepackage uses:

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

Do not mix up the project-specific :file:`composer.json` file with this package-specific :file:`composer.json`
file. Since autoloading information is specific to an extension, you usually do not list it in the
project file.

To complete our example project's :file:`composer.json`, it would look like this:

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

After all custom extensions are moved away from :file:`typo3conf/ext/` you can remove the directory
from your project. You may also want to adapt your :file:`.gitignore` file to remove any entries
related to that old directory.

New file locations
==================

As final steps, you should move some files because the location will have
changed for your site since moving to Composer.

The files listed below are internal files that should not be exposed to
the webserver, so they are moved outside the :file:`public/` structure,
in parallel to :file:`vendor/`.

You should at least move the site configuration and the translations.

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

These locations have changed, note that TYPO3 v12+ moved some more configuration
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

The directory :file:`public/_assets/` and how to migrate public web assets from extensions or your
:ref:`sitepackage <t3sitepackage:start>` is described in: :ref:`migrate-public-assets` .

Have a look at :ref:`t3coreapi:directory-structure` in "TYPO3 Explained". As
developer, you should also be familiar with the
:ref:`Environment API <t3coreapi:Environment>`.
