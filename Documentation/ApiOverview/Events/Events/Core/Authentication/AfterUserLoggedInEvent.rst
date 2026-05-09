..  include:: /Includes.rst.txt
..  index:: Events; AfterUserLoggedInEvent
..  _AfterUserLoggedInEvent:

======================
AfterUserLoggedInEvent
======================

The purpose of the PSR-14 event
:php:`\TYPO3\CMS\Core\Authentication\Event\AfterUserLoggedInEvent`
is to trigger any kind of action when a backend or frontend user has been
successfully logged in.

The TYPO3 Core itself uses this event in the TYPO3 backend to send an email to a
user, if the user has successfully logged in. See
:t3src:`backend/Classes/Security/EmailLoginNotification.php`.


Example
=======

..  literalinclude:: _AfterUserLoggedInEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Authentication/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/AfterUserLoggedInEvent.rst.txt
