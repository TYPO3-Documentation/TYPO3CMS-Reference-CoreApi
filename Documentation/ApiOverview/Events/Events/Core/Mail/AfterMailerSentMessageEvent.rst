..  include:: /Includes.rst.txt
..  index:: Events; AfterMailerSentMessageEvent
..  _AfterMailerSentMessageEvent:

=============================
`AfterMailerSentMessageEvent`
=============================

The PSR-14 event :php:`\TYPO3\CMS\Core\Mail\Event\AfterMailerSentMessageEvent`
is dispatched as soon as the message has been sent via the corresponding
:php:`\Symfony\Component\Mailer\Transport\TransportInterface`.
It receives the current mailer instance, which depends on the implementation -
usually :php:`\TYPO3\CMS\Core\Mail\Mailer`. It contains the
:php:`\Symfony\Component\Mailer\SentMessage` object, which can be retrieved
using the :php:`getSentMessage()` method.

..  _after-mailer-sent-message-event-example:

Example
=======

..  literalinclude:: _AfterMailerSentMessageEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Mail/EventListener/MyEventListener.php

..  _after-mailer-sent-message-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/AfterMailerSentMessageEvent.rst.txt
