..  include:: /Includes.rst.txt
..  preferably, use label "upgrade-wizards-creation"
..  index:: Upgrade wizards; Creation
..  _update-wizards-creation-generic:
..  _upgrade-wizards-creation:
..  _upgrade-wizard-interface:

========================
Creating upgrade wizards
========================

..  versionchanged:: 12.2
    The registration of an upgrade wizard has changed in TYPO3 v12.2. An
    upgrade wizard class is now registered with an attribute. The
    :php:`getIdentifier()` method in the :php:`UpgradeWizardInterface`
    was removed. The registration via
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']`
    in :file:`ext_localconf.php` is deprecated and will be removed in TYPO3 v13.
    To be compatible with TYPO3 v11 and v12 you can still
    :ref:`use the registration <t3coreapi-11:upgrade-wizards-register>` via
    :file:`ext_localconf.php`.

To create an upgrade wizard you have to add a class which implements the
:ref:`UpgradeWizardInterface <upgrade-wizards-interface>`.

The class *may* implement other interfaces (optional):

*   :ref:`RepeatableInterface <repeatable-interface>` to not mark the wizard
    as done after execution
*   :ref:`ChattyInterface <uprade-wizards-chatty-interface>` for generating
    output
*   :php:`ConfirmableInterface` for wizards that need user confirmation


.. index:: Upgrade wizards; Registration
.. _upgrade-wizards-register:
.. _upgrade-wizards-interface:

UpgradeWizardInterface
======================

Each upgrade wizard consists of a single PHP file containing a single PHP class.
This class has to implement :php:`TYPO3\CMS\Install\Updates\UpgradeWizardInterface`
and its methods.

The registration of an upgrade wizard is done directly in the class by adding
the class attribute :php:`\TYPO3\CMS\Install\Attribute\UpgradeWizard`. The
:ref:`unique identifier <upgrade-wizards-identifier>` is passed as an argument.

..  literalinclude:: _ExampleUpgradeWizard.php
    :caption: EXT:my_extension/Classes/Upgrades/ExampleUpgradeWizard.php

Method :php:`getTitle()`
    Return the speaking name of this wizard.

Method :php:`getDescription()`
    Return the description for this wizard.

Method :php:`executeUpdate()`
    Is called, if the user triggers the wizard. This method should contain, or
    call, the code that is needed to execute the upgrade. Return a boolean
    indicating whether the update was successful.

Method :php:`updateNecessary()`
    Is called to check whether the upgrade wizard has to run. Return
    :php:`true`, if an upgrade is necessary, :php:`false` if not. If
    :php:`false` is returned, the upgrade wizard will not be displayed in the
    list of available wizards.

Method :php:`getPrerequisites()`
    Returns an array of class names of prerequisite classes. This way, a wizard
    can define dependencies before it can be performed. Currently, the following
    prerequisites exist:

    *   `DatabaseUpdatedPrerequisite`:
        Ensures that the database table fields are up-to-date.
    *   `ReferenceIndexUpdatedPrerequisite`:
        The reference index needs to be up-to-date.

    ..  code-block:: php
        :caption: EXT:my_extension/Classes/Upgrades/ExampleUpgradeWizard.php

        use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
        use TYPO3\CMS\Install\Updates\ReferenceIndexUpdatedPrerequisite;

        /**
         * @return string[]
         */
        public function getPrerequisites(): array
        {
            return [
                DatabaseUpdatedPrerequisite::class,
                ReferenceIndexUpdatedPrerequisite::class,
            ];
        }

..  note::
    Your extension must define a
    :ref:`Configuration/Services.yaml <t3coreapi:extension-configuration-services-yaml>`
    file. Either :yaml:`autoconfigure: true` must be set, or you have to
    manually register the upgrade wizard by adding the tag
    :yaml:`install.upgradewizard`:

    ..  literalinclude:: _tagUpgradeWizard.yaml
        :language: yaml
        :caption: EXT:my_extension/Configuration/Services.yaml

After creating the new upgrade wizard, delete all caches in
:guilabel:`Admin tools > Maintanance > Flush TYPO3 and PHP Cache` or via console
command:

..  include:: /_includes/CliCacheFlush.rst.txt


.. index:: Upgrade wizards; Identifier
.. _upgrade-wizards-identifier:

Wizard identifier
=================

The wizard identifier is used:

*   when calling the wizard from the :ref:`command line <upgrade_wizard_execute>`.
*   when marking the wizard as done in the table :sql:`sys_registry`

Since all upgrade wizards of TYPO3 Core and extensions are registered using the
identifier, it is recommended to prepend the wizard identifier with a prefix
based on the extension key.

