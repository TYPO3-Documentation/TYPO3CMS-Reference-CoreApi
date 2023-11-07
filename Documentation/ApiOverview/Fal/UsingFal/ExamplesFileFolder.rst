..  include:: /Includes.rst.txt

..  _fal-using-fal-examples-file-folder:

===============================================
Working with files, folders and file references
===============================================

This chapter provides some examples about interacting with
:ref:`file, folder <fal-architecture-components-files-folders>` and
:ref:`file reference <fal-architecture-components-file-references>` objects.

..  contents::
    :local:


..  _fal-using-fal-examples-file-folder-get-file:

Getting a file
==============


By uid
------

A file can be retrieved using its uid:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Resource\ResourceFactory;

    $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
    $file = $resourceFactory->getFileObject(4);


By its combined identifier
--------------------------

..  code-block:: php

    $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
    $file = $resourceFactory->getFileObjectFromCombinedIdentifier('1:/foo.txt');

The syntax of argument 1 for :php:`getFileObjectFromCombinedIdentifier()` is

..  code-block:: none

    [[storage uid]:]<file identifier>

The return value is

..  code-block:: none

    File|ProcessedFile|null

The storage uid is optional. If it is not specified, the default storage "0"
will be assumed initially. The default storage is virtual with :php:`$uid === 0`
in its class :php:`\TYPO3\CMS\Core\Resource\ResourceStorage`. In this case the
local filesystem is checked for the given file. The file identifier is the local
path and filename relative to the TYPO3 :file:`fileadmin/` folder.

Example: :file:`/some_folder/some_image.png`, if the file
:file:`/absolute/path/to/fileadmin/some_folder/some_image.png` exists on the
file system.

The file can be accessed from the default storage, if it exists under the given
local path in :file:`fileadmin/`. In case the file is not found, a search for
another storage best fitting to this local path will be started. Afterwards, the
file identifier is adapted accordingly inside of TYPO3 to match the new
storage's base path.


By filename from its folder
---------------------------

..  code-block:: php

    $storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
    $defaultStorage = $storageRepository->getDefaultStorage();
    $folder = $defaultStorage->getFolder('/some/path/in/storage/');
    $file = $folder->getStorage()->getFileInFolder("example.ext", $folder);


By its filename from the folder object
--------------------------------------

..  code-block:: php

    $file = $folder->getFile("filename.ext");


.. _fal-using-fal-examples-file-folder-copy-file:

Copying a file
==============

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Resource\StorageRepository;

    $storageUid = 17;
    $someFileIdentifier = 'templates/images/banner.jpg';
    $someFolderIdentifier = 'website/images/';

    $storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
    $storage = $storageRepository->getStorageObject($storageUid);

    // $file returns a TYPO3\CMS\Core\Resource\File object
    $file = $storage->getFile($someFileIdentifier);
    // $folder returns a TYPO3\CMS\Core\Resource\Folder object
    $folder = $storage->getFolder($someFolderIdentifier);

    // returns the TYPO3\CMS\Core\Resource\File object of the new, copied file
    $copiedFile = $file->copyTo($folder);


..  _fal-using-fal-examples-file-folder-delete-file:


Deleting a file
===============

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    $file->delete();


..  _fal-using-fal-examples-file-folder-add-file:

Adding a file
=============

This example adds a new file in the root folder of the default
storage:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Resource\StorageRepository;

    $storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
    $storage = $storageRepository->getDefaultStorage();
    $newFile = $storage->addFile(
        '/tmp/temporary_file_name.ext',
        $storage->getRootLevelFolder(),
        'final_file_name.ext'
    );


The default storage uses :file:`fileadmin/` unless this was configured
differently, as explained in :ref:`fal-concepts-storages-drivers`.

So, for this example, the resulting file path would typically be
:file:`<document-root>/fileadmin/final_file_name.ext`

To store the file in a sub-folder use :php:`$storage->getFolder()`:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    $newFile = $storage->addFile(
        '/tmp/temporary_file_name.ext',
        $storage->getFolder('some/nested/folder'),
        'final_file_name.ext'
    );


In this example, the file path would likely be
:file:`<document-root>/fileadmin/some/nested/folder/final_file_name.ext`


..  _fal-using-fal-examples-file-folder-create-reference:

Creating a file reference
=========================

..  _fal-using-fal-examples-file-folder-create-reference-backend:

In backend context
------------------

In the backend or :ref:`command line <symfony-console-commands>` context, it is
possible to create file references using the :ref:`DataHandler <datahandler-basics>`
(:php:`\TYPO3\CMS\Core\DataHandling\DataHandler`).

