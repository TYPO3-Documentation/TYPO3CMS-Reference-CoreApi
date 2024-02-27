..  include:: /Includes.rst.txt
..  index:: Events; AfterFileUpdatedInIndexEvent
..  _AfterFileUpdatedInIndexEvent:

============================
AfterFileUpdatedInIndexEvent
============================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileUpdatedInIndexEvent`
is fired once an index was just updated inside the database (= indexed).
Custom listeners can update further index values when a file was updated.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileUpdatedInIndexEvent.rst.txt
