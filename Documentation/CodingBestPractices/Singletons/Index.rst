

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Singletons
^^^^^^^^^^

TYPO3 supports singleton pattern for classes. Singletons are
instantiated only once per HTTP request regardless of the number of
calls to the t3lib\_div::makeInstance(). To use singleton pattern
class must implement t3lib\_Singletoninterface:

::

   require_once(PATH_t3lib . 'interfaces/interface.t3lib_singleton.php');
   
   class tx_myext_mySingletonClass implements t3lib_Singleton {
           …
   }

This interface has no methods to implement.

