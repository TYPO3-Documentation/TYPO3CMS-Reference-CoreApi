.. include:: /Includes.rst.txt
.. index:: Events; AfterCachedPageIsPersistedEvent
.. _AfterCachedPageIsPersistedEvent:

===============================
AfterCachedPageIsPersistedEvent
===============================

..  versionadded:: 12.0

    This event together with :ref:`AfterCacheableContentIsGeneratedEvent` has
    been introduced to serve as a direct replacement for the removed hook:

    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['insertPageIncache']`

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\AfterCachedPageIsPersistedEvent`
is commonly used to generate a static file cache. This event is only called if
the page was actually stored in TYPO3's page cache.

Example
=======

..  literalinclude:: _AfterCachedPageIsPersistedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterCachedPageIsPersistedEvent.rst.txt
