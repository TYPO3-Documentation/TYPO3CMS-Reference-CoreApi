.. include:: ../../../../../Includes.txt


.. _AfterFileProcessingEvent:


=========================
AfterFileProcessingEvent
=========================

This event is fired after a file object has been processed.
This allows to further customize a file object's processed file.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getProcessedFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\ProcessedFile`
   :sep:`|`

   |nbsp|

setProcessedFile(\TYPO3\CMS\Core\Resource\ProcessedFile $processedFile)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getDriver()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Driver\DriverInterface`
   :sep:`|`

   |nbsp|

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

getTaskType()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getConfiguration()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

