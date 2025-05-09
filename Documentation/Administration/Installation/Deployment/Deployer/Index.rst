:navigation-title: Deployer

..  include:: /Includes.rst.txt
..  index:: Deployment; Deployer
..  _deployment-deployer:

=============================
Deployer for TYPO3 Deployment
=============================

`Deployer <https://deployer.org>`__ is a deployment tool written in PHP.
Internally Deployer uses `Rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_.

Deployer can be used to create recipes that automatically execute the required
deployment steps.

..  _deployer-recipes:

Deployer recipes for TYPO3
==========================

..  _deployer-SourceBroker:

SourceBroker's Deployer Extended TYPO3
--------------------------------------

This comprehensive recipe extends Deployer's capabilities for TYPO3 projects.
It includes advanced features like database and file synchronization,
multi-environment support, and integration with TYPO3 Console.

See: `sourcebroker/deployer-extended-typo3 <https://github.com/sourcebroker/deployer-extended-typo3>`_.

..  _deployer-helhum:

Helhum Deployer recipe
----------------------

You can use the `TYPO3 Deployer Recipe <https://github.com/helhum/typo3-deployer-recipe/>`_
from Helhum, fork it, and adjust it to your needs.

..  _deployer-gitlab:

GitLab template Deployer recipe for TYPO3
-----------------------------------------

If you **created** your project using the
`official GitLab template <https://docs.typo3.org/permalink/t3start:gitlab-template>`_,
it already contains a Deployer template.

You can configure Deployer by adjusting the YAML configuration file
:file:`deploy.yaml` in the project root. The actual Deployer recipe is found in
:file:`packages/site-distribution/Configuration/DeployerRsync.php`.

The project also contains a :file:`.gitlab-ci.yml` for automated deployments.

To start using Deployer, adjust :file:`deploy.yaml` like this:

..  literalinclude:: _gitlab-deploy.yaml
    :caption: .gitlab-ci.yml

..  _deployer-official:

Official Deployer recipe for TYPO3 <= 11.5
------------------------------------------

..  attention::
    This recipe can only be used up to TYPO3 version 11.5.

The documentation of Deployer provides an
`official TYPO3 (classic mode) Deployer recipe <https://deployer.org/docs/8.x/recipe/typo3>`_.

However, this recipe is designed for TYPO3 projects **up to version 11.5**,
using the **classic directory structure**.
For newer TYPO3 versions using Composer-based setups, this recipe requires manual adjustments.

..  _deployer-ddev:

Manual deployment from DDEV
===========================

For manual deployment from DDEV, authenticate your server’s SSH key, for example
with `ddev auth ssh` (see the
`DDEV documentation: SSH Into Containers <https://ddev.readthedocs.io/en/stable/users/usage/cli/#interacting-with-your-project>`_).

Install Deployer in your project using Composer:

..  code-block:: bash

    ddev composer require --dev deployer/deployer

Run the following command to list all available Deployer tasks:

..  code-block:: bash

    ddev exec vendor/bin/dep list

Choose and adjust a suitable :ref:`deployer recipe for TYPO3 <deployer-recipes>`
for your project. You can then deploy to your staging server with:

..  code-block:: bash

    ddev exec vendor/bin/dep deploy -vvv staging

This assumes you have defined a staging server in your :file:`deploy.yaml` configuration.

..  _deployer-local:

Manual deployment outside of DDEV
=================================

Deployer can also be run directly on your local machine or in other environments,
such as Docker or native PHP setups, without using DDEV.

First, install Deployer globally with Composer:

..  code-block:: bash

    composer global require deployer/deployer

Make sure the global Composer `vendor/bin` directory is in your system’s `PATH`.

You can then list available tasks with:

..  code-block:: bash

    dep list

And deploy to a configured environment, for example:

..  code-block:: bash

    dep deploy -vvv staging

Refer to your :file:`deploy.yaml` or :file:`deploy.php` for environment and
task definitions.

..  _deployer-automatic:

Automatic deployment via CI/CD
==============================

Deployer can be integrated into automated deployment pipelines,
such as GitLab CI/CD, GitHub Actions, or other CI systems.

For example, the `official TYPO3 GitLab template <https://docs.typo3.org/permalink/t3start:gitlab-template>`_
already includes a :file:`.gitlab-ci.yml` file with deployment stages.

You can configure these stages to deploy automatically when code is pushed
to your repository.

..  _deployer-ssh-requirements:

SSH requirements of Deployer
============================

Deployer connects to your servers via SSH. You must ensure that your
deployment user has passwordless SSH access to the target server.

You can test SSH access with:

..  code-block:: bash

    ssh <your-ssh-user>@<your-server>

If you can connect without entering a password, SSH is correctly set up.

You typically manage your SSH key via your local SSH agent, for example:

..  code-block:: bash

    eval $(ssh-agent -s)
    ssh-add ~/.ssh/id_rsa

You may also need to add your server to the known hosts:

..  code-block:: bash

    ssh-keyscan <your-server> >> ~/.ssh/known_hosts
