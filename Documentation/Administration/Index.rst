:navigation-title: Administration

..  include:: /Includes.rst.txt
..  _administration:

====================
TYPO3 administration
====================

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :card-height: 100

    ..  card:: TYPO3 installation

        This chapter covers topics about :ref:`system-requirements`, :ref:`installation`,
        :ref:`production-settings`, :ref:`deploytypo3` and :ref:`tunetypo3`.

        :ref:`TYPO3 installation <installation_index>`

    ..  card:: :ref:`Deploying TYPO3 <DeployTYPO3>`

        The deployment guide highlights some of solutions available that can
        help automate the process of deploying TYPO3 to
        a remote server.

    ..  card:: :ref:`Running TYPO3 in Docker <admin-docker-index>`

        Learn how to run TYPO3 using Docker containers for local development and testing,
        including step-by-step guides for plain Docker, Docker Compose, and DDEV.

        :ref:`Docker-based TYPO3 setups <admin-docker-index>`

    ..  card:: Common directory structure

        This chapter describes the typical directory structure of a
        `Composer-based <https://docs.typo3.org/permalink/t3coreapi:directory-structure>`_
        and `Classic mode installation <https://docs.typo3.org/permalink/t3coreapi:classic-directory-structure>`_.

        :ref:`Directory structure <directory-structure>`

    ..  card:: Upgrading TYPO3

        The TYPO3 upgrade guide explains how to do patch level updates and how
        to update major Core versions and extensions.

        It also explains how to :ref:`Migrate a TYPO3 project to
        Composer <migratetocomposer>`.

        :ref:`TYPO3 Upgrade Guide <upgrading>`

    .. card:: :ref:`Backup and restore TYPO3 <security-backups>`

        Learn how to create secure, restorable backups of your TYPO3 project.
        Covers essential data, file structure differences, database dumps,
        storage strategies, and long-term retention.

..  toctree::
    :hidden:
    :glob:

    Installation/Index
    Deployment/Index
    Docker/Index
    DirectoryStructure/Index
    VersionControl/Index
    Upgrade/Index
    SystemSettings/Index
    UserManagement/Index
    Backups/Index
    Tuning/Index
    Troubleshooting/Index
    */Index
    *
