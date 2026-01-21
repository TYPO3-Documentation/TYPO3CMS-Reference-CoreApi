..  include:: /Includes.rst.txt
..  index:: Events; AfterPageContentPreviewRenderedEvent
..  _AfterPageContentPreviewRenderedEvent:

====================================
AfterPageContentPreviewRenderedEvent
====================================

Use the PSR-14 event :php:`\TYPO3\CMS\Backend\View\Event\AfterPageContentPreviewRenderedEvent`
to enrich backend content previews, for example, by adding information from
different fields. This functionality may be particularly useful for
integrators.

The class :php:`\TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem` is
the main entity to generate previews of content elements.

Developers can generate previews either by using :php:`\TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent`
or by implementing :php:`\TYPO3\CMS\Backend\Preview\PreviewRendererInterface`.

..  _AfterPageContentPreviewRenderedEvent-example:

Example
=======

..  literalinclude:: _AfterPageContentPreviewRenderedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _AfterPageContentPreviewRenderedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/AfterPageContentPreviewRenderedEvent.rst.txt
