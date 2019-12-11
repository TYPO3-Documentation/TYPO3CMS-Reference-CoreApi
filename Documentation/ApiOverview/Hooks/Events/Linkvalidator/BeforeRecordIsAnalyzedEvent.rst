.. include:: ../../../../Includes.txt


.. _BeforeRecordIsAnalyzedEvent:


===========================
BeforeRecordIsAnalyzedEvent
===========================

Event that is fired to modify results (= add results) or modify the record before the linkanalyzer analyzes
the record.

API
---


 - :Method:
         getTableName()
   :Description:
         Returns the table name of the currently analyzed record.
   :ReturnType:
         string


 - :Method:
         getRecord()
   :Description:
         Returns the current record array.
   :ReturnType:
         array


 - :Method:
         setRecord(array $record)
   :Description:
         Set / Overwrite the current record.
   :ReturnType:
         void


 - :Method:
         getFields()
   :Description:
         Returns the current fields.
   :ReturnType:
         array


 - :Method:
         getResults()
   :Description:
         Returns the results of the current analysis.
   :ReturnType:
         array


 - :Method:
         setResults(array $results)
   :Description:
         Set results of current analysis.
   :ReturnType:
         void


 - :Method:
         getLinkAnalyzer()
   :Description:
         Returns the current link analyzer instance
   :ReturnType:
         \TYPO3\CMS\Linkvalidator\LinkAnalyzer

