.. include:: ../../../../Includes.txt



.. _developers-using-fal-examples-storage:

Working with Storages
~~~~~~~~~~~~~~~~~~~~~


Example: *Listing all files in a folder*

.. code-block:: php

  /** @var $storageRepository \TYPO3\CMS\Core\Ressources\StorageRepository */
  $storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      'TYPO3\\CMS\\Core\\Resource\\StorageRepository'
  );
  $availableStorages = $storageRepository->findAll();

  foreach ($availableStorages as $storage) {
      $rootFolder = $storage->getRootLevelFolder();
      $subFolders = $rootFolder->getSubFolders();
      foreach ($subFolders as $subFolder) {
          $filesInSubFolder = $subFolder->getFiles();
          $foldersInSubFolder = $subFolder->getSubFolders();
          ...
      }
  }

The ``findAll()`` method of the storage repository already takes user
permissions into account (FIXME does it currently?).
