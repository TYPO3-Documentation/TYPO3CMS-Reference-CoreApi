.. include:: ../../../../../../Includes.txt


.. _AfterFileReplacedEvent:


======================
AfterFileReplacedEvent
======================

This event is fired after a file was replaced.

*Example*: Further process a file or create variants, or index the 
contents of a file for AI analysis etc.

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

