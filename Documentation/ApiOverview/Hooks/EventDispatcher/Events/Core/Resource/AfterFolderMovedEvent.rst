.. include:: ../../../../../../Includes.txt


.. _AfterFolderMovedEvent:


=====================
AfterFolderMovedEvent
=====================

This event is fired after a folder was moved within the Resource Storage / Driver.
Custom references can be updated via listeners of this event.

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
         getTargetFolder()
   :Description:
         Returns the target folder of the folder to be moved.
   :ReturnType:
         ?\TYPO3\CMS\Core\Resource\Folder

