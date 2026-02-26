..  include:: /Includes.rst.txt
..  index:: Events; BeforeBackendPageRenderEvent
..  _BeforeBackendPageRenderEvent:

============================
BeforeBackendPageRenderEvent
============================

..  versionadded:: 14.0
    This PSR-14 event was introduced so that custom JavaScript modules and
    assets can be added to the TYPO3 backend top frame.

The PSR-14 event :php:`\TYPO3\CMS\Backend\Controller\Event\BeforeBackendPageRenderEvent`
is dispatched in the :php:`BackendController` before the main backend page is rendered.

The event allows extensions to inject custom assets into the backend top frame
by providing access to the following properties:

*   :php:`$view` (:php:`\TYPO3\CMS\Core\View\ViewInterface`) – assign additional template
    variables to the backend top frame view
*   :php:`$javaScriptRenderer` (:php:`\TYPO3\CMS\Core\Page\JavaScriptRenderer`) – add
    custom JavaScript modules to the backend top frame
*   :php:`$pageRenderer` (:php:`\TYPO3\CMS\Core\Page\PageRenderer`) – add further assets
    such as CSS files (marked :php:`@internal`)

..  _BeforeBackendPageRenderEvent-example:

Example
=======

..  literalinclude:: _BeforeBackendPageRenderEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/BeforeBackendPageRenderEvent.rst.txt
