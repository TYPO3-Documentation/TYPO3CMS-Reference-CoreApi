:navigation-title: Deployment

..  include:: /Includes.rst.txt
..  index:: deployment, composer, production setup

..  _deploytypo3:
..  _deployment:

===============
Deploying TYPO3
===============

This guide explains how to deploy a TYPO3 project to a production environment
securely and efficiently. It covers both **manual** deployment and
**automated** strategies using deployment tools.

TYPO3 can be deployed in various ways. A common and simple approach is to
copy files and the database from a local environment to the live server.

However, for larger or more professional projects,
`automated deployments <https://docs.typo3.org/permalink/t3coreapi:deployment-automatic>`_
using tools are highly recommended.

..  attention::
    We currently work on improving this section. We are very happy about any
    Contribution. There is a project on GitHub:
    `Project: TYPO3 Deployment Guide <https://github.com/orgs/TYPO3-Documentation/projects/26>`_
    dedicated to improving the deployment information.

    Please `Contribute to the TYPO3 documentation <https://docs.typo3.org/permalink/h2document:docs-official-workflow-methods>`_

..  contents:: Table of contents

..  _deployment-what-why:

What is deployment and why do I need it?
========================================

It is recommended to develop TYPO3 projects locally on your computer using, for
example, Docker, DDEV, or a local PHP and database installation. At some
point you will want to transfer your work to the server for a first
initial deployment, which can be done manually or semi-manually.

As time goes on, you will fix bugs, prepare updates and develop
new features on your local computer. These changes will then need
to be transferred to the server. This can
be done manually or can be automated.

Deployment can only be avoided if you `Install and use TYPO3 directly on the
server <https://docs.typo3.org/permalink/t3coreapi:direct-server-workflow>`_,
which comes with a number of `Quick wins &
pitfalls <https://docs.typo3.org/permalink/t3coreapi:direct-server-workflow-pro-con>`_.

..  _deployment-steps:
..  _manual-deployment:

Manual deployment of a Composer-based installation
==================================================

The deployment process for TYPO3 can be divided into two parts:

1.  **Initial Deployment** – the first time the project is set up on the
    server.
2.  **Regular Deployment** – ongoing updates to code or configuration.

..  _manual-deployment-initial:

Initial deployment
------------------

This is the first deployment of TYPO3 to a production environment. It includes
setting up the full application, database, and user-generated content.

Steps:

#.  Build the project locally:

    ..  code-block:: bash

        composer install --no-dev

#.  Export the local database using `mysqldump <https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html>`_,
    `ddev export-db <https://ddev.readthedocs.io/en/stable/users/cli-usage/>`_,
    or a GUI-based tool like Heidi SQL or phpmyadmin.

    ..  tabs::

        ..  group-tab:: Linux / macOS / WSL

            ..  code-block:: bash

                mysqldump -u <user> -p -h <host> <database_name> > dump.sql

        ..  group-tab:: DDEV

            ..  code-block:: bash

                ddev export-db --file=dump.sql

#.  Transfer all necessary files to the server.

    Folders to include:

    -   :path:`public/`
    -   :path:`config/`
    -   :path:`vendor/`,
    -   Files from the project directory: :file:`composer.json`, :path:`composer.lock`

    You can speed up the transfer using archive tools like zip or tar, or use
    `rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_.

#.  Import the database on the production server, for example using
    `mysql <https://dev.mysql.com/doc/refman/8.0/en/mysql.html>`_:

    ..  code-block:: bash

        mysql -u <user> -p -h <host> <database_name> < dump.sql

    ..  note::

        You will be prompted to enter the MySQL user password. Make sure the
        target database exists before running this command.

#.  Set up shared and writable directories on the server:

    -   :path:`public/fileadmin/`
    -   :path:`var/`

#.  Adjust web server configuration:

    -   Set the document root to `public/`
    -   Ensure correct permissions for writable folders

#.  Flush TYPO3 caches:

    .. code-block:: bash

        ./vendor/bin/typo3 cache:flush

