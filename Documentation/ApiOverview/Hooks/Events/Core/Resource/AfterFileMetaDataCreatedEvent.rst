.. include:: ../../../../../Includes.txt


.. _AfterFileMetaDataCreatedEvent:


=============================
AfterFileMetaDataCreatedEvent
=============================

This event is fired once metadata of a file was added to the database, 
so it can be enriched with more information.

API
---


 - :Method:
         getFileUid()
   :Description:
         Get the file uid of the current file.
   :ReturnType:
         int


 - :Method:
         getMetaDataUid()
   :Description:
         Get the uid of the currently loaded meta data.
   :ReturnType:
         int


 - :Method:
         getRecord()
   :Description:
         Get the meta data record.
   :ReturnType:
         array


 - :Method:
         setRecord()
   :Description:
         Set / overwrite the meta data record.
   :ReturnType:
         array

