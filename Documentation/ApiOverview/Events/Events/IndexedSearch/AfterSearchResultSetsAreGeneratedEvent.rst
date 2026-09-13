..  include:: /Includes.rst.txt
..  index:: Events; AfterSearchResultSetsAreGeneratedEvent
..  _AfterSearchResultSetsAreGeneratedEvent:

========================================
`AfterSearchResultSetsAreGeneratedEvent`
========================================

..  versionadded:: 14.2
    See `Feature: #109018 - PSR-14 event to modify indexed_search result sets <https://docs.typo3.org/permalink/changelog:feature-109018-1769714898>`_.

The PSR-14 event
:php:`\TYPO3\CMS\IndexedSearch\Event\AfterSearchResultSetsAreGeneratedEvent`
allows complete search result sets to be modified. It is dispatched in
:php-short:`\TYPO3\CMS\IndexedSearch\Controller\SearchController->searchAction()`
after all result sets have been built. Listeners can manipulate complete
result sets in a single place, including pagination, rows, section data, and
category metadata.

..  _AfterSearchResultSetsAreGeneratedEvent-example:

Example: Use sliding window pagination for search results
=========================================================

The following listener replaces the default
:php-short:`\TYPO3\CMS\Core\Pagination\SimplePagination` of every result set with a
:php-short:`\TYPO3\CMS\Core\Pagination\SlidingWindowPagination`, reusing the same
underlying paginator:

..  literalinclude:: _AfterSearchResultSetsAreGeneratedEvent/_ReplaceSearchResultPaginationListener.php
    :caption: EXT:my_extension/Classes/EventListener/ReplaceSearchResultPaginationListener.php

..  _AfterSearchResultSetsAreGeneratedEvent-api:

API
===

..  include:: /CodeSnippets/Events/IndexedSearch/AfterSearchResultSetsAreGeneratedEvent.rst.txt
