.. include:: /Includes.rst.txt
.. index:: Events; ModifyResultAfterFetchingObjectDataEvent
.. _ModifyResultAfterFetchingObjectDataEvent:

========================================
ModifyResultAfterFetchingObjectDataEvent
========================================

Event which is fired after the storage backend has pulled results from a given query.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getQuery()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Extbase\Persistence\QueryInterface`
   :sep:`|`

   |nbsp|

getResult()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

setResults()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|` :aspect:`Argument:` `$result`: Array of results

   Overwrites result array.


