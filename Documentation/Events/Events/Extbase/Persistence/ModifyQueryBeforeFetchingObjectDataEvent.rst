.. include:: /Includes.rst.txt

.. _ModifyQueryBeforeFetchingObjectDataEvent:

========================================
ModifyQueryBeforeFetchingObjectDataEvent
========================================

:php:`TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectDataEvent`

Event which is fired before the storage backend is asked for results from a given query.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getQuery()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Extbase\Persistence\QueryInterface`
   :sep:`|`

   |nbsp|

setQuery()
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

