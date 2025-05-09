:navigation-title: Composer-based Installation

..  include:: /Includes.rst.txt
..  index:: installation, deployment, requirements
..  _installation:
..  _installation-composer:

==============================
Installing TYPO3 with Composer
==============================

..  tip::
    For a tutorial on how to quickly install TYPO3 on DDEV see
    :ref:`Getting Started Guide: Installing TYPO3 with
    DDEV <t3start:installation-ddev-tutorial>`.

This chapter covers each of the steps required to install TYPO3 using Composer.

For more information on how to deploy TYPO3 to a live environment, visit the
:ref:`deploying TYPO3 <DeployTYPO3>` chapter.

.. contents::
   :local:

..  _installation-checklist:

Pre-installation checklist
==========================

*   Command line (CLI) access with the ability to create directories and
    symbolic links.
*   Access to `Composer <https://getcomposer.org>`__ via the CLI (for local
    development)
*   Access to the web server's root directory
*   Database with appropriate credentials

..  _installation-create:

Create the project with Composer
================================

The following command will install TYPO3 v13. If you want to install another
version of TYPO3 find documentation by using the version selector on the left side of this page.

At the root level of your web server, execute the following command:

..  tabs::

    ..  group-tab:: bash

        ..  code-block:: bash

            composer create-project typo3/cms-base-distribution example-project-directory "^13"

    ..  group-tab:: powershell

        ..  code-block:: powershell

            composer create-project "typo3/cms-base-distribution:^13" example-project-directory

    ..  group-tab:: ddev

        ..  code-block:: bash

            # Create a directory for your project
            mkdir example-project-directory

            # Go into that directory
            cd example-project-directory

            # Tell DDEV to create a new project of type "typo3"
            # 'docroot' MUST be set to 'public'
            # At least PHP 8.2 is required by TYPO3 v13. Adapt the PHP version to your needs.
            ddev config --project-type=typo3 --docroot=public --php-version 8.2

            # Start the server
            ddev start

            # Fetch a basic TYPO3 installation and its dependencies
            ddev composer create "typo3/cms-base-distribution:^13"

..  tip::
    The command `composer create-project` expect a completely empty directory. Do not open the project in an
    IDE like PhpStorm before the commands have been executed. IDEs will usually create a hidden folder like
    :path:`.idea` that will cause an error message with the `composer create-project` command.
    `ddev composer create` also works on non-empty paths.


This command pulls down the latest release of the given TYPO3 version and places
it in the :file:`example-project-directory/`.

After this command has finished running, the :file:`example-project-directory/`
folder contains the following files and folders, where :file:`var/`
is added after the first login into the TYPO3 backend:

..  directory-tree::

    *   :path:`public`
    *   :path:`var`
    *   :path:`vendor`
    *   :file:`.gitignore`
    *   :file:`composer.json`
    *   :file:`composer.lock`
    *   :file:`LICENSE`
    *   :file:`README.md`

..  _direct-server-installation-composer:

Install TYPO3 on the server with Composer
=========================================

If you are planning to work directly on the server rather than locally, read chapter
`Installing and using TYPO3 directly on the server <https://docs.typo3.org/permalink/t3coreapi:direct-server-workflow>`_,
expecially the `Quick wins & caution flags <https://docs.typo3.org/permalink/t3coreapi:direct-server-workflow-pro-con>`_.

If Composer is available, installation is simple. If not, you may
need to find or install it. See :ref:`direct-server-composer-access`.

.. code-block:: bash

    composer create-project "typo3/cms-base-distribution:^13.4" my-new-project

If the `composer` command doesn't work, check the command path or install it.
See :ref:`Finding or installing Composer <direct-server-composer-access>`_.

Once the project is created, continue with
`Setup TYPO3 <https://docs.typo3.org/permalink/installation-setup>`_.

..  note::

    Composer can be run directly on the server, but it may break your site if
    something goes wrong. Always make a backup, especially of
    :file:`composer.json` and :file:`composer.lock`, or, even better, use Git for
    version control.

..  tip::

    If you are not ready to learn Composer or Git yet, that's okay. TYPO3 still
    works for small sites without these. `Install TYPO3 in the classic mode <https://docs.typo3.org/permalink/t3coreapi:classic-installation>`_
    now and you can improve your setup later.

..  _installation-setup:

Run the setup process
=====================

..  _installation-setup-cli:

Setup TYPO3 in the console
--------------------------

..  versionadded:: 12.1
    A :ref:`CLI command <t3coreapi:symfony-console-commands>` `setup` has
    been introduced as an alternative to the existing
    :abbr:`GUI (Graphical User Interface)`-based web installer.

Interactive / guided setup (questions/answers):

