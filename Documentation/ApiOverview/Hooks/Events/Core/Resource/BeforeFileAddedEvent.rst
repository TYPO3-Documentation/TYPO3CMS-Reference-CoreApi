.. include:: ../../../../../Includes.txt


.. _BeforeFileAddedEvent:


====================
BeforeFileAddedEvent
====================

This event is fired before a file is about to be added to the Resource Storage / Driver.
This allows to do custom checks to a file or restrict access to a file before the file is added.

API
---


 - :Method:
         getFileName()
   :Description:
         Returns the filename.
   :ReturnType:
         string


 - :Method:
         setFileName(string $fileName)
   :Description:
         Set the file name.
   :ReturnType:
         void


 - :Method:
         getSourceFilePath()
   :Description:
         Returns the file path from where the current file should be added.
   :ReturnType:
         string


 - :Method:
         getTargetFolder()
   :Description:
         Returns the target folder where the file should be stored.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder


 - :Method:
         getStorage()
   :Description:
         Returns the current file storage.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\ResourceStorage


 - :Method:
         getDriver()
   :Description:
         Returns the current FAL driver.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Driver\DriverInterface
