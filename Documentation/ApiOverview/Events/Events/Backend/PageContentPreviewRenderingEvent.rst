..  include:: /Includes.rst.txt
..  index:: Events; PageContentPreviewRenderingEvent
..  _PageContentPreviewRenderingEvent:

================================
PageContentPreviewRenderingEvent
================================

..  versionadded:: 12.0
    The PSR-14 event :php:`TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent`
    has been introduced which serves as a drop-in replacement for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']`
    hook.

Use this event to ship an alternative rendering for a specific content type or
to manipulate the record data of a content element.

API
===

.. include:: /CodeSnippets/Events/Backend/PageContentPreviewRenderingEvent.rst.txt
