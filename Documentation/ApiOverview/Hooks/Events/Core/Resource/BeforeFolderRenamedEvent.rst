.. include:: ../../../../../Includes.txt


.. _BeforeFolderRenamedEvent:


========================
BeforeFolderRenamedEvent
========================

This event is fired before a folder is about to be renamed.
Listeners can be used to modify a folder name before it is actually moved or to ensure consistency
or specific rules when renaming folders.

API
---


 - :Method:
         getFolder()
   :Description:
         Returns the folder about to be renamed.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         getTargetName()
   :Description:
         Returns the renamed name.
   :ReturnType:
         string

