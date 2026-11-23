..  include:: /Includes.rst.txt
..  index:: Events; AfterCacheFlushedEvent
..  _AfterCacheFlushedEvent:

========================
`AfterCacheFlushedEvent`
========================

..  versionadded:: 15.0
    :changelog: feature-111263-1793181135

The PSR-14 event :php:`\TYPO3\CMS\Core\Cache\Event\AfterCacheFlushedEvent` is
dispatched by the
`CacheFlusher <https://docs.typo3.org/permalink/t3coreapi:caching-flush-caches>`_
once after the caches were flushed. Its
:php-short:`\TYPO3\CMS\Core\Cache\Flush\CacheFlushResult` names the flushed
cache tags and cache groups.

Every flush of TYPO3 goes through the `CacheFlusher`: changed records in the
DataHandler, the "Clear cache" actions of the backend, "Flush cache" in the
Install Tool, and the commands `cache:flush` and `cache:flushtags`. A listener
of this event therefore learns about every flush, for example to purge a
reverse proxy or a CDN.

..  _AfterCacheFlushedEvent-example:

Example: Purge a reverse proxy
==============================

..  literalinclude:: _AfterCacheFlushedEvent/_PurgeReverseProxy.php
    :caption: EXT:my_extension/Classes/EventListener/PurgeReverseProxy.php

..  _AfterCacheFlushedEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Cache\Event\AfterCacheFlushedEvent
    :include-constructor:
    :no-class-comment:

..  typo3:api-class:: \TYPO3\CMS\Core\Cache\Flush\CacheFlushResult
