..  include:: /Includes.rst.txt
..  index:: Events; BeforeFolderDeletedEvent
..  _BeforeFolderDeletedEvent:

==========================
`BeforeFolderDeletedEvent`
==========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFolderDeletedEvent`
is fired before a folder is about to be deleted.

Listeners can use this event to clean up further external references
to a folder / files in this folder.

..  _before-folder-deleted-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-folder-deleted-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFolderDeletedEvent.rst.txt
