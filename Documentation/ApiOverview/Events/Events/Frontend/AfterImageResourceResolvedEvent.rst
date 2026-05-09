..  include:: /Includes.rst.txt
..  index:: Events; AfterImageResourceResolvedEvent
..  _AfterImageResourceResolvedEvent:

===============================
AfterImageResourceResolvedEvent
===============================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterImageResourceResolvedEvent`
is being dispatched just before :php:`ContentObjectRenderer->getImgResource()`
is about to return the resolved :php:`\TYPO3\CMS\Core\Imaging\ImageResource`
:abbr:`DTO (Data Transfer Object)`. Therefore, the event is - in comparison to
the removed hook - always dispatched, even if no :php:`ImageResource` could be
resolved. In this case, the corresponding return value is :php:`null`.

Example
=======

..  literalinclude:: _AfterImageResourceResolvedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterImageResourceResolvedEvent.rst.txt
