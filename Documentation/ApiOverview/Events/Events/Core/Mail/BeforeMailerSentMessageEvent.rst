..  include:: /Includes.rst.txt
..  index:: Events; BeforeMailerSentMessageEvent
..  _BeforeMailerSentMessageEvent:

============================
BeforeMailerSentMessageEvent
============================

..  versionadded:: 12.0

The PSR-14 event :php:`\TYPO3\CMS\Core\Mail\Event\BeforeMailerSentMessageEvent`
is dispatched before the message is sent by the mailer and can be
used to manipulate the :php:`\Symfony\Component\Mime\RawMessage` and the
:php:`\Symfony\Component\Mailer\Envelope`. Usually a
:php:`\Symfony\Component\Mime\Email` or :php:`\TYPO3\CMS\Core\Mail\FluidEmail`
instance is given as :php:`RawMessage`. Additionally the mailer instance is
given, which depends on the implementation - usually
:php:`\TYPO3\CMS\Core\Mail\Mailer`. It contains the
:php:`\Symfony\Component\Mailer\Transport` object, which can be retrieved using
the :php:`getTransport()` method.

..  _BeforeMailerSentMessageEvent-example:

Example
=======

This event adds an additional BCC receiver right before the mail is sent:

..  literalinclude:: _BeforeMailerSentMessageEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Mail/EventListener/AddMailMessageBcc.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

..  _BeforeMailerSentMessageEvent-api:

API
===

..  include:: /CodeSnippets/Events/Core/BeforeMailerSentMessageEvent.rst.txt
