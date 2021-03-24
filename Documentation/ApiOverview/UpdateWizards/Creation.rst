.. include:: /Includes.rst.txt
.. preferably, use label "upgrade-wizards-creation"
.. index:: Upgrade wizards; Creation
.. _update-wizards-creation-generic:
.. _upgrade-wizards-creation:
.. _upgrade-wizard-interface:

========================
Creating upgrade wizards
========================

These steps create an upgrade wizard:

.. rst-class:: bignums

#. Add a class implementing :ref:`UpgradeWizardInterface <upgrade-wizards-interface>`

#. The class *may* implement other interfaces (optional):

   *  :ref:`RepeatableInterface <repeatable-interface>` to not mark the wizard
      as done after execution

   *  :ref:`ChattyInterface <uprade-wizards-chatty-interface>` for generating
      output

   *  :php:`ConfirmableInferface` for wizards that need user confirmation

#. :ref:`Register the wizard <upgrade-wizards-register>` in the file
   :file:`ext_localconf.php`


.. _upgrade-wizards-interface:

UpgradeWizardInterface
======================

Each upgrade wizard consists of a single PHP file containing a single PHP class. This
class has to implement :php:`TYPO3\CMS\Install\Updates\UpgradeWizardInterface` and its
methods::

   <?php
   namespace Vendor\ExtName\Updates;

   use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

   class ExampleUpdateWizard implements UpgradeWizardInterface
   {
       /**
        * Return the identifier for this wizard
        * This should be the same string as used in the ext_localconf class registration
        *
        * @return string
        */
       public function getIdentifier(): string
       {
         return 'extName_exampleUpdateWizard';
       }

       /**
        * Return the speaking name of this wizard
        *
        * @return string
        */
       public function getTitle(): string
       {
         return 'Title of this updater';
       }

       /**
        * Return the description for this wizard
        *
        * @return string
        */
       public function getDescription(): string
       {
         return 'Description of this updater';
       }

       /**
        * Execute the update
        *
        * Called when a wizard reports that an update is necessary
        *
        * @return bool
        */
       public function executeUpdate(): bool
       {
       }

       /**
        * Is an update necessary?
        *
        * Is used to determine whether a wizard needs to be run.
        * Check if data for migration exists.
        *
        * @return bool Whether an update is required (TRUE) or not (FALSE)
        */
       public function updateNecessary(): bool
       {
       }

       /**
        * Returns an array of class names of prerequisite classes
        *
        * This way a wizard can define dependencies like "database up-to-date" or
        * "reference index updated"
        *
        * @return string[]
        */
       public function getPrerequisites(): array
       {
       }
   }

Method :php:`getIdentifier`
   Return the identifier for this wizard. This should be the same string as used
   in the ext_localconf class registration.

Method :php:`getTitle`
   Return the speaking name of this wizard.

Method :php:`getDescription`
   Return the description for this wizard.

Method :php:`executeUpdate`
   Is called if the user triggers the wizard. This method should contain, or call,
   the code that is needed to execute the update. Therefore a boolean has to be
   returned.

Method :php:`updateNecessary`
   Is called to check whether the upgrade wizard has to run. Return :php:`true`, if an
   update is necessary, :php:`false` if not. If :php:`false` is returned, the upgrade
   wizard will not be displayed in the list of available wizards.

Method :php:`getPrerequisites`
   Returns an array of class names of prerequisite classes. This way a wizard can
   define dependencies like "database up-to-date" or "reference index updated":

.. code-block:: php

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


.. index:: Upgrade wizards; Registration
.. _upgrade-wizards-register:

Registering wizards
===================

Once the wizard is created, it needs to be registered. Registration is done in
:file:`ext_localconf.php`::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['extName_exampleUpdateWizard']
      = \Vendor\ExtName\Updates\ExampleUpdateWizard::class;

**Important:** Use the same identifier as key (here: `extName_exampleUpdateWizard`), which
is returned by :php:`UpgradeWizardInterface::getIdentifier()` in your wizard
class.

