.. include:: ../../../../../../Includes.txt


.. _BeforeFolderDeletedEvent:


========================
BeforeFolderDeletedEvent
========================

This event is fired before a folder is about to be deleted.

Listeners can use this event to clean up further external references
to a folder / files in this folder.

API
---


 - :Method:
         getFolder()
   :Description:
         Returns the folder about to be deleted.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder

