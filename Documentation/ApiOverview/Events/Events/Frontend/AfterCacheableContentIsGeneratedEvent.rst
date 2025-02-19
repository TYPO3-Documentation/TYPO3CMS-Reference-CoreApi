..  include:: /Includes.rst.txt
..  index:: Events; AfterCacheableContentIsGeneratedEvent
..  _AfterCacheableContentIsGeneratedEvent:

=====================================
AfterCacheableContentIsGeneratedEvent
=====================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\Event\AfterCacheableContentIsGeneratedEvent` can be
used to decide if a page should be stored in cache.

It is executed right after all cacheable content is generated.
It can also be used to manipulate the content before it is stored in
TYPO3's page cache. In the Core, the event is used in
:doc:`EXT:indexed_search <ext_indexed_search:Index>` to index cacheable content.

The :php:`AfterCacheableContentIsGeneratedEvent` contains the
information if a generated page is able to store in cache via the
:php:`$event->isCachingEnabled()` method. This can be used to
differentiate between the previous hooks `contentPostProc-cached` and
`contentPostProc-all`. The later hook was called regardless of whether the
cache was enabled or not.

Example
=======

..  todo: The property TSFE->content used in the example was marked as internal
          in v13. A substitution is needed for this.

..  note::
    Currently, the example below is outdated. It uses a - now internal -
    property :php:`TypoScriptFrontendController->content`.

..  literalinclude:: _AfterCacheableContentIsGeneratedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterCacheableContentIsGeneratedEvent.rst.txt
