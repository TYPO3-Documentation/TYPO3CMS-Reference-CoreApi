:navigation-title: Git and Composer

..  include:: /Includes.rst.txt
..  _deployment-git-composer:

======================================
Deploying TYPO3 Using Git and Composer
======================================

This guide describes how to deploy a TYPO3 project directly onto your server
using **Git** and **Composer**, without the need for additional deployment tools.

This method is **simple to set up** and **requires no external deployment services**,
but it does require **Git and Composer to be installed on the server** and may cause
**downtime during updates**.

For a detailed comparison with other deployment methods, including **Deployer**
and **rsync**, see section
`Comparison of deployment methods <https://docs.typo3.org/permalink/t3coreapi:deployment-tools-comparision>`_.

..  _deployment-git-composer-quick:

Quick start: Deploy with Git and Composer
=========================================

Execute the following in the folder into which your project was originally
:ref:`cloned <deployment-git-composer-clone>`. The folder must
contain the :path:`.git` directory.

..  code-block:: bash

    cd /var/www/your-project
    git pull
    composer install --no-dev
    vendor/bin/typo3 database:updateschema
    vendor/bin/typo3 cache:flush

This performs a basic update of your project code and dependencies in production
mode.

See also chapter `Finding or installing Composer on the server <https://docs.typo3.org/permalink/t3coreapi:direct-server-composer-access>`_.

..  _deployment-git-composer-detailed:

Detailed deployment instructions
================================

The following sections explain the deployment process step by step.

Prerequisites:

-   The TYPO3 project is under version control using Git. See chapter
    `Version control of TYPO3 projects with Git <https://docs.typo3.org/permalink/t3coreapi:version-control>`_
-   `TYPO3 was installed using Composer <https://docs.typo3.org/permalink/t3coreapi:installation-composer>`_
-   The server has **PHP**, **Composer**, **Git**, and other required system packages installed.
-   **Shell (SSH) access** to the server to run deployment commands.

..  _deployment-git-composer-clone:

Step 1: Clone or update the repository
--------------------------------------

**First-time setup:**

..  code-block:: bash

    git clone <your-git-repository-url> /var/www/your-project
    cd /var/www/your-project

**On subsequent deployments:**

..  code-block:: bash

    cd /var/www/your-project
    git pull

..  _deployment-git-composer-install:

Step 2: Install production dependencies
---------------------------------------

Install only production-relevant packages by running:

..  code-block:: bash

    composer install --no-dev --ignore-platform-reqs

Parameter `--no-dev` excludes development packages. If the PHP version running
on the console and the PHP version running on the server differ, you may need 
to use `--ignore-platform-reqs` to skip platform checks.

..  _deployment-git-composer-commands:

Step 3: Run TYPO3 maintenance commands
--------------------------------------

Apply database schema updates if required:

..  code-block:: bash

    vendor/bin/typo3 database:updateschema

Clear TYPO3 caches:

..  code-block:: bash

    vendor/bin/typo3 cache:flush

Optional: Run project-specific tasks as needed.
