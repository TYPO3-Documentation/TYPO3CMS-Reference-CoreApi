.. include:: ../../../../Includes.txt



.. _developers-using-fal-examples-file-folder:

Working with Files and Folders
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


Here are some examples of interacting with File, Folder and Storage objects. The following examples work
regardless of the indexing state of the File, as we are working directly on the Storage layer here.

Copying a file:

.. code-block:: php

   $storageUid = 17;
   $someFileIdentifier = 'templates/images/banner.jpg';
   $someFolderIdentifier = 'website/images/';

   /** @var $storageRepository \TYPO3\CMS\Core\Ressource\StorageRepository */
   $storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
       TYPO3\CMS\Core\Resource\StorageRepository::class
   );

   $storage = $storageRepository->findByUid($storageUid);
   // $file returns a TYPO3\CMS\Core\Resource\File object
   $file = $storage->getFile($someFileIdentifier);
   // $folder returns a TYPO3\CMS\Core\Resource\File object
   $folder = $storage->getFolder($someFolderIdentifier);

   // returns the TYPO3\CMS\Core\Resource\File object of the new, copied file
   $file->copyTo($folder);