You **should** use the following naming convention for the identifier:

`myExtension_wizardName`, for example `bootstrapPackage_addNewDefaultTypes`

*   The extension key and wizard name in lowerCamelCase, separated by underscore
*   The existing underscores in extension keys are replaced by capitalizing the
    following letter

..  attention::
    Any identifier will still work, using these naming conventions is not
    enforced. In fact, it is not recommended to change already existing wizard
    identifiers: The information, that the wizard was performed is stored
    using the identifier in the :sql:`sys_registry` table and this information
    would then be lost.

Some examples:

+-------------------+-------------------------------------+
| Extension key     | Wizard identifier                   |
+===================+=====================================+
| container         | container_upgradeColumnPositions    |
+-------------------+-------------------------------------+
| news_events       | newsEvents_migrateEvents            |
+-------------------+-------------------------------------+
| bootstrap_package | bootstrapPackage_addNewDefaultTypes |
+-------------------+-------------------------------------+


.. index:: Upgrade wizards; Marking wizard as done
.. _upgrade-wizards-mark-as-done:
.. _repeatable-interface:

Marking wizard as done
======================

As soon as the wizard has completely finished, for example, it detected that no
upgrade is necessary anymore, the wizard is marked as done and will not be
checked anymore.

To force TYPO3 to check the wizard every time, the interface
:t3src:`install/Classes/Updates/RepeatableInterface.php` has to be implemented.
This interface works as a marker and does not force any methods to be
implemented.


.. index:: Upgrade wizards; Generating output
.. _upgrade-wizards-generate-output:
.. _uprade-wizards-chatty-interface:

Generating output
=================

The :php:`ChattyInterface` can be implemented for wizards which should generate
output. :t3src:`install/Classes/Updates/ChattyInterface.php` uses the Symfony
interface `OutputInterface`_.

.. _OutputInterface: https://github.com/symfony/symfony/blob/5.4/src/Symfony/Component/Console/Output/OutputInterface.php

Classes using this interface must implement the following method:

..  code-block:: php
    :caption: vendor/symfony/console/Output/OutputInterface.php

    /**
     * Setter injection for output into upgrade wizards
     */
     public function setOutput(OutputInterface $output): void;

The class :t3src:`install/Classes/Updates/DatabaseUpdatedPrerequisite.php`
implements this interface. We are showing a simplified example here, based on
this class:

..  code-block:: php
    :caption: EXT:install/Classes/Updates/DatabaseUpdatedPrerequisite.php
    :emphasize-lines: 8,10-13,20

    use Symfony\Component\Console\Output\OutputInterface;

    class DatabaseUpdatedPrerequisite implements PrerequisiteInterface, ChattyInterface
    {
        /**
         * @var OutputInterface
         */
        protected $output;

        public function setOutput(OutputInterface $output): void
        {
            $this->output = $output;
        }

        public function ensure(): bool
        {
            $adds = $this->upgradeWizardsService->getBlockingDatabaseAdds();
            $result = null;
            if (count($adds) > 0) {
                $this->output->writeln('Performing ' . count($adds) . ' database operations.');
                $result = $this->upgradeWizardsService->addMissingTablesAndFields();
            }
            return $result === null;
        }

        // ... more logic
    }

..  index:: Upgrade wizards; Execution

..  _upgrade_wizard_execute:

Executing the wizard
====================

Wizards are listed in the backend module :guilabel:`Admin Tools > Upgrade` and
the card :guilabel:`Upgrade Wizard`. The registered wizard should be shown
there, as long as it is not done.

It is also possible to execute the wizard from the command line:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 upgrade:run myExtension_exampleUpgradeWizard

    .. group-tab:: Classic mode installation (no Composer)

        .. code-block:: bash

            typo3/sysext/core/bin/typo3 upgrade:run myExtension_exampleUpgradeWizard

..  tip::
    Some existing wizards use the convention of using the fully-qualified class
    name as identifier. You may have to quote the backslashes in the shell,
    for example:

    ..  tabs::

        ..  group-tab:: Composer-based installation

            ..  code-block:: bash

                vendor/bin/typo3 upgrade:run '\\MyVendor\\MyExtension\\Upgrade\\ExampleUpgradeWizard'

        .. group-tab:: Classic mode installation (no Composer)

            .. code-block:: bash

                typo3/sysext/core/bin/typo3 '\\MyVendor\\MyExtension\\Upgrade\\ExampleUpgradeWizard'

..  seealso::
    You can find more information about running upgrade wizards in the section
    :ref:`Upgrade wizards <use-the-upgrade-wizard>`.
