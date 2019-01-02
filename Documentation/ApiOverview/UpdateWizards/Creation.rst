.. include:: ../../Includes.txt

.. _update-wizards-creation-generic:

===============================
Creating generic update wizards
===============================

Each update wizard consists of a single PHP file containing a single PHP class. This
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
   define dependencies like "database up-to-date" or "reference index updated"::
   
   <?php
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

Marking wizard as done
======================

As soon as the wizard has completely finished, e.g. it detected that no update is
necessary anymore, or that all updates were completed successfully, the wizard is
marked as done.

The state of completed wizards is persisted in the :ref:`TYPO3 system registry <registry>`.

Registering wizard
==================

Once the wizard is created, it needs to be registered. Registration is done in
:file:`ext_localconf.php`::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['exampleUpdateWizard']
      = \Vendor\ExtName\Updates\ExampleUpdateWizard::class;

Executing wizard
================

Wizards are listed inside the install tool, inside navigation "Upgrade" and the card "Upgrade Wizard".
The registered wizard should be shown there, as long as he is not done.
