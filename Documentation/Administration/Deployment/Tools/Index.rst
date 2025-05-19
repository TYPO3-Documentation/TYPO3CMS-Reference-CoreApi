:navigation-title: Tools

..  include:: /Includes.rst.txt
..  _deployment-tools:

================
Deployment tools
================

The following tools can be used to deploy TYPO3 either manually or in an automated
:abbr:`CI (Continuos Integration)` pipeline.

..  toctree::
    :titlesonly:

    Rsync/Index
    Deployer/Index
    GitComposer/Index
    */Index

..  _deployment-tools-comparision:

Comparison of deployment tools
==============================

..  t3-field-list-table::
    :header-rows: 1

    -   :Method: Method
        :Pros: Pros
        :Cons: Cons
        :Typical Use Cases: Typical Use Cases

    -   :Method: Git + Composer
        :Pros:
            - Simple setup
            - No extra tooling needed
            - Version control on server
        :Cons:
            - Composer and Git must be installed on production server
            - Possible downtime during install
            - Risk of untracked local changes on server
            - Deployment may fail if external package sources are temporarily unavailable
        :Typical Use Cases:
            - Small to medium projects
            - Developers familiar with CLI
            - Environments without CI/CD tooling

    -   :Method: Deployer
        :Pros:
            - Atomic deployment with rollback
            - Zero-downtime deployments
            - Keeps release history
        :Cons:
            - Additional tool to learn and configure
            - Deployment process might be too complex for beginners
        :Typical Use Cases:
            - Professional production environments
            - Teams with CI/CD pipelines
            - Projects requiring rollback capabilities

    -   :Method: Manual rsync
        :Pros:
            - No requirement for Composer/Git
            - Simple file transfer
        :Cons:
            - Requires staging/build environment
            - Risk of partial updates if interrupted
            - No version tracking on the server
        :Typical Use Cases:
            - Static file transfer or legacy systems
            - Environments without PHP/Composer tooling on production

    -   :Method: No Deployment (Direct Installation on Server)
        :Pros:
            - No deployment tooling required
            - Easy to get started for single updates
        :Cons:
            - No version control or rollback possible
            - High risk of human error
            - No automation, no reproducibility
        :Typical Use Cases:
            - Very small or legacy projects
            - One-time manual updates
            - Not recommended for professional environments

..  rubric:: Summary:

-   **Git + Composer**: Easy but requires server-side tooling.
-   **Deployer**: Advanced, safe, and rollback-friendly but requires extra setup.
-   **Manual rsync**: Simple file sync, but requires external build or packaging steps.
-   **No Deployment (Direct Installation on Server**): Easy to get started, but risky, untracked, and not recommended for professional environments.

Select the method that best suits your workflow and server capabilities.

..  _deployment-magallanes:
..  _deployment-typo3-surf:

Other deployment tools
======================

*   :doc:`TYPO3 Surf <ext_surf:Index>` was formerly commonly used as a TYPO3 deployment tool.
    It has now mostly been succeeded by
    `Deployer <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_.
*   Another deployment tool for PHP applications written in PHP: https://www.magephp.com/