.. index:: Upgrade wizards; Identifier
.. _upgrade-wizards-identifier:

Wizard identifier
=================

The wizard identifier is used:

*  when calling the wizard from the :ref:`command line <upgrade_wizard_execute>`.
*  when marking the wizard as done in the table :sql:`sys_registry`

Since all upgrade wizards of TYPO3 core and extensions are registered using the
identifier as key in the global array
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']`, it
is recommended to prepend the identifier with something unique to the extension
to make it unique.

You SHOULD use the following naming convention for the identifier:

`extName_wizardName`, for example `bootstrapPackage_addNewDefaultTypes`

*  extension key and wizard name in lowerCamelCase, separated by underscore
*  existing underscores in extension keys are replaced by capitalizing the
   following letter

.. important::

   Any identifier will still work, using these naming conventions is
   not enforced. In fact, it is not recommended to change already
   existing wizard identiers, as the information, that the wizard ran is
   stored using the identifier in the :sql:`sys_registry` table and this
   information would then be lost.

Some examples:

+-------------------+-------------------------------------+
| extension key     | wizard identifer                    |
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

As soon as the wizard has completely finished, for example it detected that no update is
necessary anymore, the wizard
is marked as done and won't be checked anymore.

To force TYPO3 to check the wizard every time, the interface
:php:`\TYPO3\CMS\Install\Updates\RepeatableInterface` has to be implemented.
This interface works as a marker and does not force any methods to be
implemented.


.. index:: Upgrade wizards; Generating output
.. _upgrade-wizards-generate-output:
.. _uprade-wizards-chatty-interface:

Generating output
=================

The :php:`ChattyInterface` can be implemented for wizards which should generate output.
:php:`ChattyInterface` uses the Symfony interface
`OutputInterface <https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Console/Output/OutputInterface.php>`__.

Classes using this interface must implement the following method::

    /**
     * Setter injection for output into upgrade wizards
     *
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): void;


The class :php:`FormFileExtensionUpdate` in the extension "form" implements this interface.
We are showing a simplified example here, based on this class::

    use Symfony\Component\Console\Output\OutputInterface;
    use TYPO3\CMS\Install\Updates\ChattyInterface;
    use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

    class FormFileExtensionUpdate implements ChattyInterface, UpgradeWizardInterface
    {
         /**
         * @var OutputInterface
         */
        protected $output;


        public function setOutput(OutputInterface $output): void
        {
            $this->output = $output;
        }

        /**
         * Checks whether updates are required.
         *
         * @return bool Whether an update is required (TRUE) or not (FALSE)
         */
        public function updateNecessary(): bool
        {
            $updateNeeded = false;

            if (
                $formDefinitionInformation['hasNewFileExtension'] === false
                && $formDefinitionInformation['location'] === 'storage'
            ) {
                $updateNeeded = true;
                $this->output->writeln('Form definition files were found that should be migrated to be named .form.yaml.');
            }
            // etc.

            return $updateNeeded;
        }

        // etc.

    }

.. index:: Upgrade wizards; Execution

.. _upgrade_wizard_execute:

Executing the wizard
====================

Wizards are listed inside the install tool, inside navigation "Upgrade" and the card "Upgrade Wizard".
The registered wizard should be shown there, as long as it is not done.

It is also possible to execute the wizard from the command line.

.. code-block:: bash

   # Run using our identifier 'extName_exampleUpdateWizard'
   vendor/bin/typo3 upgrade:run extName_exampleUpdateWizard


.. tip::

   Some existing wizards use the convention of using the fully qualified class
   name as identifer. You may have to quote the backslashes in the shell, e.g.

   .. code-block:: bash

      vendor/bin/typo3 upgrade:run '\\Vendor\\ExtKey\\Upgrade\\ExampleUpgradeWizard'

You can find more information about running upgrade wizards in the
:ref:`Upgrade wizard section <t3install:use-the-upgrade-wizard>` of the
Installation Guide.
