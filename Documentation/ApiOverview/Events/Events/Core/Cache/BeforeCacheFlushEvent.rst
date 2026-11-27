..  include:: /Includes.rst.txt
..  index:: Events; BeforeCacheFlushEvent
..  _BeforeCacheFlushEvent:

=======================
`BeforeCacheFlushEvent`
=======================

..  versionadded:: 15.0
    :changelog: feature-111263-1793181135

The PSR-14 event :php:`\TYPO3\CMS\Core\Cache\Event\BeforeCacheFlushEvent` is
dispatched by the
`CacheFlusher <https://docs.typo3.org/permalink/t3coreapi:caching-flush-caches>`_
once per flush, before anything is flushed. Its
:php-short:`\TYPO3\CMS\Core\Cache\Flush\CacheFlushPlan` holds the records,
cache commands, cache tags, and cache groups. A listener can add or remove
cache tags and cache groups.

The event is also dispatched by :php:`CacheFlusher->resolve()`, which flushes
nothing. A listener must only change the plan. Follow-up work belongs into a
listener of
`AfterCacheFlushedEvent <https://docs.typo3.org/permalink/t3coreapi:aftercacheflushedevent>`_.

..  _BeforeCacheFlushEvent-example:

Example: Flush the cache of the news feed
=========================================

..  literalinclude:: _BeforeCacheFlushEvent/_FlushNewsFeedCache.php
    :caption: EXT:my_extension/Classes/EventListener/FlushNewsFeedCache.php

..  _BeforeCacheFlushEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Cache\Event\BeforeCacheFlushEvent
    :include-constructor:

..  typo3:api-class:: \TYPO3\CMS\Core\Cache\Flush\CacheFlushPlan
