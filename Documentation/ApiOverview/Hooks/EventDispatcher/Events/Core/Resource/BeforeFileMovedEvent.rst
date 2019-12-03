.. include:: ../../../../../../Includes.txt


.. _BeforeFileMovedEvent:


====================
BeforeFileMovedEvent
====================

This event is fired before a file is about to be moved within a Resource Storage / Driver.
The folder represents the "target folder".

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


 - :Method:
         getTargetFileName()
   :Description:
         Returns the new file name of the file to be moved.
   :ReturnType:
         string

