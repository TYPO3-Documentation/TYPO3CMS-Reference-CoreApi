.. include:: ../../../../../Includes.txt


.. _BeforeFolderCopiedEvent:


=======================
BeforeFolderCopiedEvent
=======================

This event is fired before a folder is about to be copied to the Resource Storage / Driver.
Listeners could add deferred processing / queuing of large folders.

API
---


 - :Method:
         getFolder()
   :Description:
         Returns the folder about to be copied.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         getTargetParentFolder()
   :Description:
         Returns the parent folder to be copied to.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         getTargetFolderName()
   :Description:
         Returns the name of the target folder.
   :ReturnType:
         string

