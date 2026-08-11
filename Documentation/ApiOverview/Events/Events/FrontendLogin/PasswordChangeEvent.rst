..  include:: /Includes.rst.txt
..  index:: Events; PasswordChangeEvent
..  _PasswordChangeEvent:

=====================
`PasswordChangeEvent`
=====================

The PSR-14 event :php:`\TYPO3\CMS\FrontendLogin\Event\PasswordChangeEvent`
contains information about the password that has been set and will be
stored in the database shortly.

..  note::
    You can find a basic example implementation of a listener to this event
    in the chapter :ref:`extension-development-event-listener`.

..  _password-change-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _password-change-event-api:

API
===

..  include:: /CodeSnippets/Events/FrontendLogin/PasswordChangeEvent.rst.txt
