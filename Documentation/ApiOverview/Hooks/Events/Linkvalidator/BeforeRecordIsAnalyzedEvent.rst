.. include:: /Includes.rst.txt


.. _BeforeRecordIsAnalyzedEvent:


===========================
BeforeRecordIsAnalyzedEvent
===========================

Event that is fired to modify results (= add results) or modify the record before the linkanalyzer analyzes
the record.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getTableName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getRecord()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   Returns the current record array.

setRecord(array $record)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getFields()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   Returns the current fields.

getResults()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

setResults(array $results)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   Set results of current analysis.

getLinkAnalyzer()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Linkvalidator\LinkAnalyzer`
   :sep:`|`

   |nbsp|

