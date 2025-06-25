:navigation-title: Upgrades
..  include:: /Includes.rst.txt

..  _upgrading:

=======================================
Upgrading the TYPO3 Core and extensions
=======================================

..  figure:: /Images/ManualScreenshots/Backend/Typo3Version.png
    :alt: The top bar of a TYPO3 backend showing the current version being used.

    You can find the current TYPO3 Core version in the top left of the TYPO3 backend.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Patch/bugfix updates <Minor>`

        Patch/bugfix updates contain bugfixes and/or security updates. This section details
        how to install them using Composer.

    ..  card:: :ref:`Major upgrades <Major>`

        This chapter details how major upgrades are installed using Composer and
        highlights what tasks need to be carried out before and after the core is updated.

    ..  card:: :ref:`Upgrading extensions <UpgradingExtensions>`

        Just like TYPO3's core, extensions also need to be regularly updated.
        This chapter details how to upgrade extensions using Composer.

    ..  card:: :ref:`Third-party Tools <Tools>`

        Tools and resources developed by the community that can assist with common
        upgrade and maintenance tasks.

    ..  card:: :ref:`Classic mode upgrade guide <classic-mode-upgrade>`

        Using TYPO3 without Composer? This chapter details how to upgrade TYPO3 manually.

    ..  card:: :ref:`Applying Core patches <applying-core-patches>`

        Learn how to apply Core patches in a future proof way: Automatize
        patch application with `cweagans/composer-patches`. Download
        a patch for the Core.

    ..  card:: :ref:`Migrate a TYPO3 installation to Composer <MigrateToComposer>`

        Information on how to migrate a Classic mode installation of TYPO3 to a Composer based installation.

    ..  card:: :ref:`Migrate content <MigrateContent>`

        This chapter details how pages and content can be exported and then imported into another installation of TYPO3.

..  toctree::
    :hidden:

    Minor/Index
    Major/Index
    UpgradingExtensions/Index
    Tools/Index
    Legacy/Index
    ApplyingCorePatches/Index
    MigrateToComposer/Index
    MigrateContent/Index
