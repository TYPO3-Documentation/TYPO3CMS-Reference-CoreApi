..  include:: /Includes.rst.txt
..  index:: Events; AfterMailerInitializationEvent
..  _AfterMailerInitializationEvent:

==============================
AfterMailerInitializationEvent
==============================

The PSR-14 event :php:`\TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent`
is fired once a new :ref:`mailer <mail>` is instantiated with specific transport
settings. So it is possible to add custom mailing settings.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AfterMailerInitializationEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

An example listener, which hooks into the Mailer API to modify mailer settings
to not send any emails ("null mailer"), could look like this:

..  literalinclude:: _AfterMailerInitializationEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Mail/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/AfterMailerInitializationEvent.rst.txt
