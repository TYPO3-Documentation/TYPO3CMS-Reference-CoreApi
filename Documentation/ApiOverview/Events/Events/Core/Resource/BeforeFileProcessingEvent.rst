..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileProcessingEvent
..  _BeforeFileProcessingEvent:

===========================
`BeforeFileProcessingEvent`
===========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileProcessingEvent`
is fired before a file object is processed. This allows to add further
information or enrich the file before the processing is kicking in.

..  _before-file-processing-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-file-processing-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Resource\Event\BeforeFileProcessingEvent
