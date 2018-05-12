.. include:: ../../../Includes.txt

.. _update-wizards-creation-generic:

===============================
Creating generic update wizards
===============================

Each update wizard consists of a single PHP file containing a single PHP class. This
class has to extend :php:`TYPO3\CMS\Install\Updates\AbstractUpdate` and implement its
abstract methods::

   <?php
   namespace Vendor\ExtName\Updates;

   use TYPO3\CMS\Install\Updates\AbstractUpdate;

   class ExampleUpdateWizard extends AbstractUpdate
   {
       /**
        * @var string
        */
       protected $title = 'Title of this updater';

       /**
        * Checks whether updates are required.
        *
        * @param string &$description The description for the update
        * @return bool Whether an update is required (TRUE) or not (FALSE)
        */
       public function checkForUpdate(&$description)
       {
           return true;
       }

      /**
       * Performs the required update.
       *
       * @param array &$dbQueries Queries done in this update
       * @param string &$customMessage Custom message to be displayed after the update process finished
       * @return bool Whether everything went smoothly or not
       */
       public function performUpdate(array &$databaseQueries, &$customMessage)
       {
           return true;
       }
   }

Property :php:`$title`
   Can be overwritten to define the title used while rendering the list of available
   update wizards.

Method :php:`checkForUpdate`
   Is called to check whether the updater has to run. Therefore a boolean has to be
   returned. The :php:`$description` provided can be modified as a reference to
   provide further explanation, in addition to the title.

Method :php:`performUpdate`
   Is called if the user triggers the wizard. This method should contain, or call,
   the code that is needed to execute the update. :php:`$databaseQueries` and
   :php:`$customMessage` can be used as reference to provide further information to
   the user after the update function is completed. :php:`$databaseQueries` has to
   be an array, where each value is a string containing the query. This array should
   only contain executed queries. :php:`$customMessage` is a string, where further
   information is provided for the user after the updated process has completed.

Marking wizard as done
======================

As soon as the wizard has completely finished, e.g. it detected that no update is
necessary anymore, or that all updates were completed successfully, the wizard should
be marked as done. To mark the wizard as done, call :php:`$this->markWizardAsDone`.

The state is persisted in :file:`LocalConfiguration.php`.
