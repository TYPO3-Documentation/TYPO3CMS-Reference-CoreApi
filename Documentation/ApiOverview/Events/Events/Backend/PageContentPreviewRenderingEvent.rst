..  include:: /Includes.rst.txt
..  index:: Events; PageContentPreviewRenderingEvent
..  _PageContentPreviewRenderingEvent:

================================
PageContentPreviewRenderingEvent
================================

..  versionadded:: 12.0
    This event has been introduced which serves as a drop-in replacement for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']`
    hook.

Use the PSR-14 event
:php:`\TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent`
to ship an alternative rendering for a specific content type or
to manipulate the record data of a content element.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _PageContentPreviewRenderingEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _PageContentPreviewRenderingEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php


API
===

..  include:: /CodeSnippets/Events/Backend/PageContentPreviewRenderingEvent.rst.txt
