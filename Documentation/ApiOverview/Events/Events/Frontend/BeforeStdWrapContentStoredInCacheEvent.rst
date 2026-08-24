..  include:: /Includes.rst.txt
..  index:: Events; BeforeStdWrapContentStoredInCacheEvent
..  _BeforeStdWrapContentStoredInCacheEvent:

========================================
`BeforeStdWrapContentStoredInCacheEvent`
========================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\BeforeStdWrapContentStoredInCacheEvent`
is dispatched just before the final :ref:`stdWrap <t3tsref:stdwrap>` content is
added to the cache. It allows to fully manipulate the :php:`$content` to be
added, the cache :php:`$tags` to be used, as well as the corresponding cache
:php:`$key` and the cache :php:`$lifetime`.

Additionally, the new event provides the full TypoScript configuration
and the current :php:`ContentObjectRenderer` instance.

..  _before-std-wrap-content-stored-in-cache-event-example:

Example
=======

..  literalinclude:: _BeforeStdWrapContentStoredInCacheEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php


..  _before-std-wrap-content-stored-in-cache-event-api:

API
===

..  include:: /CodeSnippets/Events/Frontend/BeforeStdWrapContentStoredInCacheEvent.rst.txt
