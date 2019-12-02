.. include:: ../../../../../../Includes.txt


.. _BeforeFileProcessingEvent:


=========================
BeforeFileProcessingEvent
=========================

This event is fired before a file object is processed.
Allows to add further information or enrich the file before the processing is kicking in.

API
---


 - :Method:
         getProcessedFile()
   :Description:
         Returns the processed file object.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\ProcessedFile


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