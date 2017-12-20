.. include:: ../../../Includes.txt



.. _using-fal-examples-file-folder:

Working with Files, Folders and File References
"""""""""""""""""""""""""""""""""""""""""""""""

This chapter provides some examples about interacting
with File, Folder and FileReference objects.


.. _using-fal-examples-file-folder-get-file:

Getting a file
~~~~~~~~~~~~~~

A file can be retrieved using its uid:

.. code-block:: php

   $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
   $file = $resourceFactory->getFileObject(4);

or its combined identifier:

.. code-block:: php

   $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
   $file = $resourceFactory->getFileObjectFromCombinedIdentifier('1:/foo.txt');


.. _using-fal-examples-file-folder-copy-file:

Copying a file
~~~~~~~~~~~~~~

.. code-block:: php

   $storageUid = 17;
   $someFileIdentifier = 'templates/images/banner.jpg';
   $someFolderIdentifier = 'website/images/';

   $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
   $storage = $resourceFactory->getStorageObject($storageUid);

   // $file returns a TYPO3\CMS\Core\Resource\File object
   $file = $storage->getFile($someFileIdentifier);
   // $folder returns a TYPO3\CMS\Core\Resource\Folder object
   $folder = $storage->getFolder($someFolderIdentifier);

   // returns the TYPO3\CMS\Core\Resource\File object of the new, copied file
   $copiedFile = $file->copyTo($folder);


.. _using-fal-examples-file-folder-add-file:

Adding a file
~~~~~~~~~~~~~

This example adds a new file in the root folder of the default
Storage:

.. code-block:: php

   $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
   $storage = $resourceFactory->getDefaultStorage();
   $newFile = $storage->addFile(
         '/tmp/temporary_file_name.foo',
         $storage->getRootLevelFolder(),
         'final_file_name.foo'
   );


.. _using-fal-examples-file-folder-create-reference:

Creating a file reference
~~~~~~~~~~~~~~~~~~~~~~~~~


.. _using-fal-examples-file-folder-create-reference-backend:

In the backend context
''''''''''''''''''''''

In the backend or command-line context, it is possible to create
file references using the normal :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`
processes.

Assuming you have the "uid" of both the File and whatever other item
you want to create a relation to, the following code will create
the "sys\_file\_reference" entry and the relation to the other item
(in this case a "tt\_content" record).

.. code-block:: php

     $resourceFactory = ResourceFactory::getInstance();
     $fileObject = $resourceFactory->getFileObject((int)$file);
     $contentElement = BackendUtility::getRecord(
             'tt_content',
             (int)$element
     );
     // Assemble DataHandler data
     $newId = 'NEW1234';
     $data = array();
     $data['sys_file_reference'][$newId] = array(
             'table_local' => 'sys_file',
             'uid_local' => $fileObject->getUid(),
             'tablenames' => 'tt_content',
             'uid_foreign' => $contentElement['uid'],
             'fieldname' => 'image',
             'pid' => $contentElement['pid']
     );
     $data['tt_content'][$contentElement['uid']] = array(
             'image' => $newId
     );
     // Get an instance of the DataHandler and process the data
     /** @var DataHandler $dataHandler */
     $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
     $dataHandler->start($data, array());
     $dataHandler->process_datamap();
     // Error or success reporting
     if (count($dataHandler->errorLog) === 0) {
         // Handle success
     } else {
         // Handle errors
     }


The above example comes from the "examples" extension
(reference: https://github.com/TYPO3-Documentation/TYPO3CMS-Code-Examples/blob/master/Classes/Controller/ModuleController.php).

For another table than "tt\_content", you need to define
the "pid" explicitly when creating the relation:

.. code-block:: php

   $data['tt_address'][$address['uid']] = array(
       'pid' => $address['pid'],
       'image' => 'NEW1234' // changed automatically
   );


.. _using-fal-examples-file-folder-create-reference-frontend:

In the frontend context
'''''''''''''''''''''''

In a frontend context, the :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`
class cannot be used and there is no specific API to create a File Reference.
You are on your own.

The simplest solution is to simply create a database entry into
table "sys\_file\_reference" by using directly the database connection
class provided by TYPO3 CMS.

A cleaner solution using Extbase requires far more work. An example
can be found here: https://github.com/helhum/upload_example


.. _using-fal-examples-file-folder-get-references:

Getting referenced files
~~~~~~~~~~~~~~~~~~~~~~~~

This snippet shows how to retrieve FAL items that have been attached
to some other element, in this case the "media" field of the "pages"
table:

.. code-block:: php

   $fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
   $fileObjects = $fileRepository->findByRelation('pages', 'media', $uid);


where :code:`$uid` is the id of some page. The return value is an array
of :php:`\TYPO3\CMS\Core\Resource\FileReference` objects.


.. _using-fal-examples-file-folder-list-files:

Listing files in a folder
~~~~~~~~~~~~~~~~~~~~~~~~~

These would be the shortest steps to get the list of files in a given
folder: get the Storage, get a Folder object for some path in that
Storage (path relative to Storage root), finally retrieve the files.

.. code-block:: php

   $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
   $defaultStorage = $resourceFactory->getDefaultStorage();
   $folder = $defaultStorage->getFolder('/some/path/in/storage/');
   $files = $defaultStorage->getFilesInFolder($folder);
