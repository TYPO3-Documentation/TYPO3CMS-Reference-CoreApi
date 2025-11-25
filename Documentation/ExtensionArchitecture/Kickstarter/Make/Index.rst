.. include:: /Includes.rst.txt
.. index::
   Extension development; Make
.. _extension-make:

====
Make
====

.. _extension-make-kickstart:

Kickstart a TYPO3 Extension with "Make"
=======================================

"`Make <https://github.com/b13/make>`__" is a TYPO3 extension provided by b13. It is a quick way to create
a basic extension scaffold via the console. The extension is available for TYPO3 v10 and above.

1. Install "Make"
=================

In Composer-based TYPO3 installations you can install the
extension via Composer, but you should install it as a :bash:`dev` dependency as
it should not be used on production systems:

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            composer req b13/make --dev

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev composer req b13/make --dev

    ..  group-tab:: Classic mode installation (no Composer)

        To install the extension on Classic mode installations, download it from the
        `TYPO3 Extension Repository (TER), extension
        "make" <https://extensions.typo3.org/extension/make/>`__.

2.  Kickstart an extension
==========================

Call the CLI script on the console:

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 make:extension

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev exec vendor/bin/typo3 make:extension

    ..  group-tab:: Classic mode installation (No Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 make:extension


3.  Answer the prompt
=====================

"Make" will now ask you the following questions:

`Enter the composer package name (e.g. "vendor/awesome"):`
    Valid composer package names are defined in the
    `getcomposer name scheme <https://getcomposer.org/doc/04-schema.md#name>`__.

    The vendor **should** be a unique name that is not used by any other
    companies or developers.

    Example: `my-vendor/my-test`

`Enter the extension key [my_test]:`
    The extension key **should** follow the rules for best practice for
    :ref:`choosing an extension key <extension-key>` if you plan to publish
    your extension. In most cases the default, here `my_test`, will be sufficient.
    Press :kbd:`enter` to accept the default or enter another name.

`Enter the PSR-4 namespace [T3docs/MyTest]:`
    The namespace has to be unique within the project. Usually the default
    will be unique because your vendor name is unique, and you can accept it by
    pressing :kbd:`enter`.

`Choose supported TYPO3 versions (comma separate for multiple) [TYPO3 v11 LTS]:`
    If you want your extension to be compatible with both TYPO3 v11 and v12, enter:
    `11,12`

`Enter a description of the extension:`
    A description is mandatory. You can change it later in the
    :file:`composer.json <extension-composer-json>` extension file.

`Where should the extension be created? [src/extensions/]:`
    If you have a specific folder for your local extensions like
    :file:`packages` enter it here. Otherwise you can accept the
    default.

`May we add a basic service configuration for you? (yes/no) [yes]:`
    If you choose `yes` "Make" will create a basic
    :file:`Configuration/Services.yaml` which configures :ref:`dependency injection <DependencyInjection>`.

`May we create a ext_emconf.php for you? (yes/no) [no]:`
    Mandatory for extensions supporting TYPO3 v10. Starting with v11:
    If your extension needs be installable in legacy TYPO3 installations
    choose `yes`. If your extension is local and in a Composer-based
    installation it is not necessary and you can choose `no`.

4.  Have a look at the result
=============================

"Make" has now created a subfolder under :file:`src/extensions` with the
same name as the composer name (without vendor) of your extension. By default
the subfolder contains the following files:

..  code-block:: none
    :caption: Page tree of directory :file:`src/extensions`

    $ tree src/extensions
    └── my-test
        ├── Classes
        ├── Configuration
        |   └── Services.yaml (optional)
        ├── composer.json
        └── ext_emconf.php (optional)

5. Install the extension
========================

On Composer-based installations the extension will be created but not installed.
Therefore it won't be displayed in the backend :guilabel:`Extension Manager`.

To install it, open the main :file:`composer.json <extension-composer-json>` of
your **project** (not the one in the new extension) and define the extension
directory as a new repository under `repositories`:

..  code-block:: json
    :caption: my_project_root/composer.json
    :emphasize-lines: 3-8

    {
        "name": "my-vendor/my-project",
        "repositories": {
            "0_packages": {
                "type": "path",
                "url": "src/extensions/*"
            }
        },
        "...": "..."
    }

Then, on Composer-based systems, require the extension using the composer
name:

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            composer req t3docs/my-test:@dev

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev composer req my-vendor/my-test:@dev

    ..  group-tab:: Classic mode installation (No Composer)

        Activate the extension in the Extension Manager.

6.  Add functionality
=====================

The following commands are also available if you want to add more functionality
to your extension:

*   `make:backendcontroller`  - :ref:`Create a new backend controller <extension-make-backend-controller>`
*   `make:command` - :ref:`Create a new command <extension-make-console-command>`
*   `make:eventlistener` - Create a new event listener
*   `make:middleware` - Create a new middleware

Read more:
==========

..  toctree::
    :titlesonly:
    :glob:

    *
