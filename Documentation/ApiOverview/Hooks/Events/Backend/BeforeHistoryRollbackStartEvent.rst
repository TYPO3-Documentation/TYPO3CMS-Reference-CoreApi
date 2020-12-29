.. include:: /Includes.rst.txt
.. index:: Events; BeforeHistoryRollbackStartEvent
.. _BeforeHistoryRollbackStartEvent:

===============================
BeforeHistoryRollbackStartEvent
===============================

This event is fired before a history record rollback starts.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getRecordHistoryRollback()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Backend\History\RecordHistoryRollback`
   :sep:`|`

   |nbsp|

getRollbackFields()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getDiff()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

getBackendUserAuthentication()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Core\Authentication\BackendUserAuthentication`
   :sep:`|`

   |nbsp|

