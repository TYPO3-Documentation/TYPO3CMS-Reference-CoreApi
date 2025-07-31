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
`automated deployment <https://docs.typo3.org/permalink/t3coreapi:automated-deployment>`_
using tools is highly recommended.

..  attention::
    We currently work on improving this section. We are very happy about any
    Contribution. There is a project on GitHub:
    `Project: TYPO3 Deployment Guide <https://github.com/orgs/TYPO3-Documentation/projects/26>`_
    dedicated to improving the deployment information.

    Please `Contribute to the TYPO3 documentation <https://docs.typo3.org/permalink/h2document:docs-official-workflow-methods>`_

..  _deployment-what-why:

What is deployment and why do I need it?
========================================

It is recommended to develop TYPO3 projects locally on your computer using Docker,
DDEV, or a local PHP and database installation. At some
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

The following sections contain examples of different types of deployment for TYPO3 projects:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :card-height: 100



    ..  card:: :ref:`Initial deployment <manual-deployment-initial>`

        Manual deployment of a Composer-based installation. Moving your project to the server.

    ..  card:: :ref:`Incremental deployment <manual-deployment-incremental>`

        Manual deployment of a Composer-based installation. Ongoing updates to code or configuration.

    ..  card:: :ref:`Automated deployment <automated-deployment>`

        A description of the "symlink-switching" approach


    ..  card:: :ref:`Environments <multi-stage-environment-workflow>`

        Deploying TYPO3 projects means careful control of different environments.
        This document provides an overview of common environment stages,
        deployment flows, and best practices for managing TYPO3 instances across these stages.

        *   `Configuring environments <https://docs.typo3.org/permalink/t3coreapi:environment-configuration>`_
        *   `Synchronizing database content across environments
            <https://docs.typo3.org/permalink/t3coreapi:multi-stage-environment-database-management>`_
        *   `Synchronizing user-uploaded files across environments
            <https://docs.typo3.org/permalink/t3coreapi:multi-stage-environment-user-upload-management>`_

    ..  card:: :ref:`Tools <deployment-tools>`

        The following tools can be used to deploy TYPO3 either manually or in an automated
        :abbr:`CI (Continuos Integration)` pipeline

        *   `Rsync deployment of TYPO3 <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_
        *   `Deployer for TYPO3 Deployment <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_
        *   `Deploying TYPO3 Using Git and Composer <https://docs.typo3.org/permalink/t3coreapi:deployment-git-composer>`_

    ..  card:: :ref:`CI/CD: Automatic deployment of TYPO3 Projects <ci-cd-for-typo3-projects>`

        **Continuous Integration (CI)** and **Continuous Deployment/Delivery (CD)**
        are development practices that automate the process of building, testing,
        and deploying code.

        *   `Running TYPO3 in production environments <https://docs.typo3.org/permalink/t3coreapi:administation-production>`_
        *   `Backup strategies <https://docs.typo3.org/permalink/t3coreapi:administration-backups>`_
        *   `Security considerations for administrators <https://docs.typo3.org/permalink/t3coreapi:administration-security>`_
        *   `Using Docker in production <https://docs.typo3.org/permalink/t3coreapi:docker-production>`_

    ..  card:: :ref:`Running TYPO3 in Docker <docker-deployment>`

        Learn how to run TYPO3 using Docker containers for local development and testing,
        including step-by-step guides for plain Docker, Docker Compose, and DDEV.



..  toctree::
    :titlesonly:
    :hidden:

    InitialDeployment/Index
    IncrementalDeployment/Index
    AutomatedDeployment/Index
    EnvironmentStages/Index
    Tools/Index
    Automated/Index
    Docker/Index
    */Index
