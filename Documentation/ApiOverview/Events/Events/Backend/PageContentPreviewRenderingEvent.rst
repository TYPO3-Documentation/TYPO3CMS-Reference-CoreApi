..  include:: /Includes.rst.txt
..  index:: Events; PageContentPreviewRenderingEvent
..  _PageContentPreviewRenderingEvent:

================================
PageContentPreviewRenderingEvent
================================

Use the PSR-14 event
:php:`\TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent`
to ship an alternative rendering for a specific content type or
to manipulate the record data of a content element.

..  versionchanged:: 14.0
    `PageContentPreviewRenderingEvent->getRecord()` now returns a
    :php:`RecordInterface` object instead of an array,
    :php:`PageContentPreviewRenderingEvent->setRecord()` has been adjusted
    accordingly.

..  _PageContentPreviewRenderingEvent-example:

Example
=======

..  literalinclude:: _PageContentPreviewRenderingEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

..  _PageContentPreviewRenderingEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/PageContentPreviewRenderingEvent.rst.txt
