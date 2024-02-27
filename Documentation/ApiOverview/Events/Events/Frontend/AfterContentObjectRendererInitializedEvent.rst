..  include:: /Includes.rst.txt
..  index:: Events; AfterContentObjectRendererInitializedEvent
..  _AfterContentObjectRendererInitializedEvent:

==========================================
AfterContentObjectRendererInitializedEvent
==========================================

..  versionadded:: 13.0
    This event serves as a drop-in replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['postInit']`.

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterContentObjectRendererInitializedEvent`
is being dispatched after the :php:`ContentObjectRenderer` has been initialized
in its :php:`start()` method.

Example
=======

..  literalinclude:: _AfterContentObjectRendererInitializedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterContentObjectRendererInitializedEvent.rst.txt