..  tabs::

    ..  group-tab:: bash

        ..  code-block:: bash

            # Use console command to run the install process
            # or use the Install Tool GUI (See below)
            ./vendor/bin/typo3 setup

    ..  group-tab:: powershell

        ..  code-block:: powershell

            # Use console command to run the install process
            # or use the Install Tool GUI (See below)
            ./vendor/bin/typo3 setup

    ..  group-tab:: ddev

        ..  code-block:: bash

            # Use console command to run the install process
            # or use the Install Tool GUI (See below)
            ddev exec ./vendor/bin/typo3 setup

..  _installation-setup-gui:

Or use the GUI installer in the browser
---------------------------------------

Create an empty file called `FIRST_INSTALL` in the `public/` directory:

..  tabs::

    ..  group-tab:: bash

        ..  code-block:: bash

            touch example-project-directory/public/FIRST_INSTALL

    ..  group-tab:: powershell

        ..  code-block:: powershell

            echo $null >> public/FIRST_INSTALL

    ..  group-tab:: ddev

        ..  code-block:: bash

            ddev exec touch public/FIRST_INSTALL


..  directory-tree::

    *   :path:`public`

        *   :file:`FIRST_INSTALL`

    *   :path:`var`
    *   :path:`vendor`
    *   :file:`.gitignore`
    *   :file:`composer.json`
    *   :file:`composer.lock`
    *   :file:`LICENSE`
    *   :file:`README.md`

..  _install-access-typo3-via-a-web-browser:

Access TYPO3 via a web browser
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

After you have configured your web server to point at the `public` directory of
your project, TYPO3 can be accessed via a web browser. When accessing a new site
for the first time, TYPO3 automatically redirects all requests to
:samp:`/typo3/install.php` to complete the installation process.

..  tip::
    When accessing the page via HTTPS, a "Privacy error" or similar warning is
    likely to occur. In a local environment it is safe to ignore this warning by
    forcing the browser to ignore similar exceptions for this domain.

    The warning is due to the fact that self-signed certificates are being used.

    If there is a :ref:`trustedHostsPattern <t3coreapi:typo3ConfVars_sys_trustedHostsPattern>`
    error on initial access, accessing TYPO3 without HTTPS (`http://`) is also
    an option.

..  _install-scan-environment:

Scan environment
~~~~~~~~~~~~~~~~

TYPO3 will now scan the host environment. During the scan TYPO3 will check the
host system for the following:

*   Minimum required version of PHP is installed.
*   Required PHP extensions are loaded.
*   :file:`php.ini` is configured.
*   TYPO3 is able to create and delete files and directories within the
    installation's root directory.

If no issues are detected, the installation process can continue.

In the event that certain criteria are not met, TYPO3 will display a list of
issues it has detected accompanied by a resolution for each issue.

Once changes have been made, TYPO3 can re-scan the host environment by reloading
the page :samp:`https://example-project-site.local/typo3/install.php`.

..  include:: /Images/AutomaticScreenshots/QuickInstall/Step1SystemEnvironment.rst.txt

..  _install-select-db:

Select a database
~~~~~~~~~~~~~~~~~

Select a database connection driver and enter the credentials for the database.

..  include:: /Images/AutomaticScreenshots/QuickInstall/Step2DatabaseConnection.rst.txt

TYPO3 can either connect to an existing empty database or create a new one.

The list of databases available is dependent on which database drivers are installed on the host.


For example, if an instance of TYPO3 is intended to be used with a MySQL database then the PHP extension `pdo_mysql` is required.
Once it is installed, :guilabel:`MySQL Database` will be available as an option.


..  include:: /Images/AutomaticScreenshots/QuickInstall/Step3ChooseDb.rst.txt

..  _install-create-admin:

Create administrative user & set site name
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

An administrator account needs to be created to gain access to TYPO3's backend.

An email address for this user can also be specified and a name can be given.

..  include:: /Images/AutomaticScreenshots/QuickInstall/Step4AdminUserSitename.rst.txt

..  note::
    The password must comply with the configured
    :ref:`password policy <t3coreapi:password-policies>`.

..  _install-initialize:

Initialize
----------

TYPO3 offers two options for initialisation: creating an empty starting page or
it can go directly to the backend administrative interface.

Beginners should
select the first option and allow TYPO3 to create an empty starting page.
This will also generate a site configuration file.

..  include:: /Images/AutomaticScreenshots/QuickInstall/Step5LastStep.rst.txt

..  _install-ddev:

Using DDEV
----------

A step-by-step tutorial is available on how to
:ref:`Install TYPO3 using DDEV <t3start:installation-ddev-tutorial>`.
The tutorial also includes a video.
