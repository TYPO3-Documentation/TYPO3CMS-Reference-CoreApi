.. include:: /Includes.rst.txt
.. index:: Events; BeforeFileProcessingEvent
.. _BeforeFileProcessingEvent:


=========================
BeforeFileProcessingEvent
=========================

This event is fired before a file object is processed.
Allows to add further information or enrich the file before the processing is kicking in.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getProcessedFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\ProcessedFile`
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

