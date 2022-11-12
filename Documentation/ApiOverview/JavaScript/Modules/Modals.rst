.. include:: /Includes.rst.txt
.. index::
   JavaScript (Backend); Modals
   Modal window
.. _modules-modals:

======
Modals
======

Actions that require a user's attention must be visualized by modal windows.

TYPO3 provides an API as basis to create modal windows with severity
representation. For better UX, if actions (buttons) are attached to the modal,
one button must be a positive action. This button should get a `btnClass`
to highlight it.

Modals should be used rarely and only for confirmations. For information that
does not require a confirmation
the :ref:`Notification API (flash message) <notification_api>` API should be used.

For complex content, like forms or a lot of information, use normal pages.

API
===

The API provides only two public methods:

#. :code:`TYPO3.Modal.confirm(title, content, severity, buttons)`
#. :code:`TYPO3.Modal.dismiss()`


Modal settings
--------------

..  confval:: title

    :Required: true
    :type: string

    The title displayed in the modal

..  confval:: content

    :Required: true
    :type: string|jQuery

    The content displayed in the modal

..  confval:: severity

    :type: int
    :Default: :code:`TYPO3.Severity.info`

    Represents the severity of a modal. Please see :code:`TYPO3.Severity`.

..  confval:: buttons

    :type: object[]

    Actions rendered into the modal footer. If empty, the footer
    is not rendered. See table below.


Button settings
---------------

..  confval:: text

    :Required: true
    :type: string

    The text rendered into the button.

..  confval:: trigger / action

    :Required: true
    :type: function

    Callback that is triggered on button click - either simple function or
    `DeferredAction` / `ImmediateAction`

..  confval:: active

    :type: bool

    Marks the button as active. If true, the button gets the focus.

..  confval:: btnClass

    :type: string

    The css class for the button


Data Attributes
---------------

It is also possible to use data-attributes to trigger a modal.
for example on an anchor element, which prevents the default behavior.

:html:`data-title`
    the title text for the modal

:html:`data-bs-content`
    the content text for the modal

:html:`data-severity`
    the severity for the modal, default is info (see :code:`TYPO3.Severity.*`)

:html:`data-href`
    the target URL, default is the href attribute of the element

:html:`data-button-close-text`
    button text for the close/cancel button

:html:`data-button-ok-text `
    button text for the ok button

:html:`class="t3js-modal-trigger"`
    marks the element as modal trigger

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

