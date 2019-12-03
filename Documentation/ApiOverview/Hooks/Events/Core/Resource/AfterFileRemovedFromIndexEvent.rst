.. include:: ../../../../../../Includes.txt


.. _AfterFileRemovedFromIndexEvent:


==============================
AfterFileRemovedFromIndexEvent
==============================

This event is fired once a file was just removed in the database (sys_file).
*Example* can be to further handle files and manage them separately outside of TYPO3's index.

API
---


 - :Method:
         getFileUid()
   :Description:
         Returns the uid of the removed file.
   :ReturnType:
         int
