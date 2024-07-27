..  include:: /Includes.rst.txt
..  index:: Events; PolicyMutatedEvent
..  _PolicyMutatedEvent:

==================
PolicyMutatedEvent
==================

..  versionadded:: 12.3

..  versionchanged:: 12.4 | 13.2
    The event also providse the current PSR-7 :php:`\Psr\Http\Message\ServerRequestInterface`
    for additional context

The PSR-14 event
:php:`\TYPO3\CMS\Core\Security\ContentSecurityPolicy\Event\PolicyMutatedEvent`
will be dispatched once all mutations have been applied to the current
:ref:`Content Security Policy <content-security-policy>` object, just before the
corresponding HTTP header is added to the HTTP response object. This allows
individual adjustments for custom implementations.

..  _PolicyMutatedEvent-Example:

Example
=======

..  literalinclude:: _PolicyMutatedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/ContentSecurityPolicy/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


..  _PolicyMutatedEvent-api:


API
===

..  include:: /CodeSnippets/Events/Core/Security/PolicyMutatedEvent.rst.txt
