..  include:: /Includes.rst.txt
..  index:: Events; BeforeJavaScriptsRenderingEvent
..  _BeforeJavaScriptsRenderingEvent:


===============================
BeforeJavaScriptsRenderingEvent
===============================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Page\Event\BeforeJavaScriptsRenderingEvent`
is fired once before
:php:`\TYPO3\CMS\Core\Page\AssetRenderer::render[Inline]JavaScript`
renders the output.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/BeforeJavaScriptsRenderingEvent.rst.txt
