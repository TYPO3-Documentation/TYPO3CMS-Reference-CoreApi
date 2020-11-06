.. include:: /Includes.rst.txt


.. _AfterFormEnginePageInitializedEvent:


====================================
AfterFormEnginePageInitializedEvent
====================================

Event to listen to after the form engine has been initialized (= all data has been persisted).

API
---


.. rst-class:: dl-parameters

getController()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Backend\Controller\EditDocumentController`
   :sep:`|`

   Returns the EditDocumentController instance used.

getRequest()
   :sep:`|` :aspect:`ReturnType:` `\Psr\Http\Message\ServerRequestInterface`
   :sep:`|`

   Returns the current request.
