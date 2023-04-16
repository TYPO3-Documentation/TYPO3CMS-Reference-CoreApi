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

API
===

..  include:: /CodeSnippets/Events/Core/Security/PolicyMutatedEvent.rst.txt
