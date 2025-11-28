:navigation-title: Upgrade

..  include:: /Includes.rst.txt
..  _admin-tools-upgrade:

=========================
Module "Upgrade" (System)
=========================

..  versionchanged:: 14.0
    This module has been moved from :guilabel:`Admin tools` to :guilabel:`Settings`
	<https://docs.typo3.org/permalink/changelog:feature-107628-1729026000>`_.

Only available if :composer:`typo3/cms-install` is installed with system
maintainer permissions.

The backend module :guilabel:`System > Upgrade` offers tools
to system maintainers that are useful during
:ref:`Major upgrades (TYPO3 explained) <t3coreapi:major>`.

..  figure:: /Images/ManualScreenshots/AdminTools/UpgradeTools.png
    :alt: System > Upgrade, Overview

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
there are new upgrade wizards that need to be executed.

The upgrade wizards can only be run if no tables or columns are missing.
If any are missing, create them using the
`Database Analyzer <https://docs.typo3.org/permalink/t3coreapi:admin-tools-maintenance-database-analyzer>`_.

Use console commands to list and run the upgrade wizards:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            # List upgrade wizards that need to be run
            vendor/bin/typo3 upgrade:list

            # Run a specific upgrade wizard
            vendor/bin/typo3 upgrade:run myExtension_exampleUpgradeWizard

            # Run all upgrade wizards
            vendor/bin/typo3 upgrade:run

    .. group-tab:: Classic mode installation (no Composer)

        .. code-block:: bash

            # List upgrade wizards that need to be run
            typo3/sysext/core/bin/typo3 upgrade:list

            # Run a specific upgrade wizard
            typo3/sysext/core/bin/typo3 upgrade:run myExtension_exampleUpgradeWizard

            # Run all upgrade wizards
            typo3/sysext/core/bin/typo3 upgrade:run

Or access module :guilabel:`System > Upgrade` from the backend or Install Tool and
then click on :guilabel:`Run upgrade wizard...`.

Some upgrade wizards are not mandatory. You can choose the option "No, do not
execute" to skip them.

The TYPO3 Core contains upgrade wizards for two consecutive major versions.
Third party extensions can contain additional upgrade wizards for their own
purposes (commonly changes to extension database records).

The extension :composer:`wapplersystems/core-upgrader` contains
upgrade wizards older than the last two TYPO3 versions. It can be used to migrate the
data from installations that need to be upgraded across more than two major versions at
once.

..  _admin-tools-upgrade-documentation:

View upgrade documentation (Changelogs)
=======================================

You can read all the changelog entries that affect the current Core version in the
module :guilabel:`System > Upgrade` or read
them online: :doc:`TYPO3 Core Changelog Online <changelog:Index#typo3-core-changelog>`.

The module allows you to mark changelog entries as read. Read entries are
automatically hidden.

..  _admin-tools-upgrade-tca-ext-tables:

Check TCA in ext_tables.php
===========================

TCA **must not** be defined in file :file:`ext_tables.php`. This is because TCA
is required in the frontend context and this file is only loaded in backend context.

This tool can be used to check for incorrect or historical definitions of TCA
in :file:`ext_tables.php`.

..  _admin-tools-upgrade-broken-extensions:

Check for broken extensions
===========================

This tool tries to load the files :file:`ext_localconf.php` and
:file:`ext_tables.php` from all the installed extensions. It can help you to detect
which extensions are causing errors.

..  _admin-tools-upgrade-extension-scanner:

Extension scanner: Scan extension files
=======================================

..   figure:: /Images/ManualScreenshots/AdminTools/ExtensionScanner.png
    :alt: The extension scanner report with strong and weak matches

    Deprecations as strong and weak matches in the extension scanner for EXT:news

When functionality is to be dropped or changed in the TYPO3 Core in the next major
version it is usually already marked as deprecated in the current TYPO3 version.

Therefore, by dealing with deprecations in the current TYPO3 version you can
prepare your custom extensions to also work in the next TYPO3 Core version.

The **extension scanner** can be used to find deprecated code in extensions.

Using the extension scanner to update custom extensions is described in more detail
in `Extension scanner <https://docs.typo3.org/permalink/t3coreapi:extension-scanner>`_.
