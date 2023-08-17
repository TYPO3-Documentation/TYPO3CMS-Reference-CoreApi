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

..  literalinclude:: _LoginAttemptFailedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Authentication/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/LoginAttemptFailedEvent.rst.txt
