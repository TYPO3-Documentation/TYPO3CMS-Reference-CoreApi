..  include:: /Includes.rst.txt
..  index:: Events; AfterPageUriGeneratedEvent
..  _AfterPageUriGeneratedEvent:

============================
`AfterPageUriGeneratedEvent`
============================

..  versionadded:: 14.2
    See `Feature: #92780 - Introduce event after page URI generation <https://docs.typo3.org/permalink/changelog:feature-92780-1761709200>`_.

The PSR-14 event
:php:`\TYPO3\CMS\Core\Routing\Event\AfterPageUriGeneratedEvent`
is dispatched in :php-short:`\TYPO3\CMS\Core\Routing\PageRouter->generateUri()`. It
provides access to the generated URI and the arguments passed to
:php:`generateUri()`. Listeners can inspect and replace the generated URI. The
parameters payload reflects the sanitized query arguments after handling of
special parameters like :php:`id` and :php:`_language`.

:php:`PageRouter->generateUri()` is called from many different contexts
across TYPO3 Core, not only during frontend page rendering. This event
therefore fires for URIs generated in the backend (page preview, FormEngine,
new-record redirects), workspace preview links, XML sitemaps, redirect source
detection, webhook payloads, and error handlers, among others.

Listeners that modify the URI must therefore be context-aware. Use
:php:`getType()` (see :php-short:`\TYPO3\CMS\Core\Routing\RouterInterface`) to
distinguish between an absolute URL (:php:`RouterInterface::ABSOLUTE_URL`)
and an absolute path (:php:`RouterInterface::ABSOLUTE_PATH`), and use
:php:`getSite()`, :php:`getLanguage()`, or :php:`getRoute()` to limit
modifications to the intended context. When replacing the URI, listeners
must ensure that the returned URI is valid in their setup and remains
routable.

..  attention::
    Unconditionally replacing URIs can break backend previews, sitemaps, or
    other subsystems in non-obvious ways.

..  _AfterPageUriGeneratedEvent-example:

Example: Add a tracking parameter to absolute URLs of one site
==============================================================

The following listener appends a tracking query parameter to absolute URLs
generated for one specific site, demonstrating both the context-aware
scoping described above and how to actually replace the generated URI:

..  literalinclude:: _AfterPageUriGeneratedEvent/_ModifyAbsolutePageUriListener.php
    :caption: EXT:my_extension/Classes/EventListener/ModifyAbsolutePageUriListener.php

..  _AfterPageUriGeneratedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Core/AfterPageUriGeneratedEvent.rst.txt
