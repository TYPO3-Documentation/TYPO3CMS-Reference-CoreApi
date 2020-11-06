.. include:: /Includes.rst.txt


.. _IsTableExcludedFromReferenceIndexEvent:


======================================
IsTableExcludedFromReferenceIndexEvent
======================================

Event to intercept if a certain table should be excluded from the Reference Index.
There is no need to add tables without a definition in $GLOBALS['TCA'] since
ReferenceIndex only handles those.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

getTable()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

markAsExcluded()
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

isTableExcluded()
   :sep:`|` :aspect:`ReturnType:` bool
   :sep:`|`

   |nbsp|

isPropagationStopped()
   :sep:`|` :aspect:`ReturnType:` bool
   :sep:`|`

   This event is stoppable - the first listener marking a table as excluded will
   stop propagation.
