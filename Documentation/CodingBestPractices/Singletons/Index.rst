.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Singletons
^^^^^^^^^^

TYPO3 supports singleton patterns for classes. Singletons are
instantiated only once per HTTP request regardless of the number of
calls to :code:`t3lib\_div::makeInstance()`. To use singleton pattern,
a class must implement the :code:`t3lib\_Singleton interface`::

   require_once(PATH_t3lib . 'interfaces/interface.t3lib_singleton.php');

   class tx_myext_mySingletonClass implements t3lib_Singleton {
       …
   }

This interface has no methods to implement.

