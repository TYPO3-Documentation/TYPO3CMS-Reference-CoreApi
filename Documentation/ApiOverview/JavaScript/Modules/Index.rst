.. include:: ../../../Includes.txt


.. _modules:

==========================
Various JavaScript Modules
==========================

The following APIs are usually used in the TYPO3 backend by the core itself but may also
be used by extensions.

Modals
======

Actions that require a user's attention must be visualized by modal windows.

TYPO3 provides an API as basis to create modal windows with severity representation. For better UX,
if actions (buttons) are attached to the modal, one button must be a positive action. This button
should get a `btnClass` to highlight it.

Modals should be used rarely and only for confirmations. For information the :code:`TYPO3.Flashmessage` API should be used.
For complex content, like forms or a lot of information, please use normal pages.

API
---

The API provides only two public methods:

#. :code:`TYPO3.Modal.confirm(title, content, severity, buttons)`
#. :code:`TYPO3.Modal.dismiss()`

Modal Settings
~~~~~~~~~~~~~~

========= =============== ============ ==============================================================================================================
Name      DataType        Mandatory    Description
========= =============== ============ =====================================================================--------=================================
title     string          Yes          The title displayed in the modal
content   string|jQuery   Yes          The content displayed in the modal
severity  int                          Represents the severity of a modal. Please see :code:`TYPO3.Severity`. Default is :code:`TYPO3.Severity.info`.
buttons   object[]                     Actions rendered into the modal footer. If empty, the footer is not rendered. See table below.
========= =============== ============ ==============================================================================================================

Button Settings
~~~~~~~~~~~~~~~

================== =============== ============ ========================================================================================================
Name               DataType        Mandatory    Description
================== =============== ============ ========================================================================================================
text               string          Yes          The text rendered into the button.
trigger / action   function        Yes          Callback that's triggered on button click - either simple function or `DeferredAction`/`ImmediateAction`
active             bool                         Marks the button as active. If true, the button gets the focus.
btnClass           string                       The css class for the button
================== =============== ============ ========================================================================================================

Data Attributes
~~~~~~~~~~~~~~~

It is also possible to use data-attributes to trigger a modal.
e.g. on an anchor element, which prevents the default behavior.

========================= ==========================================================================
Name                      Description
========================= ==========================================================================
data-title                the title text for the modal
data-content              the content text for the modal
data-severity             the severity for the modal, default is info (see :code:`TYPO3.Severity.*`)
data-href                 the target URL, default is the href attribute of the element
data-button-close-text    button text for the close/cancel button
data-button-ok-text       button text for the ok button
========================= ==========================================================================

:code:`class="t3js-modal-trigger"` marks the element as modal trigger

Examples
--------

A basic modal without any specials can be created this way:

.. code-block:: javascript

	TYPO3.Modal.confirm('The title of the modal', 'This the the body of the modal');

A modal as warning with button:

.. code-block:: javascript

	TYPO3.Modal.confirm('Warning', 'You may break the internet!', TYPO3.Severity.warning, [
		{
			text: 'Break it',
			active: true,
			trigger: function() {
				// break the net
			}
		}, {
			text: 'Abort!',
			trigger: function() {
				TYPO3.Modal.dismiss();
			}
		}
	]);

A modal as warning:

.. code-block:: javascript

	TYPO3.Modal.confirm('Warning', 'You may break the internet!', TYPO3.Severity.warning);

A modal triggered on an anchor element:

.. code-block:: html

	<a href="delete.php" class="t3js-modal-trigger" data-title="Delete" data-content="Really delete?">delete</a>

Action buttons in modals created by the :js:`TYPO3/CMS/Backend/Modal` module may
make use of :js:`TYPO3/CMS/Backend/ActionButton/ImmediateAction` and
:js:`TYPO3/CMS/Backend/ActionButton/DeferredAction`.

As an alternative to the existing :js:`trigger` option, the option
:js:`action` may be used with an instance of the previously mentioned modules.

.. code-block:: js

   Modal.confirm('Header', 'Some content', Severity.error, [
     {
       text: 'Based on trigger()',
       trigger: function () {
         console.log('Vintage!');
       }
     },
     {
       text: 'Based on action',
       action: new DeferredAction(() => {
         return new AjaxRequest('/any/endpoint').post({});
       })
     }
   ]);


Activating any action disables all buttons in the modal. Once the action is
done, the modal disappears automatically.

Buttons of the type :js:`DeferredAction` render a spinner on activation into the button.


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
