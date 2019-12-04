.. include:: ../../../../Includes.txt


.. _AfterHistoryRollbackFinishedEvent:


=================================
AfterHistoryRollbackFinishedEvent
=================================

This event is fired after a history record rollback finished.

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
         Get fields to be rolled back.
   :ReturnType:
         string
  

 - :Method:
         getDiff()
   :Description:
         Get the diff between the rollback data and the current version.
   :ReturnType:
         array
  

 - :Method:
         getDataHandlerInput()
   :Description:
         Get the data array that was handed to the datahandler for rollback.
   :ReturnType:
         array
  

 - :Method:
         getBackendUserAuthentication()
   :Description:
         Get the current BE User Authentication object.
   :ReturnType:
         \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
  
