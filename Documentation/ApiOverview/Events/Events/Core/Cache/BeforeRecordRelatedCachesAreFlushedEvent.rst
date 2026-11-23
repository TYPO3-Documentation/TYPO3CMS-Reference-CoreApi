..  include:: /Includes.rst.txt
..  index:: Events; BeforeRecordRelatedCachesAreFlushedEvent
..  _BeforeRecordRelatedCachesAreFlushedEvent:

==========================================
`BeforeRecordRelatedCachesAreFlushedEvent`
==========================================

..  versionadded:: 15.0
    :changelog: feature-111263-1793181135

    The event replaces the hooks `clearPageCacheEval` and
    `clearCachePostProc` of the DataHandler, see
    `Migration <https://docs.typo3.org/permalink/changelog:breaking-111263-1793181136>`_.

The PSR-14 event
:php:`\TYPO3\CMS\Core\Cache\Event\BeforeRecordRelatedCachesAreFlushedEvent`
is dispatched by the
`CacheFlusher <https://docs.typo3.org/permalink/t3coreapi:caching-flush-caches>`_
for every changed record, before its caches are flushed. It holds the pages,
cache tags, and cache commands related to the record, which TYPO3 resolved
from the page tree and the page TSconfig options `TCEMAIN.clearCache_*` and
`TCEMAIN.clearCacheCmd`. A listener can change them.

The pages are flushed by their cache tag `pageId_<uid>`. A record that is
skipped, for example by `TCEMAIN.clearCache_disable`, comes without pages and
cache tags, but with its cache commands.

The event is also dispatched by :php:`CacheFlusher->resolve()`, which flushes
nothing. A listener must only change what is flushed. Follow-up work belongs
into a listener of
`AfterCacheFlushedEvent <https://docs.typo3.org/permalink/t3coreapi:aftercacheflushedevent>`_.

..  _BeforeRecordRelatedCachesAreFlushedEvent-example:

Example: Flush the page that lists the news
===========================================

..  literalinclude:: _BeforeRecordRelatedCachesAreFlushedEvent/_FlushNewsListPage.php
    :caption: EXT:my_extension/Classes/EventListener/FlushNewsListPage.php

..  _BeforeRecordRelatedCachesAreFlushedEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Cache\Event\BeforeRecordRelatedCachesAreFlushedEvent
    :include-constructor:
