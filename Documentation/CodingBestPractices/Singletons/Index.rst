.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _singletons:

Singletons
^^^^^^^^^^

TYPO3 supports singleton patterns for classes. Singletons are
instantiated only once per HTTP request regardless of the number of
calls to :code:`GeneralUtility::makeInstance()`. To use a singleton
pattern, a class must implement the :code:`SingletonInterface`::

   require_once(PATH_typo3 . 'sysext/core/Classes/SingletonInterface.php');

   class tx_myext_mySingletonClass implements SingletonInterface {
       …
   }

This interface has no methods to implement.

