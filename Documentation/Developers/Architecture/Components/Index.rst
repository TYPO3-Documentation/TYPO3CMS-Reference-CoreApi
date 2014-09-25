.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


.. _architecture-components:

Components
""""""""""

FAL consists of a number of components that interact with each other.
Each component has a clear role in the architecture, something that is
explained in detail in this section.

When using the components in your own services, always keep the basic
principles that we laid out earlier in mind -- e.g. do not call
services from the storage/driver part.


.. _architecture-file-system:

The (virtual) file system
~~~~~~~~~~~~~~~~~~~~~~~~~

TODO: explain file system, storage/drivers, references ...


.. _architecture-files-folders:

Files and Folders
~~~~~~~~~~~~~~~~~

The Files and Folders are facades representing files and folders. They are tightly coupled
with the Storage, which they use to actually perform any actions. For example
a copying action (``$file->copyTo($targetFolder)``) is technically not implemented by the File
object itself but in the storage and driver, the linchpin of the whole file abstraction layer. Apart from
the shorthand methods to the action methods of the Storage, the Files and Folders are pretty
lightweight objects with properties (and according getters and setters) for obtaining information
about their respective file or folder on the file system such as name or size.

A File can be indexed, which makes it possible to reference the file from any database record in order
to use it, but also speeds up obtaining cached information such as various metadata (when the
Media Management extension is installed) or other file properties like size or the filename.

Here are some examples of interacting with File, Folder and Storage objects. The following examples work
regardless of the indexing state of the File, as we are working directly on the Storage layer here.

Copying a file:

.. code-block:: php

   $storageUid = 17;
   $someFileIdentifier = 'templates/images/banner.jpg';
   $someFolderIdentifier = 'website/images/';

   /** @var $storageRepository \TYPO3\CMS\Core\Ressources\StorageRepository */
   $storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
       'TYPO3\\CMS\\Core\\Resource\\StorageRepository'
   );

   $storage = $storageRepository->findByUid($storageUid);
   // $file returns a TYPO3\CMS\Core\Resource\File object
   $file = $storage->getFile($someFileIdentifier);
   // $folder returns a TYPO3\CMS\Core\Resource\File object
   $folder = $storage->getFolder($someFolderIdentifier);

   // returns the TYPO3\CMS\Core\Resource\File object of the new, copied file
   $file->copyTo($folder);


.. _architecture-file-references:

File references
```````````````

The FileReference basically represents a usage of a file in a specific location,
e.g. as an image attached to a tt_content record. A FileReference always references
a real, underlying File (from the layer below), but can add context-specific
information such as a caption text of an image when used at a specific location.


.. _architecture-storage:

Storage
~~~~~~~

The Storage is the focal point in the story. Even though it doesn't do the actual
low-level actions on a file (that's up to the Driver), it still does the biggest part of the logic:

More things done by the Storage layer:

* the capabilities check (is the driver capable of writing a file to the target location?)
* the action permission checks (is the user allowed to do copy actions at all?)
* the user mount permission check (do the user's file mount restrictions allow
  reading the target file and writing to the target folder?)
* it is the ONLY object that communicates with the driver
* it logs and throws exceptions for successful and not-successful file operations
  (although some exceptions are also thrown in other layers if necessary, of course)

Example: *Listing all files in a folder*

.. code-block:: php

  /** @var $storageRepository \TYPO3\CMS\Core\Ressources\StorageRepository */
  $storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      'TYPO3\\CMS\\Core\\Resource\\StorageRepository'
  );
  $availableStorages = $storageRepository->findAll();

  foreach ($availableStorages as $storage) {
      $rootFolder = $storage->getRootFolder();
      $subFolders = $rootFolder->getSubFolders();
      foreach ($subFolders as $subFolder) {
          $filesInSubFolder = $subFolder->getFiles();
          $foldersInSubFolder = $subFolder->getSubFolders();
          ...
      }
  }

The ``findAll()`` method of the storage repository already takes user
permissions into account (FIXME does it currently?).


.. _architecture-drivers:

The drivers
~~~~~~~~~~~

The driver does the actual copying of the file. It can rely on the Storage having
done all the necessary checks before, so it doesn't need to worry about permissions
etc.

In the communication between Storage and Driver, the Storage hands File/Folder
objects to the Driver where appropriate. The Driver will usually respond with an object,
but could also return identifiers for certain operations, e.g. when copying a file
or after moving some files. Apart from that, identifiers are also used for querying the
driver for a File or Folder in the first place. Other than that,
when the Storage is invoking copy, move, etc. operations on the Driver, it passes File
objects (e.g. ``copyFile()`` in the Driver has this method signature:
``copyFile(TYPO3\CMS\Core\Resource\File $file, TYPO3\CMS\Core\Resource\Folder $targetFolder, [...])``).


.. _architecture-file-index:

The file index
~~~~~~~~~~~~~~

Indexing a file creates a database record for the file, containing meta-information both
*about* the file (file-system properties) and *from* the file (e.g. EXIF information for
images). Collecting file-system data is done by the driver, while all additional properties
have to be fetched by additional services.

This distinction is important because it makes clear that FAL does in fact two things:
It manages files in terms of *assets* we use in our Content Management System. In that regard,
files are not different from any other content, like texts. On the other hand, it also manages
files in terms of a *representation* of such an asset. While the former thing only uses the
contents, the latter heavily depends on the file itself and thus is considered low-level,
driver-dependent stuff.

Managing the *asset* properties of a file (related to its contents) is not done by the
Storage/Driver combination, but by services that build on these low-level parts.

Technically, both indexed and non-indexed files are represented by the same object type
(``TYPO3\CMS\Core\Resource\File``), but being indexing nevertheless is an important property of a file. An
object of an indexed file could theoretically [1]_ even live without its storage as long as it is
only about querying the object for file properties, as all these properties reside in the
database and are read from there when constructing the object.

The reasons why you can regard it as a separate layer are:

* An indexed file can live without firing up the full Storage layer (in case only data is accessed
  that is available from the index record). This is useful for quick access to e.g. all filenames
  in a bunch of indexed files. The process of firing up the Storage layer is done totally
  transparently to the user. So you never need to worry about that.

* It can be regarded as a layer between the Storage and the FileReference, because the
  FileReference is only possible with an indexed file underneath it.

.. [1] When retrieving a file through the FAL API, the Storage is currently always used.
       So there is no file without its Storage. The File object also relies on this. So
       it will require some future changes to get this working without Storage.
