.. include:: ../../../../../Includes.txt

.. _ModifyResultAfterFetchingObjectDataEvent:

========================================
ModifyResultAfterFetchingObjectDataEvent
========================================

Event which is fired after the storage backend has pulled results from a given query.

API
===

 - :Method:
         getQuery()
   :Description:
         Returns the query that was executed.
   :ReturnType:
         TYPO3\CMS\Extbase\Persistence\QueryInterface

- :Method:
         getResult()
   :Description:
         Returns the query results.
   :ReturnType:
         array


 - :Method:
         setResults()
   :Arguments:
      - `$result`: Array of results
   :Description:
         Overwrites result array.
   :ReturnType:
          void


