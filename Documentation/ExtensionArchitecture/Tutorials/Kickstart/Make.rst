.. include:: /Includes.rst.txt
.. index::
   Extension development; Make
.. _extension-make:

=======================================
Kickstart a TYPO3 Extension with "Make"
=======================================

"Make" is a TYPO3 extension provided by B13. It features a quick way to create
a basic extension scaffold on the console.

1. Install "Make"
=================

In composer-based TYPO3 installations of v10.4 and above you can install the
extension via composer, you should install it as :bash:`dev` dependency as
it should not be used on production systems:

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            composer req b13/make --dev

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev composer req b13/make --dev

    ..  group-tab:: Legacy

        To install the extension on legacy installations, download it from the
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

    ..  group-tab:: Legacy

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 make:extension


3.  Answer the prompt
=====================

"Make" will now answer some questions that we describe here in-depth:

`Enter the composer package name (e.g. "vendor/awesome"):`
    A valid composer package name is defined in the
    `getcomposer name scheme <https://getcomposer.org/doc/04-schema.md#name>`__.

    The vendor **should** be a unique name that is not yet used by other
    companies or developers.

    Example: `t3docs/my-test`

`Enter the extension key [my_test]:`
    The extension key **should** follow the rules for best practises on
    :ref:`choosing an extension key <extension-key>` if you plan to publish
    your extension. In most cases the default, here `my_test` is sufficient.
    Press enter to accept the default or enter another name.

`Enter the PSR-4 namespace [T3docs/MyTest]:`
    The namespace has to be unique within the project. Usually the default
    should be unique, as your vendor is unique, and you can accept it by
    pressing enter.

`Choose supported TYPO3 versions (comma separate for multiple) [TYPO3 v11 LTS]:`
    If you want to support both TYPO3 v11 and v12, enter the following:
    `11,12`

`Enter a description of the extension:`
    A description is mandatory. You can change it later on in the file
    :file:`composer.json` of the extension.

`Where should the extension be created? [src/extensions/]:`
    If you have a special path for installing local extensions like
    :file:`local_packages` enter it here. Otherwise you can accept the
    default.

`May we add a basic service configuration for you? (yes/no) [yes]:`
    If you chose `yes` "Make" will create a basic
    :file:`Configuration/Services.yaml` to configure dependency injection.

`May we create a ext_emconf.php for you? (yes/no) [no]:`
    Mandatory for extensions supporting TYPO3 v10. Starting with v11:
    If your extension should be installable in legacy TYPO3 installations
    choose yes. This is not necessary for local extensions in composer-based
    installations.

4.  Have a look at the result
=============================

"Make" created a folder in the folder :file:`src/extensions` with the
composer name (without vendor) of your extensions. By default it contains
the following files:

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

On composer-based installations the extension is not installed yet.
It will not be displayed in the :guilabel:`Extension Manager` in the backend.

To install it open the main :file:`composer.json` of your **project** (not the
one in the created extension) and add the extension directory as new repository:

..  code-block:: json
    :caption: my_project_root/composer.json

    {
        "name": "myvendor/myproject",
        "repositories": {
            "0_local_packages": {
                "type": "path",
                "url": "src/extensions/*"
            }
        },
        "...": "..."
    }

Then require the extension on composer-based systems, using the composer
name defined in the prompt of the script:

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            composer req t3docs/my-test:@dev

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev composer req t3docs/my-test:@dev

    ..  group-tab:: Legacy

        Activate the extension in the Extension Manager.

6.  Add functionality
=====================

The following additional commands are available to add more functionality
to your extension:

*   `make:backendcontroller`  - Create a new backend controller
*   `make:command` - Create a new command
*   `make:eventlistener` - Create a new event listener
*   `make:middleware` - Create a new middleware

Create a new backend controller
-------------------------------

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 make:backendcontroller

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev exec vendor/bin/typo3 make:backendcontroller

    ..  group-tab:: Legacy

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 make:backendcontroller

You will be prompted with a list of installed extensions. If your newly created
extension is missing, check if you installed it properly.

When prompted, choose a name and path for the backend controller. The following
files will be generated, new or changed files marked with a star (*):

..  code-block:: none
    :caption: Page tree of directory :file:`src/extensions`

    $ tree src/extensions
    └── my-test
        ├── Classes
        |   └── Backend (*)
        |   |   └── Controller (*)
        |   |   |   └── MyBackendController.php (*)
        ├── Configuration
        |   ├── Backend (*)
        |   |   └── Routes.php (*)
        |   └── Services.yaml (*)
        ├── composer.json
        └── ext_emconf.php

Learn how to turn the backend controller into a full fledged backend module in
the chapter :ref:`backend-modules`.

Create a new console command
----------------------------

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 make:command

    ..  group-tab:: DDEV, Composer

        ..  code-block:: bash

            ddev exec vendor/bin/typo3 make:command

    ..  group-tab:: Legacy

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 make:command

