.. include:: ../../../../../../Includes.txt


.. _BeforeResourceStorageInitializationEvent:


========================================
BeforeResourceStorageInitializationEvent
========================================

This event is fired before a resource object is actually built/created.
*Example*: A database record can be enriched to add dynamic values to each resource (file/folder) before
creation of a storage.

API
---


 - :Method:
         getStorageUid()
   :Description:
         Returns the Uid of the current file storage.
   :ReturnType:
         int


 - :Method:
         setStorageUid(int $storageUid)
   :Description:
         Set / Overwrite the storage uid (basically moving the file to a different storage).
   :ReturnType:
         void


 - :Method:
         getRecord()
   :Description:
         Returns the current file record.
   :ReturnType:
         array


 - :Method:
         setRecord(array $record)
   :Description:
         Overwrite / set the current record.
   :ReturnType:
         void


 - :Method:
         getFileIdentifier()
   :Description:
         Returns the current file identifier if one is available.
   :ReturnType:
         ?string

 - :Method:
         setFileIdentifier(?string $fileIdentifier)
   :Description:
         Set or remove ("set to `null`") the current file identifier.
   :ReturnType:
         void