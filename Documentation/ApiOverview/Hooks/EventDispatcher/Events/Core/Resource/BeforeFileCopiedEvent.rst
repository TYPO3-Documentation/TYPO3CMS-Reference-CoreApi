.. include:: ../../../../../../Includes.txt


.. _BeforeFileCopiedEvent:


=====================
BeforeFileCopiedEvent
=====================

This event is fired before a file is about to be copied within a Resource Storage / Driver.
The folder represents the "target folder".

This allows to further analyze or modify the file or metadata before it is written by the driver.

API
---


 - :Method:
         getFile()
   :Description:
         Returns the file object.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\FileInterface


 - :Method:
         getFolder()
   :Description:
         Returns the folder where the file is stored.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder

