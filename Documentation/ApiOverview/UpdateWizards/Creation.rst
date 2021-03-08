.. include:: ../../Includes.txt

.. preferably, use label "upgrade-wizards-creation"

.. _update-wizards-creation-generic:
.. _upgrade-wizards-creation:
.. _upgrade-wizard-interface:

================================
Creating Generic Upgrade Wizards
================================

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
         return 'exampleUpdateWizard';
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
        * @return bool
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
   Is called to check whether the updater has to run. Therefore a boolean has to be
   returned.

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

.. _upgrade-wizards-mark-as-done:
.. _repeatable-interface:

Marking wizard as done
======================

As soon as the wizard has completely finished, e.g. it detected that no update is
necessary anymore, or that all updates were completed successfully, the wizard
is marked as done and won't be checked anymore.

To force TYPO3 to check the wizard every time, the interface
:php:`\TYPO3\CMS\Install\Updates\RepeatableInterface` has to be implemented.
This interface works as a marker and does not force any methods to be
implemented.

.. _upgrade-wizards-generate-output:
.. _uprade-wizards-chatty-interface:

Generating Output
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
We show a simplified example here, based on this class::

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

Registering wizard
==================

Once the wizard is created, it needs to be registered. Registration is done in
:file:`ext_localconf.php`::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['exampleUpdateWizard']
      = \Vendor\ExtName\Updates\ExampleUpdateWizard::class;

**Important:** Use the same identifier as key (here: `exampleUpdateWizard`), which
is returned by :php:`UpgradeWizardInterface::getIdentifier()` in your wizard
class.


.. index:: Upgrade wizards; Execution

Executing wizard
================

Wizards are listed inside the install tool, inside navigation "Upgrade" and the card "Upgrade Wizard".
The registered wizard should be shown there, as long as he is not done.

It is also possible to execute the wizard from the command line.

.. code-block:: bash

   # Run using our identifier 'exampleUpdateWizard' which was specified when registering
   vendor/bin/typo3 upgrade:run exampleUpdateWizard

You can find more information about running upgrade wizards in the
:ref:`Upgrade wizard section <t3install:use-the-upgrade-wizard>` of the
Installation Guide.
