..  include:: /Includes.rst.txt

..  index::
    Request attribute; Frontend cache instruction
..  _typo3-request-attribute-frontend-cache-instruction:

==========================
Frontend cache instruction
==========================

..  versionadded:: 13.0
    This request attribute is a replacement for the removed
    :php:`TypoScriptFrontendController->no_cache` property.

The :php:`frontend.cache.instruction` frontend request attribute can be used by
:ref:`middlewares <request-handling>` to disable :ref:`cache <caching>`
mechanics of frontend rendering.

In early middlewares before :code:`typo3/cms-frontend/tsfe`, the attribute may
or may not exist already. A safe way to interact with it is like this:

..  literalinclude:: _FrontendCacheInstruction/_MyEarlyMiddleware.php
    :language: php
    :caption: EXT:my_extension/Classes/Middleware/MyEarlyMiddleware.php

Extension with middlewares or other code after :code:`typo3/cms-frontend/tsfe`
can assume the attribute to be set already. Usage example:

..  literalinclude:: _FrontendCacheInstruction/_MyLaterMiddleware.php
    :language: php
    :caption: EXT:my_extension/Classes/Middleware/MyLaterMiddleware.php


API
===

..  include:: /CodeSnippets/Manual/Entity/CacheInstruction.rst.txt
