..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileProcessingEvent
..  _BeforeFileProcessingEvent:

=========================
BeforeFileProcessingEvent
=========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileProcessingEvent`
is fired before a file object is processed. This allows to add further
information or enrich the file before the processing is kicking in.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileProcessingEvent.rst.txt
