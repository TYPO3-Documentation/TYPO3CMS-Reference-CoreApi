:navigation-title: Installation

..  include:: /Includes.rst.txt
..  index:: installation

..  _installation_index:

===========================
TYPO3 installation overview
===========================

TYPO3 can be installed in two ways:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: `Composer-based installation <https://docs.typo3.org/permalink/t3coreapi:installation>`_

        Composer-based setups are common in professional
        environments with development teams. Extensions are installed via `Packagist <https://packagist.org/>`__
        (not from the `TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`__), providing more flexibility in dependency management,
        better integration with version control, and easier environment
        automation. It is ideal for advanced projects or team-based workflows.

        ..  card-footer:: `General installation steps <https://docs.typo3.org/permalink/t3coreapi:installation>`_ `with DDEV <https://docs.typo3.org/permalink/t3start:installation-ddev-tutorial>`_
            :button-style: btn btn-secondary

    ..  card:: `Classic installation <https://docs.typo3.org/permalink/t3coreapi:legacyinstallation>`_

        This method includes access to the `TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`__
        via a regular backend module. It is ideal for managed hosting, automated updates by the hosting provider,
        and simpler setups. Also well-suited for beginners due to GUI-based
        extension handling.

        Switching to Composer later is possible, but takes effort and means
        restructuring the project.

        ..  card-footer:: `Classic installation <https://docs.typo3.org/permalink/t3coreapi:legacyinstallation>`_ `Migrate to Composer <https://docs.typo3.org/permalink/t3coreapi:migratetocomposer>`_
            :button-style: btn btn-secondary

Both methods are fully supported and recommended depending on your project
needs and environment.

As of now, there is **no official plan to deprecate the classic installation method.**

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`System requirements <system-requirements>`

        System requirements for the host operating system, including its web
        server and database and how they should be configured prior to
        installation.

    ..  card:: :ref:`Deploying TYPO3 <DeployTYPO3>`

        The deployment guide highlights some of solutions available that can help automate the process of deploying TYPO3 to
        a remote server.

    ..  card:: :ref:`Tuning TYPO3 <TuneTYPO3>`

        This chapter contains information on how to configure and optimize the infrastructure running TYPO3.

    ..  card:: :ref:`TYPO3 Release Integrity <release_integrity>`

        Every release of TYPO3 is electronically signed by the TYPO3 release team.
        In addition, every TYPO3 package also contains a unique file hash that
        can be used to ensure file integrity when downloading the release. This guide
        details how these signatures can be checked and how file hashes can be compared.

..  toctree::
    :hidden:
    :titlesonly:

    SystemRequirements/Index
    Install
    LegacyInstallation
    ServerInstallation/Index
    EnvironmentConfiguration
    ProductionSettings
    TuneTYPO3
    Deployment/Index
    LegacyExtensionInstallation
