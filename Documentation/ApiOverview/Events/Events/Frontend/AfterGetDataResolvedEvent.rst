..  include:: /Includes.rst.txt
..  index:: Events; AfterGetDataResolvedEvent
..  _AfterGetDataResolvedEvent:

=========================
AfterGetDataResolvedEvent
=========================

..  versionadded:: 13.0
    This event serves as a drop-in replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['getData']`.
    In comparison to the removed hook, the event is not dispatched for every
    section of the parameter string, but only once, making the former
    :php:`$secVal` superfluous.

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterGetDataResolvedEvent`
is being dispatched just before :php:`ContentObjectRenderer->getData()`
is about to return the resolved "data".

Example
=======

..  literalinclude:: _AfterGetDataResolvedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterGetDataResolvedEvent.rst.txt
