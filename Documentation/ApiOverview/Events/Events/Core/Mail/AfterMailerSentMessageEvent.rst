..  include:: /Includes.rst.txt
..  index:: Events; AfterMailerSentMessageEvent
..  _AfterMailerSentMessageEvent:

===========================
AfterMailerSentMessageEvent
===========================

..  versionadded:: 12.0

The PSR-14 event :php:`\TYPO3\CMS\Core\Mail\Event\AfterMailerSentMessageEvent`
is dispatched as soon as the message has been sent via the corresponding
:php:`\Symfony\Component\Mailer\Transport\TransportInterface`.
It receives the current mailer instance, which depends on the implementation -
usually :php:`\TYPO3\CMS\Core\Mail\Mailer`. It contains the
:php:`\Symfony\Component\Mailer\SentMessage` object, which can be retrieved
using the :php:`getSentMessage()` method.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AfterMailerSentMessageEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _AfterMailerSentMessageEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Mail/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/AfterMailerSentMessageEvent.rst.txt
