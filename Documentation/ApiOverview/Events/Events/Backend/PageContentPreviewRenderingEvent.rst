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

Example
=======

..  literalinclude:: _PageContentPreviewRenderingEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

..  include:: /CodeSnippets/Events/Backend/PageContentPreviewRenderingEvent.rst.txt
