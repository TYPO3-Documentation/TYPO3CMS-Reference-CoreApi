.. include:: /Includes.rst.txt


.. _fal-using-fal-examples:
.. _fal-using-fal-examples-storage-repository:

===========================
The StorageRepository Class
===========================

The :php:`\TYPO3\CMS\Core\Resource\StorageRepository` is the
main class for creating and retrieving file storage objects.
It contains a number of utility methods, some of
which are described here, some others which appear in the
other code samples provided in this chapter.


.. _fal-using-fal-examples-storage-repository-default-storage:

Getting the Default Storage
===========================

Of all available storages, one may be marked as default. This
is the storage that will be used for any operation whenever
no storage has been explicitly chosen or defined (for example,
when not using a :ref:`combined identifier <fal-architecture-components-files-folders>`).

.. code-block:: php

   /**
    * @var \TYPO3\CMS\Core\Resource\StorageRepository
    */
   private $storageRepository;

   public function __construct(StorageRepository $storageRepository)
   {
      $this->storageRepository = $storageRepository;
   }

   public function example(): void
   {
      $defaultStorage = $this->storageRepository->getDefaultStorage();
   }


.. note::

   This may return :php:`null` if no default Storage exists.


.. _fal-using-fal-examples-storage-repository-getting-storage:

Getting any storage
===================

The :php:`StorageRepository` should be used when retrieving
any storage.

.. code-block:: php

   /**
     * @var \TYPO3\CMS\Core\Resource\StorageRepository
     */
   private $storageRepository;

   public function __construct(StorageRepository $storageRepository)
    {
       $this->storageRepository = $storageRepository;
   }


   public function example(): void
   {
       $storage = $this->storageRepository->getStorageObject(3);
   }
