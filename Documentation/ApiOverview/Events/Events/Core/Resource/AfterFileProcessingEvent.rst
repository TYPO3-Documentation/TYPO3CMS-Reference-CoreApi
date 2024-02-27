..  include:: /Includes.rst.txt
..  index:: Events; AfterFileProcessingEvent
..  _AfterFileProcessingEvent:

========================
AfterFileProcessingEvent
========================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileProcessingEvent`
is fired after a file object has been processed.
This allows to further customize a file object's processed file.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileProcessingEvent.rst.txt
