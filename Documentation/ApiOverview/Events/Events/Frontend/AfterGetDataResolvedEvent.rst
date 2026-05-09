..  include:: /Includes.rst.txt
..  index:: Events; AfterGetDataResolvedEvent
..  _AfterGetDataResolvedEvent:

=========================
AfterGetDataResolvedEvent
=========================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterGetDataResolvedEvent`
is being dispatched just before :php:`ContentObjectRenderer->getData()`
is about to return the resolved "data".

Example
=======

..  literalinclude:: _AfterGetDataResolvedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterGetDataResolvedEvent.rst.txt
