.. include:: ../../../../Includes.txt


.. _BeforeHistoryRollbackStartEvent:


===============================
BeforeHistoryRollbackStartEvent
===============================

This event is fired before a history record rollback starts.

API
---


 - :Method:
         getRecordHistoryRollback()
   :Description:
         Returns the RecordHistoryRollback object of the current operation.
   :ReturnType:
         \TYPO3\CMS\Backend\History\RecordHistoryRollback
  

 - :Method:
         getRollbackFields()
   :Description:
         Returs list of fields to be rolled back.
   :ReturnType:
         string
  

 - :Method:
         getDiff()
   :Description:
         Returns the diff between the rollback data and the current version.
   :ReturnType:
         array
  

 - :Method:
         getBackendUserAuthentication()
   :Description:
         Get the current BE User Authentication object.
   :ReturnType:
         \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
  
