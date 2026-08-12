..  include:: /Includes.rst.txt
..  index:: Events; AppendLinkHandlerElementsEvent
..  _AppendLinkHandlerElementsEvent:

================================
`AppendLinkHandlerElementsEvent`
================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\DataHandling\Event\AppendLinkHandlerElementsEvent`
is fired so listeners can intercept and add elements when checking
links within the :ref:`soft reference <soft-references>` parser.

..  _append-link-handler-elements-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _append-link-handler-elements-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/AppendLinkHandlerElementsEvent.rst.txt
