.. include:: /Includes.rst.txt


.. _BeforeFileReplacedEvent:


=======================
BeforeFileReplacedEvent
=======================

This event is fired before a file is about to be replaced.
Custom listeners can check for file integrity or analyze the content of the file before it gets added.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\FileInterface`
   :sep:`|`

   |nbsp|

getLocalFilePath()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

