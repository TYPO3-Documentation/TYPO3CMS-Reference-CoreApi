..  include:: /Includes.rst.txt
..  index:: Events; BeforeStdWrapContentStoredInCacheEvent
..  _BeforeStdWrapContentStoredInCacheEvent:

======================================
BeforeStdWrapContentStoredInCacheEvent
======================================

..  versionadded:: 13.0
    This event serves as a more powerful replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap_cacheStore']`.

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\BeforeStdWrapContentStoredInCacheEvent`
is dispatched just before the final :ref:`stdWrap <t3tsref:stdwrap>` content is
added to the cache. It allows to fully manipulate the :php:`$content` to be
added, the cache :php:`$tags` to be used, as well as the corresponding cache
:php:`$key` and the cache :php:`$lifetime`.

Additionally, the new event provides the full TypoScript configuration
and the current :php:`ContentObjectRenderer` instance.

Example
=======

..  literalinclude:: _BeforeStdWrapContentStoredInCacheEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt


API
===

..  include:: /CodeSnippets/Events/Frontend/BeforeStdWrapContentStoredInCacheEvent.rst.txt
