.. include:: ../../../../../Includes.txt


.. _AfterFileCopiedEvent:


====================
AfterFileCopiedEvent
====================

This event is fired after a file was copied within a Resource Storage / Driver.
The folder represents the "target folder".

*Example*: Listeners can sign up for listing duplicates using this event.

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

