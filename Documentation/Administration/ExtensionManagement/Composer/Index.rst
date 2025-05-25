:navigation-title: Composer

..  include:: /Includes.rst.txt
..  _extensions-composer:

========================================
TYPO3 extension management with Composer
========================================

..  seealso::
    For a beginner friendly introduction on extension management with Composer
    see:

    *   `Getting Started Guide: Working with extensions <https://docs.typo3.org/permalink/t3start:extensions-index>`_

..  contents:: Table of contents

..  _extensions-composer-installation:

Install or require an extension with Composer
=============================================

Composer makes a difference between **requiring** and **installing** an
extension. By default you can require any package that is registered on
https://packagist.org/ and compatible with the current requirements.

..  _extensions-composer-require:

Composer require
----------------

When you use the command `composer require` or short `composer req`
the requirement will be added to the file :file:`composer.json` and Composer
installs the latest version that satisfies the version constraints in
:file:`composer.json`, and writes the resolved version to :file:`composer.lock`.

For example to install the extension :composer:`georgringer/news` do:

..  code-block:: bash

    # Install the news extension
    composer require georgringer/news

If necessary you can also require the extension with a version requirement:

..  code-block:: bash

    # Install the news extension in version 12.3.0 or any minor level above
    composer require georgringer/news:"^12.3"

    # Install the news extension from the main branch
    composer require georgringer/news:"dev-main"

..  seealso::

    *   `command "composer require" <https://getcomposer.org/doc/03-cli.md#require-r>`_
    *   `"Writing Version Constraints" in the Composer documentation
        <https://getcomposer.org/doc/articles/versions.md#writing-version-constraints>`_
        for more version constraint examples.


Composer will then download the extension into the folder :path:`vendor` and
execute additional installation steps.

You can now commit the files :file:`composer.json` and :file:`composer.lock`
to `Git <https://docs.typo3.org/permalink/t3coreapi:version-control>`_.

..  _extensions-composer-install:

Composer install
----------------

On any other system where the same project is installed — such as a co-worker’s
computer or the production server (if you are working with
`Git and Composer deployment <https://docs.typo3.org/permalink/t3coreapi:deployment-git-composer>`_) —
you do not need to run `composer require` again. Instead, use
`composer install` to install the exact versions defined in
:file:`composer.lock`:


..  code-block:: bash

    git update

    # Install versions that have been changed
    composer install

    # Rerun the setup for all extensions
    vendor/bin/typo3 extension:setup

..  seealso::

    *   `command "composer install" <https://getcomposer.org/doc/03-cli.md#install-i>`_

..  _extensions-composer-list:

List extensions
---------------

Like TYPO3’s core, extensions are also Composer packages.
You can list all currently installed packages, including extensions, using the following command:

..  code-block:: bash

    composer info

This will display a list of all installed packages along with their names and currently installed versions.

..  seealso::

    * `command "composer info" <https://getcomposer.org/doc/03-cli.md#show-info>`_

..  _extensions-composer-extension-setup:

Extension setup
---------------

Many extensions make changes to your system that Composer cannot detect
as they are TYPO3 specific. For example, an extension might define its own
database tables in TCA or require static data to be imported.


You can run the following command to set up a specific or all extensions:

..  code-block:: bash

    # Setup the extension with key "news"
    vendor/bin/typo3 extension:setup --extension=news

    # Setup all extensions
    vendor/bin/typo3 extension:setup

You can also :ref:`Automate the extension setup <extensions-composer-extension-setup>`.

..  tip::

    The Composer package name (for example, `georgringer/news`) and the TYPO3
    extension key (for example, `news`) are **not the same**.

    The **extension key** is defined in the extension’s :file:`composer.json`
    under the key
    `extra.typo3/cms.extension-key <https://docs.typo3.org/permalink/t3coreapi:ext-composer-json-property-extension-key>`_.


..  _extensions-composer-extension-setup-automate:

Automate extension setup
------------------------

You can run the :ref:`Extension setup command <extensions-composer-extension-setup>`
automatically after each require / install / update command by adding it to
the `script` section of your project's :file:`composer.json`:

..  literalinclude:: _repositories.json
    :caption: composer.json (Excerpt)

..  seealso::

    *   `Composer scripts <https://getcomposer.org/doc/articles/scripts.md>`_

..  _extensions-composer-installation-custom:

Installing a custom extension or site package via Composer
==========================================================

In most projects you will have one special extension, also called site package
per site, that contains the theme and configuration for the site.

Furthermore you can develop a custom extension only for a special domain of your
project.

Place such extensions in the :path:`packages` folder and require them as local (
`@dev`) versions using Composer. This will create a symlink from
:path:`packages` to :path:`vendor`, allowing the extension to be used
like any other package.


#.  Place the extension into the folder :path:`packages`, so that its `composer.json`
    can be found at :file:`packages/ext_key/composer.json`
#.  Require the extension using Composer and accepting the `@dev` version:

    ..  code-block:: bash

        # Require a custom site package
        composer require myvendor/my-site-package:"@dev"

        # Require a custom extension
        composer require myvendor/my-local-extension:"@dev"

Composer install will work as described in section
:ref:`extensions-composer-install` if the extension is available on the system
where you run the `composer install` command.

You will usually commit the
files :file:`composer.json`, :file:`composer.lock` and the content of the
:path:`packages` folder to the same Git repository.

..  seealso::

    *   `"Creating a site package", Getting started tutorial <https://docs.typo3.org/permalink/t3start:creating-a-site-package>`_
    *   `"Site package installation", Site Package Tutorial <https://docs.typo3.org/permalink/t3sitepackage:extension-installation>`_
    *   `Extension development <https://docs.typo3.org/permalink/t3coreapi:extension-development>`_

