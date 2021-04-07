.. include:: /Includes.rst.txt



.. _fal-using-fal-examples-file-folder:

===============================================
Working With Files, Folders and File References
===============================================

This chapter provides some examples about interacting
with File, Folder and FileReference objects.


.. _fal-using-fal-examples-file-folder-get-file:

Getting a File
==============

A file can be retrieved using its uid::

   $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
   $file = $resourceFactory->getFileObject(4);

or its combined identifier::

   $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
   $file = $resourceFactory->getFileObjectFromCombinedIdentifier('1:/foo.txt');

The syntax of argument 1 for getFileObjectFromCombinedIdentifier is

.. code-block:: none

   [[storage uid]:]<file identifier>

The return value is

.. code-block:: none

   File|ProcessedFile|null

The storage uid is optional. If it is not specified, the default storage 0 will be assumed initially.
The default storage is virtual with :php:`$uid === 0` in its class :php:`\TYPO3\CMS\Core\Resource\ResourceStorage`. In this case the local filesystem is checked for the given file.
The file identifier is the local path and filename relative to the TYPO3 :file:`fileadmin/` folder.
Example: `/templates/stylesheets/fonts.css`, if the file `/absolute/path/to/fileadmin/templates/stylesheets/fonts.css` exists on the file system.

The file can be accessed from the default storage, if it exists under the given local path in :file:`fileadmin/`.
In case the file is not found, a search for another storage best fitting to this local path will be started. Afterwards the file identifier is adapted accordingly inside of TYPO3 to match the new storage's base path.


.. _fal-using-fal-examples-file-folder-copy-file:

Copying a File
==============

.. code-block:: php

   $storageUid = 17;
   $someFileIdentifier = 'templates/images/banner.jpg';
   $someFolderIdentifier = 'website/images/';

   $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
   $storage = $resourceFactory->getStorageObject($storageUid);

   // $file returns a TYPO3\CMS\Core\Resource\File object
   $file = $storage->getFile($someFileIdentifier);
   // $folder returns a TYPO3\CMS\Core\Resource\Folder object
   $folder = $storage->getFolder($someFolderIdentifier);

   // returns the TYPO3\CMS\Core\Resource\File object of the new, copied file
   $copiedFile = $file->copyTo($folder);


.. _fal-using-fal-examples-file-folder-add-file:

Adding a File
=============

This example adds a new file in the root folder of the default
Storage::

   $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
   $storage = $resourceFactory->getDefaultStorage();
   $newFile = $storage->addFile(
         '/tmp/temporary_file_name.ext',
         $storage->getRootLevelFolder(),
         'final_file_name.ext'
   );


The default storage uses :file:`fileadmin` unless this was configured
differently, as explained in :ref:`fal-concepts-storages-drivers`.

So, for this example, the resulting file path would typically be
:file:`<document-root>/fileadmin/final_file_name.ext`

To store the file in a sub folder use :php:`$storage->getFolder()`::

   $newFile = $storage->addFile(
         '/tmp/temporary_file_name.ext',
         $storage->getFolder('some/nested/folder'),
         'final_file_name.ext'
   );


In this example, the file path would likely be
:file:`<document-root>/fileadmin/some/nested/folder/final_file_name.ext`


.. _fal-using-fal-examples-file-folder-create-reference:

Creating a File Reference
=========================


.. _fal-using-fal-examples-file-folder-create-reference-backend:

In the Backend Context
----------------------

In the backend or command-line context, it is possible to create
file references using the :ref:`DataHandler <datahandler-basics>`
processes (:php:`\TYPO3\CMS\Core\DataHandling\DataHandler`).

Assuming you have the "uid" of both the File and whatever other item
you want to create a relation to, the following code will create
the "sys\_file\_reference" entry and the relation to the other item
(in this case a "tt\_content" record)::

     $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
     $fileObject = $resourceFactory->getFileObject((int)$file);
     $contentElement = BackendUtility::getRecord(
             'tt_content',
             (int)$element
     );
     // Assemble DataHandler data
     $newId = 'NEW1234';
     $data = [];
     $data['sys_file_reference'][$newId] = [
             'table_local' => 'sys_file',
             'uid_local' => $fileObject->getUid(),
             'tablenames' => 'tt_content',
             'uid_foreign' => $contentElement['uid'],
             'fieldname' => 'assets',
             'pid' => $contentElement['pid']
     ];
     $data['tt_content'][$contentElement['uid']] = [
             'assets' => $newId
     ];
     // Get an instance of the DataHandler and process the data
     /** @var DataHandler $dataHandler */
     $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
     $dataHandler->start($data, []);
     $dataHandler->process_datamap();
     // Error or success reporting
     if (count($dataHandler->errorLog) === 0) {
         // Handle success
     } else {
         // Handle errors
     }


