.. include:: /Includes.rst.txt


.. _fal-using-fal-examples:
.. _fal-using-fal-examples-resource-factory:

=========================
The ResourceFactory Class
=========================

The :php:`\TYPO3\CMS\Core\Resource\ResourceFactory` is the
workhorse of the File Abstraction Layer from a coding point
of view. It contains a number of utility methods, some of
which are described here, some others which appear in the
other code samples provided in this chapter.


.. _fal-using-fal-examples-resource-factory-default-storage:

Getting the Default Storage
===========================

Of all available Storages, one may be marked as default. This
is the Storage that will be used for any operation whenever
no Storage has been explicitly chosen or defined (for example,
when not using a :ref:`combined identifier <fal-architecture-components-files-folders>`).

.. code-block:: php

   $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
   $storage = $resourceFactory->getDefaultStorage();


.. note::

   This may return :php:`null` if no default Storage exists.


.. _fal-using-fal-examples-resource-factory-getting-storage:

Getting any Storage
===================

The :php:`ResourceFactory` should also be used when retrieving
any Storage. You should not try to instantiate directly a
:php:`\TYPO3\CMS\Core\Resource\StorageRepository` and call
its :php:`findByUid()` method.

.. code-block:: php

   $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
   $storage = $resourceFactory->getStorageObject(3);
