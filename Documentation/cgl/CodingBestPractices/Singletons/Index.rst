.. include:: ../../Includes.txt


.. _singletons:

Singletons
^^^^^^^^^^

TYPO3 supports singleton patterns for classes. Singletons are
instantiated only once per HTTP request regardless of the number of
calls to :code:`GeneralUtility::makeInstance()`. To use a singleton
pattern, a class must implement the :code:`SingletonInterface`::

   namespace Vendor\MyNamespace;

   class MySingletonClass implements \TYPO3\CMS\Core\SingletonInterface
   {
       …
   }

This interface has no methods to implement.

