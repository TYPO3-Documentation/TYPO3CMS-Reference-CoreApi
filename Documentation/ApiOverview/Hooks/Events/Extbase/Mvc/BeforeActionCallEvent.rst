.. include:: /Includes.rst.txt


.. _BeforeActionCallEvent:


=====================
BeforeActionCallEvent
=====================

:php:`TYPO3\CMS\Extbase\Event\Mvc\BeforeActionCallEvent`

Event that is triggered before any Extbase Action is called within the ActionController or one
of its subclasses.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getControllerClassName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getActionMethodName()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   |nbsp|

getPreparedArguments()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

