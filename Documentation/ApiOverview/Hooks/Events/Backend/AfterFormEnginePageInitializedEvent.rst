.. include:: ../../../../Includes.txt


.. _AfterFormEnginePageInitializedEvent:


====================================
AfterFormEnginePageInitializedEvent
====================================

Event to listen to after the form engine has been initialized (= all data has been persisted).

API
---


 - :Method:
         getController()
   :Description:
         Returns the EditDocumentController instance used.
   :ReturnType:
         \TYPO3\CMS\Backend\Controller\EditDocumentController


 - :Method:
         getRequest()
   :Description:
         Returns the current request.
   :ReturnType:
         \Psr\Http\Message\ServerRequestInterface


