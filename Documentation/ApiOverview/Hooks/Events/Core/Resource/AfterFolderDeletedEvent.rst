.. include:: ../../../../../Includes.txt


.. _AfterFolderDeletedEvent:


=======================
AfterFolderDeletedEvent
=======================

This event is fired after a folder was deleted. 
Custom listeners can then further clean up permissions or
third-party processed files with this event.

API
---


 - :Method:
         getFolder()
   :Description:
         Returns the folder that was (tried to be) deleted.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         isDeleted()
   :Description:
         Returns whether the folder has been deleted.
   :ReturnType:
         bool

