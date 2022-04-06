.. include:: /Includes.rst.txt


.. _BeforeFileAddedEvent:


====================
BeforeFileAddedEvent
====================

This event is fired before a file is about to be added to the Resource Storage / Driver.
This allows to do custom checks to a file or restrict access to a file before the file is added.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFileName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

setFileName(string $fileName)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getSourceFilePath()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getTargetFolder()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Folder`
   :sep:`|`

   |nbsp|

getStorage()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\ResourceStorage`
   :sep:`|`

   |nbsp|

getDriver()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\Driver\DriverInterface`
   :sep:`|`

   |nbsp|

