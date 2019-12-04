.. include:: ../../../../../Includes.txt


.. _IsTableExcludedFromReferenceIndexEvent:


======================================
IsTableExcludedFromReferenceIndexEvent
======================================

Event to intercept if a certain table should be excluded from the Reference Index.
There is no need to add tables without a definition in $GLOBALS['TCA'] since
ReferenceIndex only handles those.

API
---


 - :Method:
         getTable()
   :Description:
         Returns the current table to be indexed.
   :ReturnType:
         string


 - :Method:
         markAsExcluded()
   :Description:
         Mark a table as excluded from the reference index.
   :ReturnType:
         void


 - :Method:
         isTableExcluded()
   :Description:
         Returns `true` if table is currently excluded from the reference index.
   :ReturnType:
         bool


 - :Method:
         isPropagationStopped()
   :Description:
         This event is stoppable - the first listener marking a table as excluded will 
         stop propagation.
   :ReturnType:
         bool

