.. include:: ../../../../../../Includes.txt


.. _AfterResourceStorageInitializationEvent:


=======================================
AfterResourceStorageInitializationEvent
=======================================

This event is fired after a resource object was built/created.
Custom handlers can be initialized at this moment for any kind of resource as well.

API
---


 - :Method:
         getStorage()
   :Description:
         Returns the current file storage.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\ResourceStorage


 - :Method:
         setStorage(ResourceStorage $storage)
   :Description:
         Set / Overwrite the storage.
   :ReturnType:
         void
