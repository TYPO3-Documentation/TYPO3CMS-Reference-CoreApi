.. include:: ../../../../../Includes.txt


.. _BeforeFileDeletedEvent:


======================
BeforeFileDeletedEvent
======================

This event is fired before a file is about to be deleted.

Event listeners can clean up third-party references with this event.

API
---


 - :Method:
         getFile()
   :Description:
         Returns the file object.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\FileInterface

