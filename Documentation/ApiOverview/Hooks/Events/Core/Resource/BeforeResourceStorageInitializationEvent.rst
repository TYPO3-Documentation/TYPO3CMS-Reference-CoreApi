.. include:: /Includes.rst.txt
.. index:: Events; BeforeResourceStorageInitializationEvent
.. _BeforeResourceStorageInitializationEvent:


========================================
BeforeResourceStorageInitializationEvent
========================================

This event is fired before a resource object is actually built/created.
*Example*: A database record can be enriched to add dynamic values to each resource (file/folder) before
creation of a storage.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getStorageUid()
   :sep:`|` :aspect:`ReturnType:` int
   :sep:`|`

   |nbsp|

setStorageUid(int $storageUid)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getRecord()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

setRecord(array $record)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getFileIdentifier()
   :sep:`|` :aspect:`ReturnType:` ?string
   :sep:`|`

   |nbsp|

setFileIdentifier(?string $fileIdentifier)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

