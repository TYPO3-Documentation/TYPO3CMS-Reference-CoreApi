.. include:: ../../../../../Includes.txt


.. _AfterFileUpdatedInIndexEvent:


============================
AfterFileUpdatedInIndexEvent
============================

This event is fired once an index was just updated inside the database (= indexed).
Custom listeners can update further index values when a file was updated.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getFile()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Resource\File`
   :sep:`|`

   |nbsp|

getRelevantProperties()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

getUpdatedFields()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

