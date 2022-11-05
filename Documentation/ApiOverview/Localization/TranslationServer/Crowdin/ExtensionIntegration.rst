.. include:: /Includes.rst.txt
.. index:: pair: Crowdin; Extensions
.. _crowdin-extension-integration:

=====================
Extension integration
=====================

This section describes how an extension author can get his extension setup at Crowdin.

.. tip::

   **Important to know**

   - Your extension must be on GitHub, BitBucket or GitLab
   - Currently TYPO3 can only handle one branch/version for languages, more to that later.

Setup
=====

Get in contact with the team in the TYPO3 slack channel *cig-crowdin-localization* with the following information:

#. Extension name
#. Information if your extension is already available on the previous translation server
#. Your email address for an invitation to Crowdin, so you will get the correct role for your project.

Integration
===========

You need to handle the integration yourself.

.. hint::

   The User Interface has changed slightly, this used to be under
   :guilabel:`Settings` > :guilabel:`Integrations` > :guilabel:`Setup integration`.

#. Go to the url of your project at Crowdin (e.g. `<https://crowdin.com/project/typo3-extension-ttaddress>`_)
#. Switch to the tab **Integrations**
#. Find the card which corresponds to your extension source, e.g. GitHub / GitLab / Bitbucket
#. Click **Set Up integration** and then select "Set Up integration"

.. figure:: /Images/ExternalImages/Crowdin/IntegrationSetup.png
   :alt: Start of Crowdin integration for an extension
   :width: 600px

   Start of Crowdin integration for an extension

A modal dialog window will open, allowing you to select the correct repository.

Select branches
---------------

Select the **main** branch to be translated.


.. figure:: /Images/ExternalImages/Crowdin/IntegrationBranches.png
   :alt: Branch configuration
   :width: 600px

   Branch configuration

.. important::

   TYPO3 can currently handle one branch for an extension!
   Typically you should select the `main` branch.


Push translations
-----------------

Click on the *Show advanced settings* link below to decide how you want your translations to behave:

.. figure:: /Images/ExternalImages/Crowdin/IntegrationPushTranslations.png
   :alt: Setting for translation pushes
   :width: 600px

   Setting for translation pushes

Uncheck the checkbox to avoid pushing back the translations to your project directly.

Branch configuration
--------------------

Now click on the edit button next to the branch name to setup your branch configuration.

.. figure:: /Images/ExternalImages/Crowdin/IntegrationBranchConfiguration.png
   :alt: Branch configuration
   :width: 600px

This will open a new modal dialog window and will ask for the **Configuration file name**. We propose the file name `.crowdin.yaml`

.. figure:: /Images/ExternalImages/Crowdin/IntegrationConfigurationFile.png
   :alt: Setting for translation pushes
   :width: 600px

Adopt the file name and press **Continue**.

Now you need to define where the language files are located.

.. figure:: /Images/ExternalImages/Crowdin/IntegrationOverview.png
   :alt: Location of translation files
   :width: 600px

The following setup will workout fine:

- Source file path: `/Resources/Private/Language/`
- Translated file path: `/%original_path%/%two_letters_code%.%original_file_name%`

Please check in the right area of the modal dialog window if all xlf files have been identified.

Now press the green save button on the upper middle border and then the save button in the lower right corner.

Now press the last save button and you are done!

After a short time you should see something like that

.. figure:: /Images/ExternalImages/Crowdin/IntegrationResult.png
   :alt: Result
   :width: 600px

Clicking the Edit button or double click on the text "master" of your branch will take you back to the :guilabel:`Select Branches` dialog from above.

Happy translating!

.. tip::

   Checkout the :ref:`crowdin-faq` for solutions to common pitfalls.
