..  include:: /Includes.rst.txt
..  index:: Events; AfterFileMetaDataCreatedEvent
..  _AfterFileMetaDataCreatedEvent:

===============================
`AfterFileMetaDataCreatedEvent`
===============================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileMetaDataCreatedEvent`
is fired once metadata of a file was added to the database,
so it can be enriched with more information.

..  _after-file-meta-data-created-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _after-file-meta-data-created-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileMetaDataCreatedEvent.rst.txt
