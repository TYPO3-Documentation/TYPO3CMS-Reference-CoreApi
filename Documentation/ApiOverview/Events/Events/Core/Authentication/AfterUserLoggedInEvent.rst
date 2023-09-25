..  include:: /Includes.rst.txt
..  index:: Events; AfterUserLoggedInEvent
..  _AfterUserLoggedInEvent:

======================
AfterUserLoggedInEvent
======================

..  versionadded::  12.3
    The event replaces the deprecated hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauthgroup.php']['backendUserLogin']`.

The purpose of the PSR-14 event
:php:`\TYPO3\CMS\Core\Authentication\Event\AfterUserLoggedInEvent`
is to trigger any kind of action when a backend user has been successfully
logged in.

The TYPO3 Core itself uses this event in the TYPO3 backend to send an email to a
user, if the user has successfully logged in. See
:t3src:`backend/Classes/Security/EmailLoginNotification.php`.


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AfterUserLoggedInEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

An implementation of the event listener:

..  literalinclude:: _AfterUserLoggedInEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Authentication/EventListener/MyEventListener.php

..  note::
    With TYPO3 v13 the event is also dispatched when a successful frontend user
    login is performed. Prepare your code and check, if the user is an instance
    of :php:`\TYPO3\CMS\Core\Authentication\BackendUserAuthentication` (where
    necessary) like in the example above.

API
===

..  include:: /CodeSnippets/Events/Core/AfterUserLoggedInEvent.rst.txt
