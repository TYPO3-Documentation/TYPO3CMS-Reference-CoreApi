:navigation-title: Automated deployment

..  include:: /Includes.rst.txt

.. index:: Deployment; Automated deployment;

..  _automated-deployment:

====================
Automated Deployment
====================

A typical setup for deploying web applications consists of three different parts:

*   The local environment (for development)
*   The build environment (for reproducible builds). This can be a controlled local environment or a remote continuous integration server (for example Gitlab CI or Github Actions)
*   The live (production) environment

To get an application from the local environment to the production system, the usage of a deployment tool and/or a continuous integration solution is recommended. This ensures that only version-controlled code is deployed and that builds are reproducible. Ideally setting a new release live will be an atomical operation and lead to no downtime. If there are errors in any of the deployment or test stages, most deployment tools will initiate an automatic "rollback" preventing that an erroneous build is released.

One widely employed strategy is the "symlink-switching" approach:

In that strategy, the webserver serves files from a virtual path
:path:`releases/current/public` which consists of a symlink
:path:`releases/current` pointing to the latest deployment ("release"). That
symlink is changed after a new release has been successfully prepared.
The latest deployment contains symlinks to folders that are common to all releases (commonly called "shared folders").

Usually the database is shared between releases and upgrade wizards and schema upgrades are run automatically before or
shortly after the new release has been set to live.

This is an example directory structure of a "symlink-switching" TYPO3 installation:

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
                *   :path:`fileadmin -> ../../../shared/public/fileadmin` (symlink)
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

The following sections contain examples of various deployment tools and how they can be configured to use TYPO3:
