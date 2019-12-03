.. include:: ../../../../../../Includes.txt


.. _BeforeFileAddedEvent:


====================
BeforeFileAddedEvent
====================

This event is fired after a file was added to the Resource Storage / Driver.

Use case: Using listeners for this event allows to e.g. post-check permissions or
specific analysis of files like additional metadata analysis after adding them to TYPO3.

API
---


 - :Method:
         getFile()
   :Description:
         Returns the file object.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\FileInterface


 - :Method:
         getFolder()
   :Description:
         Returns the folder where the file is stored.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\Folder

