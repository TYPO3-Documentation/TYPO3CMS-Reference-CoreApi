.. Note: A handy online ReST editor is available at: http://rst.ninjs.org/

Architecture Overview
#####################

The TYPO3 file API consists of three layers::

                   ..........................
   Usage Layer     |      FileReference     |
                   ..........................
  Storage Layer    |      File | Folder     |
                   |         Storage        |
                   ..........................
  Driver Layer     |         Driver         |
                   ..........................

This is what the individual layers do:

FileReference
  The FileReference basically represents a usage of a file in a specific location,
  e.g. as an image attached to a tt_content record. A FileReference always references
  a real, underlying File (from the layer below), but can add context-specific
  information such as a caption text of an image when used at a specific location.

  We enable users to supply specific titles, captions etc. to that particular instance of the file.

  In the database, each FileReference is represented by a record in the sys_file_references
  table. The table has a foreign key field field pointing to the sys_file table and other fields
  for the specific properties this file has in this particular usage, such as the caption text or
  overlays for the title and description texts.

.. note::
    Technically, the FileReference implements the same interface as the File itself,
    so you have all the methods and properties of a File available in the FileReference
    as well.

    Additionally, there is a property "originalFile" on the FileReference which
    lets you get information about the underlying file.
    (Example: $FileReference->getOriginalFile()->getName().)

Files and Folders
  The Files and Folders are infrastructure objects representing files and folders on
  a Storage. They are tightly coupled with the Storage, which they use to actually perform
  any actions, which are available as shorthands directly from their objects. For example
  a copying action ($file->copyTo($targetFolder)) is technically not implemented on the File
  object itself but in the Storage, the linchpin of the whole file abstraction layer. Apart from
  the shorthand methods to the action methods of the Storage, the Files and Folders are pretty
  lightweight objects with properties (and according getters and setters) for obtaining information
  about their respective file or folder on the file system such as name or size.

  A File can be indexed, which makes it possible to references the file from any database record in order
  to use it, but also speeds up obtaining cached information such as various metadata (when the
  Media Management extension is installed) or other file properties like size or the filename.

Here are some examples of interacting with File, Folder and Storage objects. The below examples work regardless of the
indexing state of the File, as we are working directly on the Storage layer here.

Copying a file::

    $storageUid = 17;
    $someFileIdentifier = 'templates/images/banner.jpg';
    $someFolderIdentifier = 'website/images/';

    $storage = $storageRepository->getByUid($storageUid);
    $file = $storage->getFile($someFileIdentifier); // returns a t3lib_file_File object
    $folder = $storage->getFolder($someFolderIdentifier); // returns a t3lib_file_File object

    $file->copyTo($folder); // returns the t3lib_file_File object of the new, copied file

or, equivalently::

    $folder->addCopyOfFile($file); // also returns the t3lib_file_File object of the  new, copied file

Storage layer (including File and Folder)
  The **Storage** is the focal point in the story. Even though it doesn't do the actual
  low-level copying of the file (that's up to the Driver), it still does the biggest part of the logic:

More things done by the Storage layer:

* the capabilities check (is the driver capable of writing a file to the target location?)
* the action permission checks (is the user allowed to do copy actions at all?)
* the user mount permission check (do the user's file mount restrictions allow
  reading the target file and writing to the target folder?)
* it is the ONLY object that communicates with the driver
* it logs and throws exceptions for successful and not-successful file operations
  (although some exceptions are also thrown in other layers if necessary, of course)

Here is an example of how to work with the storage.

Example: Listing all files in a folder::

   $storageRepository = t3lib_div::makeInstance('t3lib_file_StorageRepository');
   $availableStorages = $storageRepository->findAll();

   foreach($availableStorages as $storage) {
        $rootFolder = $storage->getRootFolder();
        $subFolders = $rootFolder->getSubFolders();
        foreach($subFolders as $subFolder) {
            $filesInSubFolder = $subFolder->getFiles();
            $foldersInSubFolder = $subFolder->getSubFolders();
            ...
        }
   }

The ``findAll()`` method of the storage repository already takes user permissions into account (FIXME does it currently?).

Driver
______

* The driver does the actual copying of the file. It can rely on the Storage having
  done all the necessary checks before, so it doesn't need to worry about permissions
  etc.
* In the communicating between Storage and Driver, they always deal with File objects,
  not just with paths or identifiers. The only time when identifiers are dealt with
  is when getting the File or Folder objects in the first place. Other than that,
  when the Storage is communicating copy, move, etc. operations to the Driver, they
  talk File objects. (e.g. the function copyFile in the Driver as this function
  signature: copyFile(t3lib_file_File $file, t3lib_file_Folder $targetFolder,
  $overwriteExistingFile = TRUE))

Indexing
________

Files can either be indexed or not.

Precisely speaking, the above layer graph could have been put like this as
well, where we distinguish between files which are indexed and those which
are not necessarily::

    ..........................
    |        FileReference       |
    ..........................
    |      Indexed File      | (Indexed File: File with isIndexed() being true)
    ..........................
    |      File | Folder     | (here: File = any File, indexed or not)
    |         Storage        |
    ..........................
    |         Driver         |
    ..........................

Technically, both indexed and non-indexed files are represented by the same object type
(t3lib_file_File), but the indexing nevertheless is an important property of a file.

The reasons why you can regard it as a separate layer are:

* an indexed file can live without firing up the full Storage layer (in case only data is accessed
  that is availabable from the index record). This is useful for quick access to e.g. all filenames
  in a bunch of indexed files. The process of firing up the Storage layer is needed is done totally
  transparently to the user, so you never need to worry about that.

* it can be regarded as a layer between the Storage and the FileReference because the FileReference is only possible
  with an indexed file underneath it.
