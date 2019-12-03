.. include:: ../../../../../../Includes.txt


.. _BeforeFileReplacedEvent:


=======================
BeforeFileReplacedEvent
=======================

This event is fired before a file is about to be replaced.
Custom listeners can check for file integrity or analyze the content of the file before it gets added.

API
---


 - :Method:
         getFile()
   :Description:
         Returns the file object.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\FileInterface


 - :Method:
         getLocalFilePath()
   :Description:
         Returns the path to the local file (with which the file object will be replaced).
   :ReturnType:
         string

