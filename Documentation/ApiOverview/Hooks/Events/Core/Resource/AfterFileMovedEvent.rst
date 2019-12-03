.. include:: ../../../../../../Includes.txt


.. _AfterFileMovedEvent:


===================
AfterFileMovedEvent
===================

This event is fired after a file was moved within a Resource Storage / Driver.
The folder represents the "target folder".

*Examples*: Use this to update custom third party handlers that rely on specific paths.

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
         getOriginalFolder()
   :Description:
         Returns the folder where the file was moved from.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder

