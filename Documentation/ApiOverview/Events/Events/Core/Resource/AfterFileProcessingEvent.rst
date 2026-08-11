..  include:: /Includes.rst.txt
..  index:: Events; AfterFileProcessingEvent
..  _AfterFileProcessingEvent:

==========================
`AfterFileProcessingEvent`
==========================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileProcessingEvent`
is fired after a file object has been processed.
This allows to further customize a file object's processed file.

..  _after-file-processing-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _after-file-processing-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileProcessingEvent.rst.txt
