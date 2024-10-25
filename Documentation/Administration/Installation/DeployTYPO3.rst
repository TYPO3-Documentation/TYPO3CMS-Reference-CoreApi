..  include:: /Includes.rst.txt

..  index:: deployment, composer, production setup

..  _deploytypo3:
..  _deployment:

===============
Deploying TYPO3
===============

This guide outlines the steps required to manually deploy TYPO3 and ensure the installation
is secure and ready to be used in a production context. This guide also highlights a number of
automation tools that can help automate the deployment process.

There are several different ways to deploy TYPO3. One of the more simple
options is to manually copy its files and database
from a local machine to the live server, adjusting the configuration where
necessary.

..  _deployment-steps:

General Deployment Steps
========================

*   Build the local environment (installing everything necessary for the website)
*   Run :bash:`composer install --no-dev` to install without development dependencies
*   Copy files to the production server
*   Copy the database to the production server
*   Clearing the caches

.. note::

    The :bash:`composer install` command should not be run on the live environment.
    Ideally, Composer should only run locally or on a dedicated deployment machine,
    to allow testing before going live.

    To avoid conflicts between the local and the server's PHP version,
    the server's PHP version can be defined in the :file:`composer.json` file
    (e.g. ``{"platform": {"php": "8.2"}}``), so Composer will always check
    the correct dependencies.

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

    Deployer/Index
    Surf/Index
    Magallanes/Index
