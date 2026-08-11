..  include:: /Includes.rst.txt
..  index:: Events; BeforeResourceStorageInitializationEvent
..  _BeforeResourceStorageInitializationEvent:

==========================================
`BeforeResourceStorageInitializationEvent`
==========================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\BeforeResourceStorageInitializationEvent`
is fired before a resource object is actually built/created.

*Example*: A database record can be enriched to add dynamic values to each
resource (file/folder) before the creation of a
:ref:`storage <fal-architecture-components-storage>`.

..  _before-resource-storage-initialization-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-resource-storage-initialization-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeResourceStorageInitializationEvent.rst.txt
