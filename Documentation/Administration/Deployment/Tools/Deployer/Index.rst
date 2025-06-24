:navigation-title: Deployer

..  include:: /Includes.rst.txt
..  index:: Deployment; Deployer
..  _deployment-deployer:

=============================
Deployer for TYPO3 Deployment
=============================

`Deployer <https://deployer.org>`__ is a deployment tool written in PHP.
Internally Deployer uses `Rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_.

Deployer can be used to create recipes that automate execution of the
deployment steps.

..  contents::

..  _deployer-recipes:

Deployer recipes for TYPO3
==========================

..  _deployer-SourceBroker:

SourceBroker's Deployer - Extended TYPO3
----------------------------------------

This recipe extends Deployer's capabilities to cover TYPO3 projects.
It includes advanced features like database and file synchronization,
multi-environment support, and integration with the TYPO3 Console.

See: `sourcebroker/deployer-extended-typo3 <https://github.com/sourcebroker/deployer-extended-typo3>`_.

..  _deployer-helhum:

Helhum Deployer recipe
----------------------

This `TYPO3 Deployer Recipe <https://github.com/helhum/typo3-deployer-recipe/>`_
from Helhum can be forked and adapted to your needs.

..  _deployer-gitlab:

GitLab template Deployer recipe for TYPO3
-----------------------------------------

If you have **created** your project using the
`official GitLab template <https://docs.typo3.org/permalink/t3start:gitlab-template>`_,
it will already contain a Deployer template.

You can configure Deployer by editing the YAML configuration file
:file:`deploy.yaml` in the project root. The `Deployer recipe <https://gitlab.com/gitlab-org/project-templates/typo3-distribution/-/blob/main/packages/site-distribution/Configuration/DeployerRsync.php?ref_type=heads>`_
is found in
:file:`packages/site-distribution/Configuration/DeployerRsync.php`.

The project also contains a :file:`.gitlab-ci.yml` for automated deployment.

To start using Deployer, :file:`deploy.yaml` should look like this:

..  literalinclude:: _gitlab-deploy.yaml
    :caption: deploy.yaml

..  _deployer-official:

Official Deployer recipe for TYPO3 <= 11.5
------------------------------------------

..  attention::
    This recipe can only be used for TYPO3 versions up to 11.5.

The Deployer documentation describes an
`official TYPO3 (classic mode) Deployer recipe <https://deployer.org/docs/8.x/recipe/typo3>`_.

However, this recipe is only correct for TYPO3 projects **up to version 11.5**,
using the **classic directory structure**.
For newer TYPO3 versions with Composer-based setups, this recipe requires manual changes.

..  _deployer-ddev:

Manual deployment from DDEV
===========================

For manual deployment from DDEV, authenticate your server’s SSH key, for example
with `ddev auth ssh` (see the
`DDEV documentation: SSH Into Containers <https://ddev.readthedocs.io/en/stable/users/usage/cli/#interacting-with-your-project>`_).

Install Deployer in your project using Composer:

..  code-block:: bash

    ddev composer require --dev deployer/deployer

List available Deployer tasks:

..  code-block:: bash

    ddev exec vendor/bin/dep list

Choose (and make any necessary changes to) a suitable :ref:`deployer recipe <deployer-recipes>`
for your project. Then deploy to your staging server:

..  code-block:: bash

    ddev exec vendor/bin/dep deploy -vvv staging

This assumes you have defined a staging server in your :file:`deploy.yaml` configuration.

..  _deployer-local:

Manual deployment outside of DDEV
=================================

Deployer can be run on your local machine or in other environments
(Docker or native PHP setups) without using DDEV.

First, install Deployer globally using Composer:

..  code-block:: bash

    composer global require deployer/deployer

Make sure the global Composer `vendor/bin` directory is in your system’s `PATH`.

Then list available tasks with:

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
such as GitLab CI/CD, `GitHub Actions <https://docs.typo3.org/permalink/t3coreapi:ci-cd-github>`_, and other CI systems.

For example, the `official TYPO3 GitLab template <https://docs.typo3.org/permalink/t3start:gitlab-template>`_
includes a :file:`.gitlab-ci.yml` file with deployment stages.

You can configure these stages for automated deployment each time code is pushed
to your repository.

..  _deployer-ssh-requirements:

Deployer's SSH requirements
===========================

Deployer will connect to your servers via SSH. You must ensure that your
deployment user has passwordless SSH access to the target server.

You can test SSH access with:

..  code-block:: bash

    ssh <your-ssh-user>@<your-server>

If you can connect without entering a password, SSH is correctly set up.

Typically your SSH key is managed via your local SSH agent, for example:

..  code-block:: bash

    eval $(ssh-agent -s)
    ssh-add ~/.ssh/id_rsa

You may also need to add your server to the known hosts file:

..  code-block:: bash

    ssh-keyscan <your-server> >> ~/.ssh/known_hosts
