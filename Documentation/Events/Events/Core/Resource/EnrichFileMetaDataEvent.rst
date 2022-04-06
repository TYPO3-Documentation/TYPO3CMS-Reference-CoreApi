.. include:: /Includes.rst.txt


.. _EnrichFileMetaDataEvent:


=======================
EnrichFileMetaDataEvent
=======================

Event that is called after a record has been loaded from database
Allows other places to do extension of metadata at runtime or
for example translation and workspace overlay.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFileUid()
   :sep:`|` :aspect:`ReturnType:` int
   :sep:`|`

   |nbsp|

getMetaDataUid()
   :sep:`|` :aspect:`ReturnType:` int
   :sep:`|`

   |nbsp|

getRecord()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

setRecord()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