Assuming you have the "uid" of both the :php:`File` and whatever other item
you want to create a relation to, the following code will create
the :ref:`sys_file_reference <fal-architecture-database-sys-file-reference>`
entry and the relation to the other item (in this case a :sql:`tt_content`
record):

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Resource\ResourceFactory;
    use TYPO3\CMS\Backend\Utility\BackendUtility;
    use TYPO3\CMS\Core\DataHandling\DataHandler;

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
           'assets' => $newId // For multiple new references $newId is a comma-separated list
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
(reference: https://github.com/TYPO3-Documentation/t3docs-examples/blob/master/Classes/Controller/ModuleController.php).

Here, the :php:`'fieldname'` :php:`'assets'` is used instead of
:php:`image`. Content elements of ctype 'textmedia' use the field 'assets'.

For another table than :sql:`tt_content`, you need to define
the "pid" explicitly when creating the relation:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    $data['tt_address'][$address['uid']] = [
        'pid' => $address['pid'],
        'image' => 'NEW1234' // changed automatically
    ];


..  _fal-using-fal-examples-file-folder-create-reference-frontend:

In frontend context
-------------------

In a frontend context, the :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`
class cannot be used and there is no specific API to create a file reference.
You are on your own.

The simplest solution is to create a database entry into table
:ref:`sys_file_reference <fal-architecture-database-sys-file-reference>` by
using the :ref:`database connection <database-connection>` class or the
:ref:`query builder <database-query-builder>` provided by TYPO3.

A cleaner solution using :ref:`Extbase <extbase>` requires far more work. An
example can be found here: https://github.com/helhum/upload_example


..  _fal-using-fal-examples-file-folder-get-references:

Getting referenced files
========================

This snippet shows how to retrieve FAL items that have been attached
to some other element, in this case the :sql:`media` field of the :sql:`pages`
table:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Resource\FileRepository;

    $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
    $fileObjects = $fileRepository->findByRelation('pages', 'media', $uid);


where :php:`$uid` is the ID of some page. The return value is an array
of :php:`\TYPO3\CMS\Core\Resource\FileReference` objects.


..  _fal-using-fal-examples-file-folder-list-files:

Listing files in a folder
=========================

These would be the shortest steps to get the list of files in a given
folder: :ref:`get the storage <fal-using-fal-examples-storage-repository>`, get
a folder object for some path in that storage (path relative to storage root),
finally retrieve the files:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Resource\StorageRepository;

    $storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
    $defaultStorage = $storageRepository->getDefaultStorage();
    $folder = $defaultStorage->getFolder('/some/path/in/storage/');
    $files = $defaultStorage->getFilesInFolder($folder);

Dumping a file via eID script
=============================

TYPO3 registers an `eID` script that allows dumping / downloading / referencing
files via their FAL IDs. Non-public storages use this script to make their files
available to view or download. File retrieval is done via PHP and delivered
through the `eID` script.

An example URL looks like this:
:code:`index.php?eID=dumpFile&t=f&f=1230&token=135b17c52f5e718b7cc94e44186eb432e0cc6d2f`.

Following URI parameters are available:

*   :code:`t` (*Type*): Can be one of :code:`f` (`sys_file`),
    :code:`r` (`sys_file_reference`) or :code:`p` (`sys_file_processedfile`)
*   :code:`f` (*File*): UID of table :sql:`sys_file`
*   :code:`r` (*Reference*): UID of table :sql:`sys_file_reference`
*   :code:`p` (*Processed*): UID of table :sql:`sys_file_processedfile`
*   :code:`s` (*Size*): Size (width and height) of the file
*   :code:`cv` (*CropVariant*): In case of :sql:`sys_file_reference`, you can
    assign a cropping variant

You have to choose one of these parameters: :code:`f`, :code:`r` or :code:`p`.
It is not possible to combine them in one request.

The parameter :code:`s` has following syntax: `width:height:minW:minH:maxW:maxH`.
You can leave this parameter empty to load the file in its original size.
The parameters :code:`width` and :code:`height` can feature the trailing
:code:`c` or :code:`m` indicator, as known from TypoScript.

The PHP class responsible for handling the file dumping is the
:php:`FileDumpController`, which you may also use in your code.

See the following example on how to create a URI using the
:php:`FileDumpController` for a :sql:`sys_file` record with a fixed image size:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    $queryParameterArray = ['eID' => 'dumpFile', 't' => 'f'];
    $queryParameterArray['f'] = $resourceObject->getUid();
    $queryParameterArray['s'] = '320c:280c';
    $queryParameterArray['token'] = GeneralUtility::hmac(implode('|', $queryParameterArray), 'resourceStorageDumpFile');
    $publicUrl = GeneralUtility::locationHeaderUrl(PathUtility::getAbsoluteWebPath(Environment::getPublicPath() . '/index.php'));
    $publicUrl .= '?' . http_build_query($queryParameterArray, '', '&', PHP_QUERY_RFC3986);


In this example, the crop variant :php:`default` and an image size of 320x280
will be applied to a :sql:`sys_file_reference` record:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    $queryParameterArray = ['eID' => 'dumpFile', 't' => 'r'];
    $queryParameterArray['f'] = $resourceObject->getUid();
    $queryParameterArray['s'] = '320c:280c:320:280:320:280';
    $queryParameterArray['cv'] = 'default';
    $queryParameterArray['token'] = GeneralUtility::hmac(implode('|', $queryParameterArray), 'resourceStorageDumpFile');
    $publicUrl = GeneralUtility::locationHeaderUrl(PathUtility::getAbsoluteWebPath(Environment::getPublicPath() . '/index.php'));
    $publicUrl .= '?' . http_build_query($queryParameterArray, '', '&', PHP_QUERY_RFC3986);


This example shows how to create a URI to load an image of
`sys_file_processedfile`:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    $queryParameterArray = ['eID' => 'dumpFile', 't' => 'p'];
    $queryParameterArray['p'] = $resourceObject->getUid();
    $queryParameterArray['token'] = GeneralUtility::hmac(implode('|', $queryParameterArray), 'resourceStorageDumpFile');
    $publicUrl = GeneralUtility::locationHeaderUrl(PathUtility::getAbsoluteWebPath(Environment::getPublicPath() . '/index.php'));
    $publicUrl .= '?' . http_build_query($queryParameterArray, '', '&', PHP_QUERY_RFC3986);


The following restrictions apply:

*   You cannot assign any size parameter to processed files, as they are already
    resized.
*   You cannot apply crop variants to :sql:`sys_file` and
    :sql:`sys_file_processedfile` records, only to :sql:`sys_file_reference`
