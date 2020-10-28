.. include:: ../../../../../Includes.txt


.. _AfterRequestDispatchedEvent:


===========================
AfterRequestDispatchedEvent
===========================

:php:`TYPO3\CMS\Extbase\Event\Mvc\AfterRequestDispatchedEvent`

Event which is fired after the dispatcher has successfully dispatched a request to a controller/action.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getRequest()
   :sep:`|` :aspect:`ReturnType:` \Psr\Http\Message\ServerRequestInterface
   :sep:`|`

   |nbsp|

getResponse()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Extbase\Mvc\ResponseInterface`
   :sep:`|`

   |nbsp|

