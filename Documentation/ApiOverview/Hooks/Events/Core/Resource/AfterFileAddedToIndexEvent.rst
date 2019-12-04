.. include:: ../../../../../Includes.txt


.. _AfterFileAddedToIndexEvent:


==========================
AfterFileAddedToIndexEvent
==========================

This event is fired once an index was just added to the database (= indexed).
 
*Examples:* 

Allows to additionally populate custom fields of the sys_file/sys_file_metadata database records.

API
---


 - :Method:
         getFileUid()
   :Description:
         Returns the file uid of the indexed file.
   :ReturnType:
         int


 - :Method:
         getRecord()
   :Description:
         Returns the current file record.
   :ReturnType:
         array

