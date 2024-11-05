..  include:: /Includes.rst.txt

..  index:: installation

..  _installation_index:

============
Installation
============

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

    ..  card:: :ref:`Installing TYPO3 <install>`

        The Installation Guide covers everything needed to install TYPO3. Including a preinstallation
        checklist and a detailed walk through that details every step of the installation process.

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

    ..  card:: :ref:`Legacy Installation Guide <legacyinstallation>`

        Looking to install TYPO3 the classic way? Whilst this method of installation is no longer recommended, the Legacy Installation
        Guide demonstrates how TYPO3 can be installed without using Composer.

..  toctree::
    :hidden:
    :titlesonly:

    SystemRequirements/Index
    Install
    EnvironmentConfiguration
    ProductionSettings
    TuneTYPO3
    DeployTYPO3
    LegacyInstallation
    LegacyExtensionInstallation
