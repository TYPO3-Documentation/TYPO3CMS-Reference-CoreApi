:navigation-title: Flush caches in PHP

..  include:: /Includes.rst.txt
..  index::
    Caching; Flush
    CacheFlusher
..  _caching-flush-caches:

===========================================
Flush caches in PHP with the `CacheFlusher`
===========================================

..  versionadded:: 15.0
    :changelog: feature-111263-1793181135

    The cache flushing of the DataHandler was extracted into the service
    :php-short:`\TYPO3\CMS\Core\Cache\Flush\CacheFlusher`.

The service :php-short:`\TYPO3\CMS\Core\Cache\Flush\CacheFlusher` flushes the
caches of changed records, pages, cache tags, cache groups, and cache
commands. It needs no :php-short:`\TYPO3\CMS\Core\DataHandling\DataHandler`
and no backend user, so it can be used in a console command, a scheduler task,
or an import, for example.

The DataHandler, the "Clear cache" actions of the backend, "Flush cache" in
the Install Tool, uninstalling an extension, and the commands `cache:flush`
and `cache:flushtags` all flush the caches with this service.

..  contents:: Table of contents
    :local:

..  _caching-flush-caches-usage:

Flush the caches of a record
============================

After an extension wrote a record without the DataHandler, it flushes the
caches of the pages that show the record:

..  literalinclude:: _MyImportService.php
    :caption: EXT:my_extension/Classes/Service/MyImportService.php

The service follows the same rules as the DataHandler, including the page
TSconfig options
`TCEMAIN.clearCache_disable <https://docs.typo3.org/permalink/t3tsref:pagetcemain-clearcache-disable>`_,
`TCEMAIN.clearCache_pageSiblingChildren <https://docs.typo3.org/permalink/t3tsref:pagetcemain-clearcache-pagesiblingchildren>`_,
`TCEMAIN.clearCache_pageGrandParent <https://docs.typo3.org/permalink/t3tsref:pagetcemain-clearcache-pagegrandparent>`_,
and `TCEMAIN.clearCacheCmd <https://docs.typo3.org/permalink/t3tsref:pagetcemain-clearcachecmd>`_.

..  _caching-flush-caches-demand:

Describe what to flush
======================

A :php-short:`\TYPO3\CMS\Core\Cache\Flush\CacheFlushDemand` describes what to
flush:

:php:`CacheFlushDemand::forRecord('tt_content', 12)`
    The caches of the pages related to the record, as the DataHandler
    flushes them.

:php:`CacheFlushDemand::forPageTagsByPageIds(1, 2)`
    The cache tags `pageId_1` and `pageId_2` only, without the related pages
    and without page TSconfig.

:php:`CacheFlushDemand::forTags('news')`
    Cache tags in the caches of the group `pages`.

:php:`CacheFlushDemand::forTagsInGroup('system', 'news')`
    Cache tags in the caches of another group. The group `all` stands for
    all caches, including caches without a group.

:php:`CacheFlushDemand::forGroups('system')`
    All caches of one or more cache groups. The group `all` flushes all
    caches.

:php:`CacheFlushDemand::forCommand('pages')`
    A cache command, as in
    `TCEMAIN.clearCacheCmd <https://docs.typo3.org/permalink/t3tsref:pagetcemain-clearcachecmd>`_,
    such as `pages`, `all`, or a page ID.

The methods :php:`withRecord()`, :php:`withTagsInGroup()`, and
:php:`withGroups()` add more to a demand. Cache tags and cache groups of a
group that does not exist are skipped.

..  _caching-flush-caches-context:

Flush the caches on behalf of a backend user
============================================

By default, the service flushes everything that the demand asks for. A
:php-short:`\TYPO3\CMS\Core\Cache\Flush\CacheFlushingContext` created from a
backend user flushes the group `pages` and all caches only if the user may do
so, see the user TSconfig options
`options.clearCache.pages <https://docs.typo3.org/permalink/t3tsref:useroptions-clearcache-pages>`_
and `options.clearCache.all <https://docs.typo3.org/permalink/t3tsref:useroptions-clearcache-all>`_:

..  literalinclude:: _FlushAsBackendUser.php
    :caption: EXT:my_extension/Classes/Controller/CacheController.php (excerpt)

..  _caching-flush-caches-result:

The result of a flush
=====================

:php:`CacheFlusher->flush()` returns a
:php-short:`\TYPO3\CMS\Core\Cache\Flush\CacheFlushResult`:

*   :php:`getTags()` returns the flushed cache tags of a group, or of all
    groups.
*   :php:`$groups` lists the flushed cache groups, :php:`includesGroup()`
    tells whether a group was flushed.
*   :php:`getFlushedRecords()` and :php:`getSkippedRecords()` list the
    records, :php:`$skippedGroups` the groups that were skipped, with the
    reason.
*   :php:`$errors` and :php:`hasErrors()` show the errors that listeners of
    `CacheFlushEvent <https://docs.typo3.org/permalink/t3coreapi:cacheflushevent>`_
    reported.

:php:`CacheFlusher->resolve()` returns the plan of what would be flushed,
without flushing anything.

..  _caching-flush-caches-events:

Events
======

The service dispatches these PSR-14 events. Callers only describe what to
flush:

`BeforeRecordRelatedCachesAreFlushedEvent <https://docs.typo3.org/permalink/t3coreapi:beforerecordrelatedcachesareflushedevent>`_
    Once for every changed record, with the pages, cache tags, and cache
    commands related to it, which a listener can change.

`BeforeCacheFlushEvent <https://docs.typo3.org/permalink/t3coreapi:beforecacheflushevent>`_
    Once per flush, with the complete plan, which a listener can change.

`CacheFlushEvent <https://docs.typo3.org/permalink/t3coreapi:cacheflushevent>`_
    When cache groups are flushed.

`AfterCacheFlushedEvent <https://docs.typo3.org/permalink/t3coreapi:aftercacheflushedevent>`_
    Once after the caches were flushed, with the result, for example to
    purge a reverse proxy.

:php:`CacheFlusher->resolve()` dispatches the two "Before" events as well.
Their listeners must only change what is flushed, and leave the follow-up
work to a listener of the "After" event.
