..  include:: /Includes.rst.txt
..  index:: Events; BeforeStylesheetsRenderingEvent
..  _BeforeStylesheetsRenderingEvent:


===============================
BeforeStylesheetsRenderingEvent
===============================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Page\Event\BeforeStylesheetsRenderingEvent`
is fired once before
:php:`\TYPO3\CMS\Core\Page\AssetRenderer::render[Inline]Stylesheets`
renders the output.

API
===

..  include:: /CodeSnippets/Events/Core/BeforeStylesheetsRenderingEvent.rst.txt

