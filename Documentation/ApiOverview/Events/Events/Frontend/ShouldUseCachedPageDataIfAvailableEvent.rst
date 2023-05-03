..  include:: /Includes.rst.txt
..  index:: Events; ShouldUseCachedPageDataIfAvailableEvent
..  _ShouldUseCachedPageDataIfAvailableEvent:

=======================================
ShouldUseCachedPageDataIfAvailableEvent
=======================================

..  versionadded:: 12.0

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\ShouldUseCachedPageDataIfAvailableEvent`
allows TYPO3 extensions to register event listeners to modify if a
page should be read from cache (if it has been created in store already), or
if it should be re-built completely ignoring the cache entry for the request.

This event can be used to avoid loading from the cache when indexing via
CLI happens from an external source, or if the cache should be ignored when
logged in from a certain IP address.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ShouldUseCachedPageDataIfAvailableEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _ShouldUseCachedPageDataIfAvailableEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Frontend/ShouldUseCachedPageDataIfAvailableEvent.rst.txt
