..  include:: /Includes.rst.txt
..  index:: Events; BeforeFolderRenamedEvent
..  _BeforeFolderRenamedEvent:

========================
BeforeFolderRenamedEvent
========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFolderRenamedEvent`
is fired before a folder is about to be renamed. Listeners can be used to modify
a folder name before it is actually moved or to ensure consistency or specific
rules when renaming folders.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFolderRenamedEvent.rst.txt
