..  include:: /Includes.rst.txt
..  index:: Events; LoginAttemptFailedEvent
..  _LoginAttemptFailedEvent:

=======================
LoginAttemptFailedEvent
=======================

..  versionadded::  12.3
    The event replaces the deprecated hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['postLoginFailureProcessing']`
    .

The purpose of the PSR-14 event
:php:`\TYPO3\CMS\Core\Authentication\Event\LoginAttemptFailedEvent`
is to allow to notify remote systems about failed logins.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _LoginAttemptFailedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

An implementation of the event listener:

..  literalinclude:: _LoginAttemptFailedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Authentication/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/LoginAttemptFailedEvent.rst.txt
