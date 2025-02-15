..  include:: /Includes.rst.txt

..  index::
    Request attribute; Frontend cache collector
..  _typo3-request-attribute-frontend-cache-collector:

========================
Frontend cache collector
========================

..  versionadded:: 13.3
    This request attribute is a replacement for
    :php:`TypoScriptFrontendController->addCacheTags()` and
    :php:`TypoScriptFrontendController->getPageCacheTags()` which has been
    deprecated with TYPO3 v13.3 and removed with TYPO3 v14.0.

An API is available to collect cache tags and their corresponding lifetime. This
API is used in TYPO3 to accumulate cache tags from page cache and content object
cache.

The API is implemented as a PSR-7 request attribute `frontend.cache.collector`.

Every cache tag has a lifetime. The minimum lifetime is calculated
from all given cache tags. API users do not have to deal with it individually.

The default lifetime for a cache tag is :php:`PHP_INT_MAX`, so it expires many
years in the future.


..  _typo3-request-attribute-frontend-cache-collector-example-add-single-cache-tag:

Example: Add a single cache tag
===============================

..  code-block:: php

    // use TYPO3\CMS\Core\Cache\CacheTag;

    $cacheDataCollector = $request->getAttribute('frontend.cache.collector');
    $cacheDataCollector->addCacheTags(
        new CacheTag('tx_myextension_mytable'),
    );


..  _typo3-request-attribute-frontend-cache-collector-example-add-multiple-cache-tags:

Example: Add multiple cache tags with different lifetimes
=========================================================

..  code-block:: php

    // use TYPO3\CMS\Core\Cache\CacheTag;

    $cacheDataCollector = $request->getAttribute('frontend.cache.collector');
    $cacheDataCollector->addCacheTags(
        new CacheTag('tx_myextension_mytable_123', 3600),
        new CacheTag('tx_myextension_mytable_456', 2592000),
    );


..  _typo3-request-attribute-frontend-cache-collector-example-remove-single-cache-tag:

Example: Remove a single cache tag
==================================

..  code-block:: php

    // use TYPO3\CMS\Core\Cache\CacheTag;

    $cacheDataCollector = $request->getAttribute('frontend.cache.collector');
    $cacheDataCollector->removeCacheTags(
        new CacheTag('tx_myextension_mytable_123'),
    );


..  _typo3-request-attribute-frontend-cache-collector-example-remove-multiple-cache-tags:

Example: Remove multiple cache tags
===================================

..  code-block:: php

    // use TYPO3\CMS\Core\Cache\CacheTag;

    $cacheDataCollector = $request->getAttribute('frontend.cache.collector');
    $cacheDataCollector->removeCacheTags(
        new CacheTag('tx_myextension_mytable_123'),
        new CacheTag('tx_myextension_mytable_456'),
    );


..  _typo3-request-attribute-frontend-cache-collector-example-get-minimum-lifetime:

Example: Get minimum lifetime, calculated from all cache tags
=============================================================

..  code-block:: php
    :caption: Get minimum lifetime, calculated from all cache tags

    $cacheDataCollector = $request->getAttribute('frontend.cache.collector');
    $cacheDataCollector->resolveLifetime();


..  _typo3-request-attribute-frontend-cache-collector-example-get-all-cache-tags:

Example: Get all cache tags
===========================

..  code-block:: php

    $cacheDataCollector = $request->getAttribute('frontend.cache.collector');
    $cacheDataCollector->getCacheTags();


..  _typo3-request-attribute-frontend-cache-collector-api:

API
===

..  include:: /CodeSnippets/Manual/Cache/CacheDataCollector.rst.txt
