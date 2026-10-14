..  include:: /Includes.rst.txt
..  index:: Events; BeforeActionAuthorizationDeniedEvent
..  _BeforeActionAuthorizationDeniedEvent:

======================================
`BeforeActionAuthorizationDeniedEvent`
======================================

..  versionadded:: 14.2
    :changelog: feature-107826-1766220191

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Mvc\BeforeActionAuthorizationDeniedEvent` is
dispatched when an Extbase action is protected with
`#[Authorize] <https://docs.typo3.org/permalink/t3coreapi:extbase-controller-action-authorize>`_
and one of its checks fails. The event is dispatched before the action is
called. :php:`getFailureReason()` tells which check failed: the login, the
groups, or the callback.

Without a listener, or when no listener calls :php:`setResponse()`, Extbase
answers with
`HTTP 403 Forbidden <https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/403>`_.
When the site configures an error handler for status 403, that handler
renders the response.

..  _BeforeActionAuthorizationDeniedEvent-example:

Example: log denied access to Extbase actions
=============================================

The following listener writes a log entry for each denied request. It does not
set a response, so the visitor still gets the 403 response:

..  literalinclude:: _BeforeActionAuthorizationDeniedEvent/_LogDeniedActionAccessListener.php
    :caption: EXT:my_extension/Classes/EventListener/LogDeniedActionAccessListener.php

..  warning::

    A listener that calls :php:`setResponse()` must not change domain objects
    or use Extbase persistence: the action has not run yet. Set a response
    only for uncached actions. In a cached action, the response goes into the
    page cache and all visitors get it, whether they have access or not.

..  _BeforeActionAuthorizationDeniedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Extbase/BeforeActionAuthorizationDeniedEvent.rst.txt
