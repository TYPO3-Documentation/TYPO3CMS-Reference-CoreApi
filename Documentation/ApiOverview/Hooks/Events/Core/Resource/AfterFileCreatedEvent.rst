.. include:: ../../../../../../Includes.txt


.. _AfterFileCreatedEvent:


=====================
AfterFileCreatedEvent
=====================

This event is fired before a file was created within a Resource Storage / Driver.
The folder represents the "target folder".

*Example*: This allows to modify a file or check for an appropriate signature after a file was created in TYPO3.

API
---


 - :Method:
         getFileName()
   :Description:
         Returns the filename.
   :ReturnType:
         string


 - :Method:
         getFolder()
   :Description:
         Returns the folder where the file should be created.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder

