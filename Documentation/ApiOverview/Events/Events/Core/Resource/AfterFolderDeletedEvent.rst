..  include:: /Includes.rst.txt
..  index:: Events; AfterFolderDeletedEvent
..  _AfterFolderDeletedEvent:

=======================
AfterFolderDeletedEvent
=======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\AfterFolderDeletedEvent`
is fired after a folder was deleted. Custom listeners can then further clean up
permissions or third-party processed files with this event.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFolderDeletedEvent.rst.txt
