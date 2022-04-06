.. include:: /Includes.rst.txt


.. _AfterFileAddedToIndexEvent:


==========================
AfterFileAddedToIndexEvent
==========================

This event is fired once an index was just added to the database (= indexed).

*Examples:*

Allows to additionally populate custom fields of the sys_file/sys_file_metadata database records.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFileUid()
   :sep:`|` :aspect:`ReturnType:` int
   :sep:`|`

   |nbsp|

getRecord()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