..  note::

    You can use the `Admin Tools <https://docs.typo3.org/permalink/t3start:admin-tools>`_
    to verify folder permissions and environment compatibility.
    Open: `https://example.org/typo3/install.php` and go to
    the **System Environment** section.

..  _manual-deployment-regular:

Regular deployment
------------------

After the initial deployment, regular deployments are used to update code and
configuration.

Steps:

#.  Prepare the updated version locally:

    -   Apply code or configuration changes
    -   Run:

        ..  code-block:: bash

            composer install --no-dev

#.  Transfer only updated files to the server.

    Include:

    -   `public/` (excluding `fileadmin/`, `uploads/`)
    -   `config/`
    -   `vendor/`
    -   `composer.lock`
    -   etc.

    Do not include dynamic or environment-specific files such as:

    -   :path:`var/`, :path:`public/fileadmin/`, (these are managed on the server)

    You can speed up the transfer using archive tools like zip or tar, or use
    `rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_
    to copy only changed files.

3.  If database changes are required:

    -   Run the Upgrade Wizard in the TYPO3 backend
    -   Or apply schema changes via CLI tools

4.  Flush TYPO3 caches:

    .. code-block:: bash

        ./vendor/bin/typo3 cache:flush

..  note::

    Use a deployment script or tool such as
    `rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_ or
    `Deployer <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_
    to automate regular deployments and avoid overwriting persistent data.


..  _deployment-automatic:

Deployment Automation
=====================

A typical setup for deploying web applications consists of three different parts:

*   The local environment (for development)
*   The build environment (for reproducible builds). This can be a controlled local environment or a remote continuous integration server (for example Gitlab CI or Github Actions)
*   The live (production) environment

To get an application from the local environment to the production system, the usage of a deployment tool and/or a continuous integration solution is recommended. This ensures that only version-controlled code is deployed and that builds are reproducible. Ideally setting a new release live will be an atomical operation and lead to no downtime. If there are errors in any of the deployment or test stages, most deployment tools will initiate an automatic "rollback" preventing that an erroneous build is released.

One widely employed strategy is the "symlink-switching" approach:

In that strategy, the webserver serves files from a virtual path :path:`releases/current/public` which consists of a symlink :path:`releases/current` pointing to the latest deployment ("release"). That symlink is switched after a new release has been successfully prepared.
The latest deployment contains symlinks to folders that should be common among all releases (commonly called "shared folders").

Usually the database is shared between releases and upgrade wizards and schema upgrades are run automatically before or
shortly after the new release has been set live.

This is an exemplatory directory structure of a "symlink-switching" TYPO3 installation:

..  directory-tree::

    *   :path:`shared`

        *   :path:`fileadmin`
        *   :path:`var`

            *   :path:`charset`
            *   :path:`lock`
            *   :path:`log`
            *   :path:`session`

    *   :path:`releases`

        *   :path:`current -> ./release1` (symlink to current release)
        *   :path:`release1`

            *   :path:`public` (webserver root, via releases/current/public)

                *   :path:`typo3conf`
                *   :path:`fileadmin -> ../../../shared/fileadmin` (symlink)
                *   :file:`index.php`

            *   :path:`var`

                *   :path:`build`
                *   :path:`cache`
                *   :path:`charset -> ../../../shared/var/charset` (symlink)
                *   :path:`labels`
                *   :path:`lock -> ../../../shared/var/lock` (symlink)
                *   :path:`log -> ../../../shared/var/log` (symlink)
                *   :path:`session -> ../../../shared/var/session` (symlink)

            *   :path:`vendor`
            *   :file:`composer.json`
            *   :file:`composer.lock`


The files in :path:`shared` are shared between different releases of a web site.
The :path:`releases` directory contains the TYPO3 code that will change between the release of each version.

When using a deployment tool this kind of directory structure is usually created automatically.

The following section contains examples for various deployment tools and how they can be configured to use TYPO3:

..  toctree::
    :titlesonly:

    EnvironmentStages/Index
    Tools/Index
    Automated/Index
    Docker/Index
    */Index