The above example comes from the "examples" extension
(reference: https://github.com/TYPO3-Documentation/TYPO3CMS-Code-Examples/blob/master/Classes/Controller/ModuleController.php).

Here, the :php:`'fieldname'` :php:`'assets'` is used instead of
:php:`image`. Content elements of ctype 'textmedia' use the field 'assets'.

For another table than "tt\_content", you need to define
the "pid" explicitly when creating the relation::

   $data['tt_address'][$address['uid']] = [
       'pid' => $address['pid'],
       'image' => 'NEW1234' // changed automatically
   ];


.. _fal-using-fal-examples-file-folder-create-reference-frontend:

In the Frontend Context
-----------------------

In a frontend context, the :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`
class cannot be used and there is no specific API to create a File Reference.
You are on your own.

The simplest solution is to create a database entry into
table "sys\_file\_reference" by using the database connection
class provided by TYPO3 CMS.

A cleaner solution using Extbase requires far more work. An example
can be found here: https://github.com/helhum/upload_example


.. _fal-using-fal-examples-file-folder-get-references:

Getting Referenced Files
========================

This snippet shows how to retrieve FAL items that have been attached
to some other element, in this case the "media" field of the "pages"
table::

   $fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
   $fileObjects = $fileRepository->findByRelation('pages', 'media', $uid);


where :php:`$uid` is the id of some page. The return value is an array
of :php:`\TYPO3\CMS\Core\Resource\FileReference` objects.


.. _fal-using-fal-examples-file-folder-list-files:

Listing Files in a Folder
=========================

These would be the shortest steps to get the list of files in a given
folder: get the storage, get a folder object for some path in that
storage (path relative to storage root), finally retrieve the files::

   $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
   $defaultStorage = $resourceFactory->getDefaultStorage();
   $folder = $defaultStorage->getFolder('/some/path/in/storage/');
   $files = $defaultStorage->getFilesInFolder($folder);

Dumping a file via eID Script
=============================

TYPO3 registers an `eID` script that allows dumping / downloading / referencing files via their FAL ids. Non-public storages use this script
to make their files available to view or download. File retrieval is done via PHP and delivered through the `eID` script.

An example URL looks like this: :code:`index.php?eID=dumpFile&t=f&f=1230&token=135b17c52f5e718b7cc94e44186eb432e0cc6d2f`.

Following URI-Parameters are available:

+ :php:`t` (*Type*): Can be one of :php:`f` (`sys_file`), :php:`r` (`sys_file_reference`) or :php:`p` (`sys_file_processedfile`)
+ :php:`f` (*File*): UID of table :sql:`sys_file`
+ :php:`r` (*Reference*): UID of table :sql:`sys_file_reference`
+ :php:`p` (*Processed*): UID of table :sql:`sys_file_processedfile`
+ :php:`s` (*Size*): Size (width and height) of the file
+ :php:`cv` (*CropVariant*): In case of :sql:`sys_file_reference`, you can assign a cropping variant

You have to choose one of these parameters: :php:`f`, :php:`r` or :php:`p`. It is not possible
to combine them in one request.

The Parameter :php:`s` has following syntax: `width:height:minW:minH:maxW:maxH`. You
can leave this parameter empty to load the file in its original size. Parameter :php:`width`
and :php:`height` can feature the trailing :ts:`c` or :ts:`m` indicator, as known from TypoScript.

The PHP class responsible for handling the file dumping is the :php:`FileDumpController`, which you
may also use in your code.

See the following example on how to create a URI using the :php:`FileDumpController` for
a :sql:`sys_file` record with a fixed image size::

   $queryParameterArray = ['eID' => 'dumpFile', 't' => 'f'];
   $queryParameterArray['f'] = $resourceObject->getUid();
   $queryParameterArray['s'] = '320c:280c';
   $queryParameterArray['token'] = GeneralUtility::hmac(implode('|', $queryParameterArray), 'resourceStorageDumpFile');
   $publicUrl = GeneralUtility::locationHeaderUrl(PathUtility::getAbsoluteWebPath(Environment::getPublicPath() . '/index.php'));
   $publicUrl .= '?' . http_build_query($queryParameterArray, '', '&', PHP_QUERY_RFC3986);


In this example crop variant :php:`default` and an image size of 320:280 will be
applied to a sys_file_reference record::

   $queryParameterArray = ['eID' => 'dumpFile', 't' => 'r'];
   $queryParameterArray['f'] = $resourceObject->getUid();
   $queryParameterArray['s'] = '320c:280c:320:280:320:280';
   $queryParameterArray['cv'] = 'default';
   $queryParameterArray['token'] = GeneralUtility::hmac(implode('|', $queryParameterArray), 'resourceStorageDumpFile');
   $publicUrl = GeneralUtility::locationHeaderUrl(PathUtility::getAbsoluteWebPath(Environment::getPublicPath() . '/index.php'));
   $publicUrl .= '?' . http_build_query($queryParameterArray, '', '&', PHP_QUERY_RFC3986);


This example shows how to create a URI to load an image of
`sys_file_processedfile`::

   $queryParameterArray = ['eID' => 'dumpFile', 't' => 'p'];
   $queryParameterArray['p'] = $resourceObject->getUid();
   $queryParameterArray['token'] = GeneralUtility::hmac(implode('|', $queryParameterArray), 'resourceStorageDumpFile');
   $publicUrl = GeneralUtility::locationHeaderUrl(PathUtility::getAbsoluteWebPath(Environment::getPublicPath() . '/index.php'));
   $publicUrl .= '?' . http_build_query($queryParameterArray, '', '&', PHP_QUERY_RFC3986);


The following restrictions apply:

+ You can't assign any size parameter to processed files, as they are already resized.
+ You can't apply CropVariants to :sql:`sys_file` and :sql:`sys_file_processedfile` records, only to :sql:`sys_file_reference`
