..  include:: /Includes.rst.txt
..  index:: JavaScript (Backend); Multi-step wizard
..  _modules-multistepwizard:

=================
Multi-step wizard
=================

The JavaScript module :js:`MultiStepWizard` can be used to show a modal
multi-step wizard with the following features:

*   Navigation to previous / next steps
*   Steps may have descriptive labels like "Start" or "Finish!"
*   Steps may require actions before becoming available.

..  _modules-multistepwizard-addslide:

Add Slide
=========

You have to define at least one slide :javascript:`MultiStepWizard.addSlide()`.

..  confval-menu::
    :name: multi-step-wizard-settings
    :display: table
    :type:

    ..  confval:: identifier
        :name: multi-step-wizard-settings-identifier
        :Required: true
        :type: string

        A unique identifier for the slide

    ..  confval:: title
        :name: multi-step-wizard-settings-title
        :Required: true
        :type: string

        The title of the slide. Will be shown as header of the slide.

    ..  confval:: content
        :name: multi-step-wizard-settings-content
        :Required: true
        :type: string|JQuery|Element|DocumentFragment

        The content of the slide. If `string` any HTML will be escaped. To
        prevent that wrap your content into a jquery object:

        ..  code-block:: js

            $(`Your HTML content`);

    ..  confval:: severity
        :name: multi-step-wizard-settings-severity
        :Required: true
        :type: SeverityEnum

        Set severity color for sheet. Color will only affect title bar and
        prev- and next-buttons.

    ..  confval:: progressBarTitle
        :name: multi-step-wizard-settings-progressBarTitle
        :Required: true
        :type: string

        Set a title for the progress bar. The progress bar will only be shown
        below the content section of the slide, if you have defined at least
        two or more slides.

    ..  confval:: callback
        :name: multi-step-wizard-settings-callback
        :Required: true
        :type: SlideCallback

        A JavaScript callback function which will be called after the slide was
        rendered completely.

..  _modules-multistepwizard-show-hide-wizard:

Show / Hide Wizard
==================

After defining some slides you can show
:javascript:`MultiStepWizard.show()` and hide
:javascript:`MultiStepWizard.dismiss()` the multi-step wizard.

..  _modules-multistepwizard-lock-unlock-wizard:

Lock/Unlock steps
=================

Switching to the next or previous slides is called a `step`. The buttons
to navigate to the slides are deactivated by default. Please use following
methods to lock or unlock them:

..  code-block:: js

    MultiStepWizard.lockNextStep();
    MultiStepWizard.unlockNextStep();
    MultiStepWizard.lockPrevStep();
    MultiStepWizard.unlockPrevStep();

..  _modules-multistepwizard-full-example:

Full Example
============

..  code-block:: js

    import {SeverityEnum} from "@typo3/backend/enum/severity.js"
    import MultiStepWizard from "@typo3/backend/multi-step-wizard.js"
    import $ from "jquery";

    export default class HelloWorldModule {
      constructor(triggerHelloWorldWizardButtonClass) {
        $("." + triggerHelloWorldWizardButtonClass).on("click", function () {
          MultiStepWizard.addSlide(
            "UniqueHelloWorldIdentifier",
            "Title of the Hello World example slide",
            $(`<div>Hello world</div>`),
            SeverityEnum.warning,
            "Step Hello World",
            function ($slide) {
              let $modal = $slide.closest(".modal");
              let $nextButton = $modal.find(".modal-footer").find("button[name='next']");
              MultiStepWizard.unlockNextStep();

              $nextButton.off().on("click", function () {
                // Process whatever you want from current slide, just before wizard will be closed or next slide

                // Close wizard
                MultiStepWizard.dismiss();

                // Go to next slide, if any
                // MultiStepWizard.setup.$carousel.carousel("next");
              });
            }
          );

          MultiStepWizard.show();
        });
      }
    }
