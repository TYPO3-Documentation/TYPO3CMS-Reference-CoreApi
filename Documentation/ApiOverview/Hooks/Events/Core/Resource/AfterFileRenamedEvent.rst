.. include:: ../../../../../../Includes.txt


.. _AfterFileRenamedEvent:


=====================
AfterFileRenamedEvent
=====================

This event is fired after a file was renamed in order to further process a file or filename
or update custom references to a file.

API
---


 - :Method:
         getFile()
   :Description:
         Returns the file object.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\FileInterface


 - :Method:
         getTargetFileName()
   :Description:
         Returns the new file name of the file to be moved.
   :ReturnType:
         string

