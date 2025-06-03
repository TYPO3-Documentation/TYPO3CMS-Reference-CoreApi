:navigation-title: In Production

..  include:: /Includes.rst.txt
..  _tunetypo3:
..  _administation-production:

=======================================
Running TYPO3 in production environments
=======================================

This chapter contains information on how to configure and optimize the infrastructure
running TYPO3 for production.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :card-height: 100

    ..  card:: Security considerations

        Even though TYPO3 follows modern security practices by default,
        system administrators and integrators must take responsibility for
        secure configuration and operations in production environments.

        *   `Security guidelines for system administrators <https://docs.typo3.org/permalink/t3coreapi:security-administrators>`_
        *   `General security guidelines <https://docs.typo3.org/permalink/t3coreapi:security-general-guidelines>`_
        *   `TYPO3 version support and security updates <https://docs.typo3.org/permalink/t3coreapi:security-general-information>`_
        *   `How to detect, analyze, and recover a hacked site <https://docs.typo3.org/permalink/t3coreapi:security-detect-analyze-repair>`_

    ..  card:: Backup and restore TYPO3

        Learn how to create secure, restorable backups of your TYPO3 project.
        Covers essential data, file structure differences, database dumps,
        storage strategies, and long-term retention.

        *   `Backup strategy <https://docs.typo3.org/permalink/t3coreapi:administration-backups>`_

..  toctree::
    :titlesonly:
    :hidden:

    Backups/Index
    Security/Index
    OPcache/Index

..  seealso::

    *   `Recommended production settings <https://docs.typo3.org/permalink/t3coreapi:production-settings>`_
    *   `Deploying TYPO3 <https://docs.typo3.org/permalink/t3coreapi:deployment>`_
    *   `Upgrading the TYPO3 Core and extensions <https://docs.typo3.org/permalink/t3coreapi:upgrading>`_
    *   `Using Docker in production <https://docs.typo3.org/permalink/t3coreapi:docker-production>`_
