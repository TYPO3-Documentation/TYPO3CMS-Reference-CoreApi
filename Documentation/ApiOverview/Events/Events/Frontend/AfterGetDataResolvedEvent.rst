..  include:: /Includes.rst.txt
..  index:: Events; AfterGetDataResolvedEvent
..  _AfterGetDataResolvedEvent:

===========================
`AfterGetDataResolvedEvent`
===========================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterGetDataResolvedEvent`
is being dispatched just before :php:`ContentObjectRenderer->getData()`
is about to return the resolved "data".

..  _after-get-data-resolved-event-example:

Example: Override the result of getData
=======================================

..  literalinclude:: _AfterGetDataResolvedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  _after-get-data-resolved-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Frontend\ContentObject\Event\AfterGetDataResolvedEvent
