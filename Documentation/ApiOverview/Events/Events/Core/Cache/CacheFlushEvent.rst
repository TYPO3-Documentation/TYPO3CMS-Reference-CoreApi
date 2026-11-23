..  include:: /Includes.rst.txt
..  index:: Events; CacheFlushEvent
..  _CacheFlushEvent:

=================
`CacheFlushEvent`
=================

The PSR-14 event :php:`\TYPO3\CMS\Core\Cache\Event\CacheFlushEvent` is
fired when :ref:`caches <caching>` are to be cleared. Extensions that keep
data outside of the caches of TYPO3, for example on a search server, flush it
in a listener.

..  versionchanged:: 15.0
    :changelog: breaking-111263-1793181136

    The event is dispatched by the
    `CacheFlusher <https://docs.typo3.org/permalink/t3coreapi:caching-flush-caches>`_
    whenever cache groups are flushed, also by the "Clear cache" actions of
    the backend and by page TSconfig `TCEMAIN.clearCacheCmd`. Before, only
    the command `cache:flush` dispatched it.

A listener reports an error with :php:`addError()`. The command `cache:flush`
shows the errors, and the
`result of the CacheFlusher <https://docs.typo3.org/permalink/t3coreapi:caching-flush-caches-result>`_
contains them.

..  _cache-flush-event-example:

Example: Flush the cache of a search server
===========================================

..  literalinclude:: _CacheFlushEvent/_FlushSearchIndexCache.php
    :caption: EXT:my_extension/Classes/EventListener/FlushSearchIndexCache.php

..  _cache-flush-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Cache\Event\CacheFlushEvent
