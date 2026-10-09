..  include:: /Includes.rst.txt
..  index:: Events; BeforeActionRateLimitResponseEvent
..  _BeforeActionRateLimitResponseEvent:

====================================
`BeforeActionRateLimitResponseEvent`
====================================

..  versionadded:: 14.2
    :changelog: feature-108982-1771078311

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Mvc\BeforeActionRateLimitResponseEvent` is
dispatched when an Extbase action annotated with
`#[RateLimit] <https://docs.typo3.org/permalink/t3coreapi:extbase-controller-action-ratelimit>`_
has reached its limit, before the response leaves the controller. A listener
can replace that response or act on the event, for example to write a log
entry.

Without a listener, Extbase answers with
`HTTP 429 Too many requests <https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/429>`_.

..  _BeforeActionRateLimitResponseEvent-example:

Example: let the site error handler answer instead
==================================================

The following listener passes the request to the error handler of the site. A
visitor who reaches the limit then sees the error page of the site, and not a
bare 429 response:

..  literalinclude:: _BeforeActionRateLimitResponseEvent/_RateLimitErrorPageListener.php
    :caption: EXT:my_extension/Classes/EventListener/RateLimitErrorPageListener.php

Calling :php:`setResponse()` instead returns a response of your own and keeps
the request in Extbase.

..  _BeforeActionRateLimitResponseEvent-api:

API
===

..  include:: /CodeSnippets/Events/Extbase/BeforeActionRateLimitResponseEvent.rst.txt
