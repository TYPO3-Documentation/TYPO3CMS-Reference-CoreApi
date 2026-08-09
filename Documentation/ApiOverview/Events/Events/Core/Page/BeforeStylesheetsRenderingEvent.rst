..  include:: /Includes.rst.txt
..  index:: Events; BeforeStylesheetsRenderingEvent
..  _BeforeStylesheetsRenderingEvent:


=================================
`BeforeStylesheetsRenderingEvent`
=================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Page\Event\BeforeStylesheetsRenderingEvent`
is fired once before
:php:`\TYPO3\CMS\Core\Page\AssetRenderer::render[Inline]Stylesheets`
renders the output.

..  _before-stylesheets-rendering-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-stylesheets-rendering-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/BeforeStylesheetsRenderingEvent.rst.txt
