.. include:: ../../../../../../Includes.txt


.. _AfterFileUpdatedInIndexEvent:


============================
AfterFileUpdatedInIndexEvent
============================

This event is fired once an index was just updated inside the database (= indexed).
Custom listeners can update further index values when a file was updated.

API
---


 - :Method:
         getFile()
   :Description:
         Returns the file.
   :ReturnType:
         \TYPO3\CMS\Core\Resource\File


 - :Method:
         getRelevantProperties()
   :Description:
         Returns the currently updated property names.
   :ReturnType:
         array


 - :Method:
         getUpdatedFields()
   :Description:
         Returns the currently updated fields and values.
   :ReturnType:
         array
