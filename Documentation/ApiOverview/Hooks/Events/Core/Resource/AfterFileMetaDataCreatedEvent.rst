.. include:: /Includes.rst.txt
.. index:: Events; AfterFileMetaDataCreatedEvent
.. _AfterFileMetaDataCreatedEvent:


=============================
AfterFileMetaDataCreatedEvent
=============================

This event is fired once metadata of a file was added to the database,
so it can be enriched with more information.

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

