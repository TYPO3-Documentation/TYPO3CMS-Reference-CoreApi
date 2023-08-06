..  include:: /Includes.rst.txt
..  index:: Events; PolicyMutatedEvent
..  _PolicyMutatedEvent:


==================
PolicyMutatedEvent
==================

..  versionadded:: 12.3

The PSR-14 event
:php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\Event\PolicyMutatedEvent`
will be dispatched once all mutations have been applied to the current
:ref:`Content Security Policy <content-security-policy>` object, just before the
corresponding HTTP header is added to the HTTP response object. This allows
individual adjustments for custom implementations.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _PolicyMutatedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

The corresponding event listener class:

..  literalinclude:: _PolicyMutatedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/ContentSecurityPolicy/EventListener/MyEventListener.php


API
===

..  include:: /CodeSnippets/Events/Core/Security/PolicyMutatedEvent.rst.txt