..  _extensions-composer-installation-source:

Installing extensions from a different source
=============================================

You can define `Composer repositories <https://getcomposer.org/doc/05-repositories.md>`_
to install packages (including TYPO3 extensions) from different sources, like
from `Git <https://getcomposer.org/doc/05-repositories.md#vcs>`_, a `local
path <https://getcomposer.org/doc/05-repositories.md#path>`_ or a
`Private Packagist <https://getcomposer.org/doc/05-repositories.md#private-packagist>`_.

After adding the repository to your project's :file:`composer.json`, you can
require the extension using the standard `composer require` command.

..  literalinclude:: _codesnippets/_repositories.json
    :caption: composer.json (Excerpt)

..  _extensions-composer-update:

Extension update via Composer
=============================

..  attention::

    The command `composer update` cannot be easily reverted. We recommend to
    use `Version control (Git) <https://docs.typo3.org/permalink/t3coreapi:version-control>`_
    and commit both files :file:`composer.json` and :file:`composer.lock` before
    you run an update command.

    If you do not use Git, make a backup of these two files before the update.

The following command updates all installed Composer packages (both TYPO3
extensions and other PHP packages/libraries) to the newest version that the
current constraints in your :file:`composer.json` allows. It will write the
new versions to file :file:`composer.lock`:

..  code-block:: bash

    # Warning: Make a backup of composer.json and composer.lock before proceeding!
    composer update

If you want to do a major Upgrade, for example from :composer:`georgringer/news`
Version 11.x to 12.x you can require that extension with a different version:

..  code-block:: bash

    # Attention make a backup of the composer.json and composer.lock first!!
    composer require georgringer/news:"^12"

..  seealso::

    *   `command "composer update" <https://getcomposer.org/doc/03-cli.md#update-u-upgrade>`_
    *   `command "composer require" <https://getcomposer.org/doc/03-cli.md#require-r>`_
    *   `"Writing Version Constraints" in the Composer documentation
        <https://getcomposer.org/doc/articles/versions.md#writing-version-constraints>`_

..  _extensions-composer-downgrade:

Downgrading an extension
------------------------

If an extension does not work after upgrading it you can downgrade the extension
by requiring a specific version:

..  code-block:: bash

    # Attention make a backup of the composer.json and composer.lock first!!
    composer require georgringer/news:"12.0.42"

The extension will remain locked to the specified version and will not be
updated until you change the version constraint with another `composer require`
command.


..  _extensions-composer-update-revert:

Reverting extension update
--------------------------

As a last resort you revert all changes you made by restoring the files
:file:`composer.json` and :file:`composer.lock` and calling the command
`composer install`:

..  code-block:: bash

    # restore composer.json and composer.lock
    git stash

    # Reinstall previously used versions
    composer install

..  seealso::

    *   `command "composer install" <https://getcomposer.org/doc/03-cli.md#install-i>`_

..  _extensions-composer-remove:

Removing an extension via Composer
==================================

You can remove the requirement for an extension from your project's
:file:`composer.json` by using the command `composer remove`. However, the
extension will only be uninstalled if it is no longer required by any
installed package.

..  code-block:: bash

    # Check the extension is not in use first!
    # composer remove georgringer/news

Composer will not check if the extension is currently in use. Composer can only
check if the extension is listed in the `require` section of the
:file:`composer.json` file of another extension.

..  seealso::

    *   `command "composer remove" <https://getcomposer.org/doc/03-cli.md#remove-rm-uninstall>`_


..  _extensions-composer-remove-used:

Check if the extension is used
------------------------------

Manually verify whether the extension is still in use before uninstalling it.

*   Does the extension have `Site sets <https://docs.typo3.org/permalink/t3coreapi:site-sets>`_
    that are required by a site configuration or another extension's site set?
*   Do you use any plugins or content elements provided by the extension?
    Tip: Extension :composer:`fixpunkt/backendtools` lists all plugins and
    content elements that are in use.
*   Do you include TypoScript provided by the extension? Do you use any tables
    defined by its TCA? Does it have `Middlewares <https://docs.typo3.org/permalink/t3coreapi:request-handling>`_,
    `Console commands (CLI) <https://docs.typo3.org/permalink/t3coreapi:symfony-console-commands>`_
    or any other functionality that your project relies on?

..  _extensions-composer-remove-why:

Why can the extension not be uninstalled
----------------------------------------

If Composer refuses to remove an extension with `composer remove` you can
run the following command to find out what other packages require the Extension
you want to remove:

..  code-block:: bash

    # Show which package requires the extension
    composer why georgringer/news

..  seealso::

    *   `command "composer why" <https://getcomposer.org/doc/03-cli.md#depends-why>`_

In very stubborn cases the following tricks can help:

Ensure you have a backup of the files :file:`composer.json` and
:file:`composer.lock` or committed them to Git.

Then delete the :path:`vendor` folder (it will be restored by Composer), delete the
:file:`composer.lock` and run `composer install`. This will freshly install
your requirements from your :file:`composer.json`. Deleting the Composer cache
first might also help.

..  code-block:: bash

    composer clear-cache
    rm -rf vendor/
    rm composer.lock
    composer install

..  seealso::

    *   `command "composer install" <https://getcomposer.org/doc/03-cli.md#install-i>`_
    *   `command "composer clear-cache" <https://getcomposer.org/doc/03-cli.md#clear-cache-clearcache-cc>`_
