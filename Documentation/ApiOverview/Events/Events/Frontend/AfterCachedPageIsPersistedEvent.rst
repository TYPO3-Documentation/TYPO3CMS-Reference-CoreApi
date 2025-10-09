..  include:: /Includes.rst.txt
..  index:: Events; AfterCachedPageIsPersistedEvent
..  _AfterCachedPageIsPersistedEvent:

===============================
AfterCachedPageIsPersistedEvent
===============================

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\AfterCachedPageIsPersistedEvent`
is commonly used to generate a static file cache. This event is only called if
the page was actually stored in TYPO3's page cache.

..  _AfterCachedPageIsPersistedEvent-example:

Example
=======

..  literalinclude:: _AfterCachedPageIsPersistedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

..  _AfterCachedPageIsPersistedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterCachedPageIsPersistedEvent.rst.txt
