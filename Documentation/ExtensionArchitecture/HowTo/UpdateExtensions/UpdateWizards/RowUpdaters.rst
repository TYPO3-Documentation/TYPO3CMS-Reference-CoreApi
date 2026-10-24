:navigation-title: Row updaters

..  include:: /Includes.rst.txt
..  index:: Upgrade wizards; Row updaters
..  _upgrade-wizards-row-updaters:

=======================================
Row updaters: migrate single table rows
=======================================

..  versionadded:: 15.0
    :changelog: feature-110269-1784737754

    Extensions can register row updaters with the PHP attribute
    :php-short:`\TYPO3\CMS\Core\Attribute\AsRowUpdater`.

A row updater migrates data row by row. Use it for a migration that a plain SQL
statement cannot express. The upgrade wizard *Execute database migrations on
single rows* (identifier `databaseRowsUpdateWizard`) runs all registered row
updaters:

*   It reads each table with TCA once. All rows are included, also deleted and
    hidden ones.
*   It passes each row to every row updater that reported a potential update
    for the table.
*   It writes only the fields that a row updater changed.
*   It stores its position, so an interrupted run continues where it stopped.

..  contents:: Table of contents

..  _upgrade-wizards-row-updaters-implement:

Implement a row updater with `RowUpdaterInterface`
==================================================

A row updater implements
:php-short:`\TYPO3\CMS\Core\Upgrades\RowUpdater\RowUpdaterInterface` and is
registered with the attribute
:php-short:`\TYPO3\CMS\Core\Attribute\AsRowUpdater`:

..  literalinclude:: _EventStatusRowUpdater.php
    :caption: EXT:my_extension/Classes/Upgrades/RowUpdater/EventStatusRowUpdater.php

Method :php:`getTitle()`
    Return the name that the wizard lists for this row updater.

Method :php:`hasPotentialUpdateForTable()`
    Return :php:`true` if the row updater can change rows of the given table.
    The wizard passes only the rows of these tables.

Method :php:`updateTableRow()`
    Return the row, changed or unchanged.

..  _upgrade-wizards-row-updaters-identifier:

Identifier of a row updater
===========================

The attribute takes an identifier as argument. Without it, the fully qualified
class name is the identifier. The identifier must be unique across all row
updaters. Use the naming convention of the
`wizard identifier <https://docs.typo3.org/permalink/t3coreapi:upgrade-wizards-identifier>`_.

The wizard stores the identifier in the table :sql:`sys_registry` after the row
updater was executed. Do not change the identifier afterwards, otherwise the row
updater runs again.

..  _upgrade-wizards-row-updaters-service-tag:

Register a row updater with the service tag `install.rowupdater`
================================================================

If the class cannot carry the attribute, register it with the service tag
:yaml:`install.rowupdater`:

..  literalinclude:: _tagRowUpdater.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

..  _upgrade-wizards-row-updaters-execute:

Execute the row updaters
========================

The wizard lists the row updaters that were not executed yet, and it is shown
as long as one of them is left. Run it in the backend module
:guilabel:`System > Upgrade` or on the command line:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 upgrade:run databaseRowsUpdateWizard

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 upgrade:run databaseRowsUpdateWizard

See `Executing the wizard <https://docs.typo3.org/permalink/t3coreapi:upgrade-wizard-execute>`_.
