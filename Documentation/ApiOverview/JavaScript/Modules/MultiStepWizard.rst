.. include:: /Includes.rst.txt

.. _modules-multistepwizard:

=================
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
