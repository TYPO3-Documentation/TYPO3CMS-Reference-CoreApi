.. include:: ../../../../../Includes.txt


.. _BeforeFileCreatedEvent:


======================
BeforeFileCreatedEvent
======================

This event is fired before a file is about to be created within a Resource Storage / Driver.
The folder represents the "target folder".

This allows to further analyze or modify the file or filename before it is written by the driver.

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

