..  include:: /Includes.rst.txt
..  index:: Events; AfterFolderRenamedEvent
..  _AfterFolderRenamedEvent:

=======================
AfterFolderRenamedEvent
=======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\AfterFolderRenamedEvent`
is fired after a folder was renamed.

*Example*: Add custom processing of folders or adjust permissions.

This event is also used by TYPO3 itself to synchronize folder relations in
records (for example in the table :sql:`sys_filemounts`) after renaming of
folders.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFolderRenamedEvent.rst.txt
