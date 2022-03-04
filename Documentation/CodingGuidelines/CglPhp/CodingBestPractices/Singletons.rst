.. include:: /Includes.rst.txt

.. _cgl-singletons:

==========
Singletons
==========

TYPO3 supports the singleton patterns for classes. Singletons are
instantiated only once per request regardless of the number of
calls to :php:`GeneralUtility::makeInstance()`. To use a singleton
pattern, a class must implement the :php:`SingletonInterface`::

   namespace Vendor\MyNamespace;

   class MySingletonClass implements \TYPO3\CMS\Core\SingletonInterface
   {
       …
   }

This interface has no methods to implement.

Be aware that singletons are often considered as "anti pattern" by
code architects and should be used with care. Use them only if there
are very good reasons.
