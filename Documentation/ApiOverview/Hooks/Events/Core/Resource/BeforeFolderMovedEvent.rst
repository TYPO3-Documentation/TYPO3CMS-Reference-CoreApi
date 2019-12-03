.. include:: ../../../../../../Includes.txt


.. _BeforeFolderMovedEvent:


======================
BeforeFolderMovedEvent
======================

This event is fired before a folder is about to be moved to the Resource Storage / Driver.
Listeners can be used to modify a folder name before it is actually moved or to ensure consistency
or specific rules when moving folders.

API
---


 - :Method:
         getFolder()
   :Description:
         Returns the folder to be moved.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         getTargetParentFolder()
   :Description:
         Returns the folder where the moved folder will be stored.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         getTargetFolderName()
   :Description:
         Returns the new folder name of the folder to be moved.
   :ReturnType:
         string

