.. include:: ../../../../../Includes.txt


.. _BeforeActionCallEvent:


=====================
BeforeActionCallEvent
=====================

:php:`TYPO3\CMS\Extbase\Event\Mvc\BeforeActionCallEvent`

Event that is triggered before any Extbase Action is called within the ActionController or one
of its subclasses.

API
===

 - :Method:
         getControllerClassName()
   :Description:
         Returns the controller classname that was passed in the constructor.
   :ReturnType:
         string


 - :Method:
         getActionMethodName()
   :Description:
         Returns the method name passed in the constructor.
   :ReturnType:
         string


 - :Method:
         getPreparedArguments()
   :Description:
         Returns the prepared arguments passed in the constructor.
   :ReturnType:
          array


