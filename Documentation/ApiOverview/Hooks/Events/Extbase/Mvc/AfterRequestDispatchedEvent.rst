.. include:: ../../../../../Includes.txt


.. _AfterRequestDispatchedEvent:


===========================
AfterRequestDispatchedEvent
===========================

:php:`TYPO3\CMS\Extbase\Event\Mvc\AfterRequestDispatchedEvent`

Event which is fired after the dispatcher has successfully dispatched a request to a controller/action.

API
===

 - :Method:
         getRequest()
   :Description:
         Returns the current request.
   :ReturnType:
         \Psr\Http\Message\ServerRequestInterface


 - :Method:
         getResponse()
   :Description:
         Return a response
   :ReturnType:
          \TYPO3\CMS\Extbase\Mvc\ResponseInterface


