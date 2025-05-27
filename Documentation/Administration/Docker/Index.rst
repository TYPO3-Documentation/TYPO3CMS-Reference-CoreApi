:navigation-title: Docker

..  include:: /Includes.rst.txt
..  _admin-docker-index:

=======================
Running TYPO3 in Docker
=======================

This section explains how to run TYPO3 in Docker-based environments for
**local development and testing**.

We provide step-by-step guides for:

-   Using `plain Docker commands <https://docs.typo3.org/permalink/t3coreapi:classic-docker-installation>`_
-   Running TYPO3 with `Docker Compose <https://docs.typo3.org/permalink/t3coreapi:docker-compose-typo3>`_
-   Extending the community-maintained `Docker image <https://docs.typo3.org/permalink/t3coreapi:docker-extend-image>`_
-   `Automating TYPO3 installation using the CLI <https://docs.typo3.org/permalink/t3coreapi:docker-cli-automated-setup>`_

Many TYPO3 projects use `DDEV for development <https://docs.typo3.org/permalink/t3start:install>`_,
which automates Docker setup and configuration.
This section helps you understand the underlying processes that DDEV manages
for you, such as container creation, service networking, volume mounting, and
port mapping.

If you are new to Docker, we recommend starting with the plain Docker setup
first. It explains each step manually and helps you understand how containers,
networking, and volumes work. Once you are familiar with these concepts, the
Docker Compose setup will be easier to follow and you will better understand
what it automates.

These examples help you understand how TYPO3 works in containers. They are
intended for local use and **not recommended for production** as-is.

For an overview of production-related considerations, see
:ref:`docker-production`.

..  toctree::
    :titlesonly:
    :hidden:

    DockerDemo/Index
    DockerComposeDemo/Index
    ExtendImage/Index
    AutomateSetup/Index
    Production/Index
