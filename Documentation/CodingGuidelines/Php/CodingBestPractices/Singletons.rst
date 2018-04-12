.. include:: ../../../Includes.txt

.. _cgl-singletons:

Singletons
^^^^^^^^^^

TYPO3 supports the singleton patterns for classes. Singletons are
instantiated only once per request regardless of the number of
calls to :code:`GeneralUtility::makeInstance()`. To use a singleton
pattern, a class must implement the :code:`SingletonInterface`::

   namespace Vendor\MyNamespace;

   class MySingletonClass implements \TYPO3\CMS\Core\SingletonInterface
   {
       …
   }

This interface has no specific methods to implement, but if imlemented
only one instance of the class will be created throught given request.

Be aware that singletons are often considered as "anti pattern" by
code architects and should be used with care - use them only if there
are very good reasons to do so.
