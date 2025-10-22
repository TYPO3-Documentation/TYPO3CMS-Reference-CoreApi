.. include:: /Includes.rst.txt
.. index::
   JavaScript (Backend); Modals
   Modal window
.. _modules-modals:

======
Modals
======

..  versionchanged:: 12.0
    The modal API provided by the module :js:`@typo3/backend/modal.js` has been
    adapted to be backed by a custom web component and therefore gained an updated,
    stateless interface. See also section :ref:`modules-modals-migration`.

Actions that require a user's attention must be visualized by modal windows.

TYPO3 provides an API as basis to create modal windows with severity
representation. For better UX, if actions (buttons) are attached to the modal,
one button must be a positive action. This button should get a `btnClass`
to highlight it.

Modals should be used rarely and only for confirmations. For information that
does not require a confirmation
the :ref:`Notification API (flash message) <notification_api>` should be used.

For complex content, like forms or a lot of information, use normal pages.

.. _modules-modals-api:

API
===

..  versionchanged:: 12.0
    The return type of all :js:`Modal.*` factory methods has been changed from
    :js:`JQuery` to :js:`ModalElement`.

The API provides only two public methods:

#. :js:`TYPO3.Modal.confirm(title, content, severity, buttons)`
#. :js:`TYPO3.Modal.dismiss()`

.. _modules-modals-settings:

Modal settings
--------------

..  confval-menu::
    :name: modules-modals-settings
    :display: table
    :type:

    ..  confval:: title
        :name: modules-modals-settings-title
        :Required: true
        :type: string

        The title displayed in the modal

    ..  confval:: content
        :name: modules-modals-settings-content
        :Required: true
        :type: string|jQuery

        The content displayed in the modal

    ..  confval:: severity
        :name: modules-modals-settings-severity
        :type: int
        :Default: :js:`TYPO3.Severity.info`

        Represents the severity of a modal. Please see :js:`TYPO3.Severity`.

    ..  confval:: buttons
        :name: modules-modals-settings-buttons
        :type: object[]

        Actions rendered into the modal footer. If empty, the footer
        is not rendered. See section :ref:`modules-modals` on how to configure the buttons.

    ..  confval:: staticBackdrop
        :name: modules-modals-settings-staticBackdrop
        :type: bool
        :Default: :js:`false`

        Controls whether a static backdrop should be rendered, which prevents
        closing the modal by clicking outside of it.

.. _modules-modals-button-settings:

Button settings
---------------

..  confval-menu::
    :name: modules-modals-button-settings
    :display: table
    :type:

    ..  confval:: text
        :name: modules-modals-button-settings-text
        :Required: true
        :type: string

        The text rendered into the button.

    ..  confval:: trigger / action
        :name: modules-modals-button-settings-trigger
        :Required: true
        :type: function

        Callback that is triggered on button click - either a simple function or
        :js:`DeferredAction` / :js:`ImmediateAction`

    ..  confval:: active
        :name: modules-modals-button-settings-active
        :type: bool

        Marks the button as active. If true, the button gets the focus.

    ..  confval:: btnClass
        :name: modules-modals-button-settings-btnClass
        :type: string

        The CSS class for the button.

..  versionchanged:: 12.0
    The :js:`Button` property `dataAttributes` has been removed without
    replacement, as the functionality can be expressed via :js:`Button.name`
    or :js:`Button.trigger` and is therefore redundant.


Data Attributes
---------------

It is also possible to use :html:`data` attributes to trigger a modal,
for example on an anchor element, which prevents the default behavior.

:html:`data-title`
    The title text for the modal.

:html:`data-content`
    The content text for the modal.

:html:`data-severity`
    The severity for the modal, default is `info` (see :js:`TYPO3.Severity.*`).

:html:`data-href`
    The target URL, default is the :html:`href` attribute of the element.

:html:`data-button-close-text`
    Button text for the :guilabel:`close`/:guilabel:`cancel` button.

:html:`data-button-ok-text`
    Button text for the :guilabel:`ok` button.

:html:`class="t3js-modal-trigger"`
    Marks the element as modal trigger.

:html:`data-static-backdrop`
    Render a static backdrop to avoid closing the modal when clicking it.

Example:

..  literalinclude:: _Modals/_DataModal.html

Examples
========

A basic modal (without anything special) can be created this way:

..  code-block:: javascript

    TYPO3.Modal.confirm('The title of the modal', 'This the the body of the modal');

A modal as warning with button:

..  literalinclude:: _Modals/_warning.js

A modal as warning:

..  code-block:: javascript

    TYPO3.Modal.confirm('Warning', 'You may break the internet!', TYPO3.Severity.warning);

Action buttons in modals created by the :js:`TYPO3/CMS/Backend/Modal` module may
make use of :js:`TYPO3/CMS/Backend/ActionButton/ImmediateAction` and
:js:`TYPO3/CMS/Backend/ActionButton/DeferredAction`.

As an alternative to the existing :js:`trigger` option, the option
:js:`action` may be used with an instance of the previously mentioned modules.

..  literalinclude:: _Modals/_deferred-action.js

Activating any action disables all buttons in the modal. Once the action is
done, the modal disappears automatically.

Buttons of the type :js:`DeferredAction` render a spinner on activation
into the button.

A modal with static backdrop:

..  literalinclude:: _Modals/_static_backdrop.js
    :language: js

Templates, using the HTML class :html:`.t3js-modal-trigger` to initialize
a modal dialog are also able to use the new option by adding the
:html:`data-static-backdrop` attribute to the corresponding element.

..  literalinclude:: _Modals/_StaticBackdrop.html
    :language: html

.. _modules-modals-migration:

Migration
=========

Given the following fully-fledged example of a modal that uses custom buttons,
with custom attributes, triggers and events, they should be migrated away
from :js:`JQuery` to :js:`ModalElement` usage.

Existing code:

..  code-block:: javascript

    var configuration = {
       buttons: [
          {
             text: 'Save changes',
             name: 'save',
             icon: 'actions-document-save',
             active: true,
             btnClass: 'btn-primary',
             dataAttributes: {
                action: 'save'
             },
             trigger: function() {
                Modal.currentModal.trigger('modal-dismiss');
             }
          }
       ]
    };
    Modal
      .advanced(configuration)
      .on('hidden.bs.modal', function() {
        // do something
    });

Should be adapted to:

..  code-block:: javascript

    const modal = Modal.advanced({
       buttons: [
          {
             text: 'Save changes',
             name: 'save',
             icon: 'actions-document-save',
             active: true,
             btnClass: 'btn-primary',
             trigger: function(event, modal) {
               modal.hideModal();
             }
          }
       ]
    });
    modal.addEventListener('typo3-modal-hidden', function() {
      // do something
    });
