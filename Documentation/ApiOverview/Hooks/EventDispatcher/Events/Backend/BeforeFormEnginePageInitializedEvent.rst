.. include:: ../../../../../Includes.txt


.. _BeforeFormEnginePageInitializedEvent:


====================================
BeforeFormEnginePageInitializedEvent
====================================

Event to listen to before the form engine has been initialized (= before all data will be persisted).

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


