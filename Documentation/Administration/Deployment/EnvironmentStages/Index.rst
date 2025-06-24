:navigation-title: Environments

.. include:: /Includes.rst.txt

.. index:: Deployment; Environment workflow; Staging; Production; Best practices

.. _multi-stage-environment-workflow:

==========================================
Multi-stage environment workflow for TYPO3
==========================================

TYPO3 projects typically move through several stages on their way from
development to production. This document provides an overview of common
environment stages, deployment flows, and best practices for managing TYPO3
instances across these stages.

Separating your TYPO3 project into multiple environments allows you to:

*   Develop and test changes safely without impacting the live site.
*   Collaborate in a team across shared environments.
*   Perform client acceptance testing on a production-like system.
*   Promote stable changes toward production in a controlled manner.

..  contents:: Table of contents

..  toctree::
    :caption: Subchapters
    :titlesonly:

    Configuration/Index
    Database/Index
    UserUpload/Index

.. _multi-stage-environment-stages:

Common environments in multi-stage deployment workflow
======================================================

.. _multi-stage-environment-local:

Local development
-----------------

Individual developers work on their local machines using tools such as
`ddev`, Docker, or LAMP stacks. This stage is ideal for:

*   Developing new features or bug fixes.
*   Running automated tests.
*   Experimenting without affecting others.

.. _multi-stage-environment-integration:

Integration / development environment
-------------------------------------

A shared environment where multiple developers push and integrate their
changes. Useful for:

*   Team-wide integration testing.
*   Early feedback loops.
*   Continuous integration pipelines.

.. _multi-stage-environment-staging:

Staging / pre-production environment
------------------------------------

A production-like environment for:

*   Client or stakeholder acceptance testing.
*   Verifying deployment procedures.
*   Performance or load testing.

.. _multi-stage-environment-production:

Production / live environment
-----------------------------

The final, customer-facing live site. Key requirements include:

*   High availability.
*   Security hardening.
*   Data integrity and performance optimization.

.. _multi-stage-environment-best-practices:

Best practices
==============

*   Mirror production as closely as possible in staging.
*   Isolate environment-specific configuration.
*   Never use real production data in earlier stages without proper
    anonymization.
*   Automate deployment and testing where possible.
*   Control access to non-production environments.

Separating your TYPO3 project into multiple environments helps ensure
reliable development and deployment workflows. Combine this conceptual
workflow with TYPO3’s environment configuration features for maximum
flexibility and security.

..  seealso::

    -   :ref:`Configuring environments <environment-configuration>`
    -   :ref:`Synchronizing database content <multi-stage-environment-database-management>`
    -   :ref:`Synchronizing user-uploaded files <multi-stage-environment-user-upload-management>`
