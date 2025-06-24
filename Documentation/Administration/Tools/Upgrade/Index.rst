:navigation-title: Upgrade

..  include:: /Includes.rst.txt
..  _admin-tools-upgrade:

=====================
Upgrade (Admin Tools)
=====================

Only available if :composer:`typo3/cms-install` is installed with system
maintainer permissions.

The backend module :guilabel:`Admin Tools > Upgrade` offers tools
to system maintainers that are useful during
:ref:`Major upgrades (TYPO3 explained) <t3coreapi:major>`.

..  figure:: /Images/ManualScreenshots/AdminTools/UpgradeTools.png
    :alt: Admin Tools -> Upgrade, Overview

The tools listed here are mainly used during  `Major Upgrades of the TYPO3 Core
or a third party extension <https://docs.typo3.org/permalink/t3coreapi:upgrading>`_.

Some tools can also be used to access the quality of custom TYPO3 extensions.

..  seealso::
    There are also a number of `Third-party tools useful during upgrade <https://docs.typo3.org/permalink/t3coreapi:tools>`_.

..  contents:: Table of contents

..  _admin-tools-upgrade-updater:

Core updater
============

In classic mode TYPO3 installations that fulfil certain criteria you can use
this function to automatically do patch level TYPO3 Core updates.

..  seealso::

    *   :ref:`classic-mode-upgrade-minor`
    *   :ref:`classic-mode-upgrade-disable`


..  _run_upgrade_wizard:
..  _use-the-upgrade-wizard:

Upgrade wizard
==============

The upgrade wizard should be checked before each major Core or extension upgrade.
If tasks have been left open they should be resolved before proceeding.

After each upgrade, especially major or minor upgrades, you should check if
there are new upgrade wizards to be executed.

The upgrade wizards can only be run if no tables or columns are missing.
If any are missing, create them using the
`Database Analyzer <https://docs.typo3.org/permalink/t3coreapi:admin-tools-maintenance-database-analyzer>`_.

You can use console commands to list and run the upgrade wizards:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            # List upgrade wizards that need to be run
            vendor/bin/typo3 upgrade:list

            # Run a specific upgrade wizard
            vendor/bin/typo3 upgrade:run myExtension_exampleUpgradeWizard

            # Run all upgrade wizards
            vendor/bin/typo3 upgrade:run myExtension_exampleUpgradeWizard

    .. group-tab:: Classic mode installation (no Composer)

        .. code-block:: bash

            # List upgrade wizards that need to be run
            typo3/sysext/core/bin/typo3 upgrade:list

            # Run a specific upgrade wizard
            typo3/sysext/core/bin/typo3 upgrade:run myExtension_exampleUpgradeWizard

            # Run all upgrade wizards
            typo3/sysext/core/bin/typo3 upgrade:run myExtension_exampleUpgradeWizard

Or access module :guilabel:`Upgrade` from the Admin Tools or Install Tool and
the click on :guilabel:`Run upgrade wizard...`.

Some upgrade wizards are not mandatory. You can choose option "No, do not
execute" to skip them.

The TYPO3 Core contains upgrade wizards for two major versions. Third party
extensions can contain additional upgrade wizards for their own purposes,
commonly adjustments to the extensions database records.

There is an extension :composer:`wapplersystems/core-upgrader`. It contains
upgrade wizards older than two TYPO3 versions. It can be used to migrate the
data of installations that need to be upgraded more than two major versions at
once.
