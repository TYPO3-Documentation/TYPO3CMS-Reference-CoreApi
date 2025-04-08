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
        prevent that, chose one of the other allowed types:

        **JQuery**:

        ..  code-block:: js

            $(`<div>Your HTML content</div>`);

        **Element**:

        ..  code-block:: js

            Object.assign(document.createElement('div'), {
              innerHTML: 'Your HTML content'
            });

        **DocumentFragment**:

        ..  code-block:: js

            document.createRange().createContextualFragment("<div>Your HTML content</div>");

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

"Hello world" Example
=====================

This JavaScript snippet will create a new multi-step wizard with just one
sheet. As it used :javascript:`SeverityEnum.warning` the title and buttons
will be colored in yellow.

..  literalinclude:: _Modals/_multi-step-wizard.js
    :language: javascript
    :caption: EXT:my_extension/Resources/Public/JavaScript/HelloWorldModule.js

To call the JavaScript from above you have to use the
:ref:`JavaScriptModuleInstruction<backend-javascript-es6-loading>`) technique.
In following snippet you see how to add a JavaScript module to field within
:ref:`Form Engine<FormEngine>`:

..  code-block:: js

    $resultArray['javaScriptModules'][] = JavaScriptModuleInstruction::create(
        '@stefanfroemken/dropbox/AccessTokenModule.js'
    )->instance($fieldId);
