.. include:: ../../../../../Includes.txt


.. _EnrichFileMetaDataEvent:


=======================
EnrichFileMetaDataEvent
=======================

Event that is called after a record has been loaded from database
Allows other places to do extension of metadata at runtime or
for example translation and workspace overlay.

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
         Set / overwrite the meta data record at runtime.
   :ReturnType:
         array

