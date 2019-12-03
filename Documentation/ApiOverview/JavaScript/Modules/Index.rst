.. include:: ../../../Includes.txt





.. _modules:

==========================
Various JavaScript Modules
==========================

The following APIs are usually used in the TYPO3 backend by the core itself but may also
be used by extensions.


Multi-Step Wizard
=================

The JavaScript module :js:`MultiStepWizard` can be used to show a modal multi-step 
wizard with the following features:

* Navigation to previous / next steps
* Steps may have descriptive labels like "Start" or "Finish!"
* Steps may require actions before becoming available.

Code examples:

.. code-block:: js

   // Show/ hide the wizard
   MultiStepWizard.show();
   MultiStepWizard.dismiss();

   // Add a slide to the wizard
   MultiStepWizard.addSlide(
       identifier,
       stepTitle,
       content,
       severity,
       progressBarTitle,
       function() {
       ...
       }
   );

   // Lock/ unlock navigation buttons
   MultiStepWizard.lockNextStep();
   MultiStepWizard.unlockNextStep();
   MultiStepWizard.lockPrevStep();
   MultiStepWizard.unlockPrevStep();

