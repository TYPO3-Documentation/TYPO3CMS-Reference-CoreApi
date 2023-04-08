..  include:: /Includes.rst.txt
..  index:: Events; PasswordChangeEvent
..  _PasswordChangeEvent:

===================
PasswordChangeEvent
===================

The PSR-14 event :php:`\TYPO3\CMS\FrontendLogin\Event\PasswordChangeEvent`
contains information about the password that has been set and will be
stored in the database shortly.

..  note::
    You can find a basic example implementation of a listener to this event
    in the chapter :ref:`extension-development-event-listener`.

..  deprecated:: 12.4
    The :php:`PasswordChangeEvent` should not be used to validate user passwords,
    since it is not possible to visualize to the user why a password has been
    rejected. Therefore the following methods of the event are deprecated:

    *   :php:`->setAsInvalid()`
    *   :php:`->getErrorMessage()`
    *   :php:`->isPropagationStopped()`
    *   :php:`->setHashedPassword()`

    A :ref:`custom password policy validator<password-policies-custom-validator>`
    should be used to validate user passwords.

API
===

..  include:: /CodeSnippets/Events/FrontendLogin/PasswordChangeEvent.rst.txt
