.. include:: /Includes.rst.txt


.. _AfterHistoryRollbackFinishedEvent:


=================================
AfterHistoryRollbackFinishedEvent
=================================

This event is fired after a history record rollback finished.

API
---

.. rst-class:: dl-parameters

getRecordHistoryRollback()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Backend\History\RecordHistoryRollback`
   :sep:`|`

   Returns the RecordHistoryRollback object of the current operation.

getRollbackFields()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   Get fields to be rolled back.

getDiff()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   Get the diff between the rollback data and the current version.

getDataHandlerInput()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   Get the data array that was handed to the datahandler for rollback.

getBackendUserAuthentication()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Authentication\BackendUserAuthentication`
   :sep:`|`

   Get the current BE User Authentication object.
