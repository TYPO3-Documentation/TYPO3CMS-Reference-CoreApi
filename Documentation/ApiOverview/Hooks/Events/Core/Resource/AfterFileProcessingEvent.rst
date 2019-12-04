.. include:: ../../../../../Includes.txt


.. _AfterFileProcessingEvent:


=========================
AfterFileProcessingEvent
=========================

This event is fired after a file object has been processed.
This allows to further customize a file object's processed file.

API
---


 - :Method:
         getProcessedFile()
   :Description:
         Returns the processed file object.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\ProcessedFile

 - :Method:
         setProcessedFile(\TYPO3\CMS\Core\Resource\ProcessedFile $processedFile)
   :Description:
         Allows overwriting / manipulating the currently processed file.
   :ReturnType:
         void


 - :Method:
         getDriver()
   :Description:
         Returns the currently used driver.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Driver\DriverInterface


 - :Method:
         getFile()
   :Description:
         Returns the file object.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\FileInterface


 - :Method:
         getTaskType()
   :Description:
         Returns the current task type (see Constants in `ProcessedFile`).
   :ReturnType:
         string


 - :Method:
         getConfiguration()
   :Description:
         Returns the processing configuration.
   :ReturnType:
         array