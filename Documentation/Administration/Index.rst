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

    ..  card:: Installation

        Learn about the different ways to install TYPO3 and choose the method
        that best matches your technical requirements and experience level.

        *   `TYPO3 installation overview <https://docs.typo3.org/permalink/t3coreapi:installation-index>`_
        *   `Composer-based <https://docs.typo3.org/permalink/t3coreapi:installation-composer>`_
        *   `Classic mode <https://docs.typo3.org/permalink/t3coreapi:classic-installation>`_
        *   `Download TYPO3 (ZIP/TAR) <https://get.typo3.org/#download>`_

    ..  card:: Deployment

        The deployment guide highlights some of solutions available that can
        help automate the process of deploying TYPO3 to
        a remote server.

        *   `Deploying TYPO3 <https://docs.typo3.org/permalink/t3coreapi:deployment>`_
        *   `Configuring environments <https://docs.typo3.org/permalink/t3coreapi:environment-configuration>`_
        *   `CI/CD and Automatic deployment <https://docs.typo3.org/permalink/t3coreapi:ci-cd-for-typo3-projects>`_

    ..  card:: :ref:`Running TYPO3 in Docker <admin-docker-index>`

        Learn how to run TYPO3 using Docker containers for local development and testing,
        including step-by-step guides for plain Docker, Docker Compose, and DDEV.

        :ref:`Docker-based TYPO3 setups <admin-docker-index>`

    ..  card:: Directory structure

        The folder layout of your TYPO3 project depends on how TYPO3 was installed.
        Composer-based installations use a modern structure that separates code from
        public files—ideal for deployment workflows and version control. Classic mode
        keeps everything in a single folder and is easier to set up for beginners.

        Both methods are fully supported for production use, however there are
        security consideration regarding
        `file access <https://docs.typo3.org/permalink/t3coreapi:security-restrict-access-server-level>`_
        when using the classic structure.

        *   `Directory structure, Composer <https://docs.typo3.org/permalink/t3coreapi:directory-structure>`_
        *   `Directory structure, Classic mode <https://docs.typo3.org/permalink/t3coreapi:classic-directory-structure>`_

    ..  card:: Updates

        Learn how to apply patch-level updates, perform major version upgrades, and update extensions safely.

        *   `Bugfix / security update (Composer) <https://docs.typo3.org/permalink/t3coreapi:minor>`_
        *   `Major upgrade (Composer) <https://docs.typo3.org/permalink/t3coreapi:major>`_
        *   `Applying Core patches <https://docs.typo3.org/permalink/t3coreapi:applying-core-patches>`_
        *   `Classic-mode upgrade <https://docs.typo3.org/permalink/t3coreapi:legacy>`_
        *   `Migrate a Classic-mode project to Composer <https://docs.typo3.org/permalink/t3coreapi:migratetocomposer>`_

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
    :hidden:
    :glob:

    Installation/Index
    Deployment/Index
    Docker/Index
    DirectoryStructure/Index
    VersionControl/Index
    Upgrade/Index
    SystemSettings/Index
    Security/Index
    UserManagement/Index
    Backups/Index
    Tuning/Index
    Troubleshooting/Index
    */Index
    *
