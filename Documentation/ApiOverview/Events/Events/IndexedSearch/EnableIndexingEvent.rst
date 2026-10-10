..  include:: /Includes.rst.txt
..  index:: Events; EnableIndexingEvent
..  _EnableIndexingEvent:

=====================
`EnableIndexingEvent`
=====================

The PSR-14 event :php:`\TYPO3\CMS\IndexedSearch\Event\EnableIndexingEvent`
decides whether the page that is currently rendered in the frontend is
indexed. The extension :composer:`typo3/cms-indexed-search` dispatches it
only when :typoscript:`config.index_enable` is set.

A listener can do one of the following:

*   Call :php-short:`\TYPO3\CMS\IndexedSearch\Event\EnableIndexingEvent::enableIndexing()`
    to index the page although the extension setting `disableFrontendIndexing`
    is enabled.
*   Call :php-short:`\TYPO3\CMS\IndexedSearch\Event\EnableIndexingEvent::disableIndexing()`
    to prevent the indexing of the page. This call takes precedence over
    `enableIndexing()` of any listener.

..  versionchanged:: 14.3
    :changelog: important-100465-1790207767

    The method `disableIndexing()` replaces setting `index_enable = 0` on
    :php:`$GLOBALS['TSFE']->config`, which is no longer available.

..  _EnableIndexingEvent-example:

Example: Do not index filtered list views
=========================================

The following listener prevents the indexing of a page that shows a list
filtered by GET parameters, so that every filter combination does not end
up in the index:

..  literalinclude:: _EnableIndexingEvent/_DisableIndexingListener.php
    :caption: EXT:my_extension/Classes/EventListener/DisableIndexingListener.php

..  _EnableIndexingEvent-api:

API
===

..  include:: /CodeSnippets/Events/IndexedSearch/EnableIndexingEvent.rst.txt
