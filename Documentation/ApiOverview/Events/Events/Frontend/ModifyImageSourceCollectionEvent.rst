..  include:: /Includes.rst.txt
..  index:: Events; ModifyImageSourceCollectionEvent
..  _ModifyImageSourceCollectionEvent:

================================
ModifyImageSourceCollectionEvent
================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\ModifyImageSourceCollectionEvent`
is being dispatched in :php:`ContentObjectRenderer->getImageSourceCollection()`
for each configured :php:`sourceCollection` and allows to enrich the final
source collection result.

Example
=======

..  literalinclude:: _ModifyImageSourceCollectionEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyImageSourceCollectionEvent.rst.txt
