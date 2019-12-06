.. include:: ../../../../../Includes.txt


.. _BeforeFileRenamedEvent:


======================
BeforeFileRenamedEvent
======================

This event is fired before a file is about to be renamed. Custom listeners can further rename the file
according to specific guidelines based on the project.

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

