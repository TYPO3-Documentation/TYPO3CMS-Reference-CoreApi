.. include:: ../../../../../Includes.txt


.. _SanitizeFileNameEvent:


=====================
SanitizeFileNameEvent
=====================

This event is fired once an index was just added to the database (= indexed), so it is possible
to modify the file name, and name the files according to naming conventions of a specific project.

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
         Set the (sanitized / modified) file name.
   :ReturnType:
         void


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
