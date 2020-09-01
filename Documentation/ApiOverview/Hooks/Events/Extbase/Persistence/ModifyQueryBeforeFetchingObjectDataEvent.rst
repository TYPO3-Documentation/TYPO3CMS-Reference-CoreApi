.. include:: ../../../../../Includes.txt

.. _ModifyQueryBeforeFetchingObjectDataEvent:

========================================
ModifyQueryBeforeFetchingObjectDataEvent
========================================

:php:`TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectDataEvent`

Event which is fired before the storage backend is asked for results from a given query.

API
===

 - :Method:
         getQuery()
   :Description:
         Get query.
   :ReturnType:
         TYPO3\CMS\Extbase\Persistence\QueryInterface


 - :Method:
         setQuery()
   :Description:
         Set query.
   :ReturnType:
          void


