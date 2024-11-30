..  include:: /Includes.rst.txt
..  index:: Events; PasswordHasBeenResetEvent
..  _PasswordHasBeenResetEvent:

=========================
PasswordHasBeenResetEvent
=========================

..  versionadded:: 14.0
    It is possible to add custom business logic after a Backend user reset their
    password using the new PSR-14 event.

The event :php-short:`\TYPO3\CMS\Backend\Authentication\Event\PasswordHasBeenResetEvent`
is raised right after a backend user resets their password
and it has been hashed and persisted to the database.

The event contains the corresponding backend user UID.

..  _PasswordHasBeenResetEvent-example:

Example
=======

The corresponding event listener class:

..  literalinclude:: _PasswordHasBeenResetEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php


..  _PasswordHasBeenResetEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/PasswordHasBeenResetEvent.rst.txt
