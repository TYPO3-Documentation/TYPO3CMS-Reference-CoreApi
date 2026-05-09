..  include:: /Includes.rst.txt
..  index:: Events; AfterContentObjectRendererInitializedEvent
..  _AfterContentObjectRendererInitializedEvent:

==========================================
AfterContentObjectRendererInitializedEvent
==========================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterContentObjectRendererInitializedEvent`
is being dispatched after the :php:`ContentObjectRenderer` has been initialized
in its :php:`start()` method.

Example
=======

..  literalinclude:: _AfterContentObjectRendererInitializedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterContentObjectRendererInitializedEvent.rst.txt
