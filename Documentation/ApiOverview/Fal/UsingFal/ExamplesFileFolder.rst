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

..  _fal-using-fal-examples-file-folder-get-file-uid:

By uid
------

A file can be retrieved using its uid:

..  literalinclude:: _ExamplesFileFolder/_GetFileByUid.php
    :caption: EXT:my_extension/Classes/MyClass.php


..  _fal-using-fal-examples-file-folder-get-file-combined-identifier:

By its combined identifier
--------------------------

..  literalinclude:: _ExamplesFileFolder/_GetFileByCombinedIdentifier.php
    :caption: EXT:my_extension/Classes/MyClass.php

The syntax of argument 1 for :php:`getFileObjectFromCombinedIdentifier()` is:

..  code-block:: none

    [[storage uid]:]<file identifier>

The storage uid is optional. Without it, TYPO3 treats the identifier as a path
relative to the web root, or as an absolute path. It looks for the local
storage whose base path matches the longest part of this path, and takes the
rest as the file identifier in that storage. For example,
`fileadmin/some_folder/some_image.png` becomes
`/some_folder/some_image.png` in the storage of :path:`fileadmin/`.

If the path is outside all storages, the method throws a
:php-short:`\TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException`.
It also throws it for the storage uid `0`.

..  versionchanged:: 15.0
    :changelog: breaking-110361-1785715200

    Before, an identifier without a storage uid first looked into the virtual
    fallback storage `0`, which covered the whole web root. This storage was
    removed.


..  _fal-using-fal-examples-file-folder-get-file-filename-folder:

By filename from its folder
---------------------------

..  literalinclude:: _ExamplesFileFolder/_GetFileByFilenameFromItsFolder.php
    :caption: EXT:my_extension/Classes/MyClass.php


..  _fal-using-fal-examples-file-folder-get-file-filename-folder-2:

By its filename from the folder object
--------------------------------------

..  literalinclude:: _ExamplesFileFolder/_GetFileByItsFilenameFromTheFolderObject.php
    :caption: EXT:my_extension/Classes/MyClass.php


..  _fal-using-fal-examples-file-folder-copy-file:

Copying a file
==============

..  literalinclude:: _ExamplesFileFolder/_CopyingFile.php
    :caption: EXT:my_extension/Classes/MyClass.php


..  _fal-using-fal-examples-file-folder-delete-file:


Deleting a file
===============

..  literalinclude:: _ExamplesFileFolder/_DeletingFile.php
    :caption: EXT:my_extension/Classes/MyClass.php

..  _fal-using-fal-examples-file-folder-add-file:

Adding a file
=============

This example adds a new file in the root folder of the default
storage:

..  literalinclude:: _ExamplesFileFolder/_AddingFile.php
    :caption: EXT:my_extension/Classes/MyClass.php

The default storage uses :file:`fileadmin/` unless this was configured
differently, as explained in :ref:`Storages and drivers <fal-concepts-storages-drivers>`.

So, for this example, the resulting file path would typically be
:file:`<document-root>/fileadmin/final_file_name.ext`.

To store the file in a sub-folder use :php:`$storage->getFolder()`:

..  literalinclude:: _ExamplesFileFolder/_AddingFileToSubFolder.php
    :caption: EXT:my_extension/Classes/MyClass.php

In this example, the file path would likely be
:file:`<document-root>/fileadmin/some/nested/folder/final_file_name.ext`.

..  _fal-using-fal-examples-file-folder-add-file-security:

Security and consistency checks
-------------------------------

The following methods of :php:`\TYPO3\CMS\Core\Resource\ResourceStorage` perform
validation checks:

*   :php:`addFile()`
*   :php:`renameFile()`
*   :php:`replaceFile()`
*   :php:`addUploadedFile()`

Validation behavior:

*   Only explicitly allowed file extensions are accepted. Valid extensions must be configured in:
    `$GLOBALS['TYPO3_CONF_VARS']['SYS']['textfile_ext']  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-textfile-ext>`_,
    `$GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-mediafile-ext>`_,
    `$GLOBALS['TYPO3_CONF_VARS']['SYS']['miscfile_ext']  <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-sys-miscfile-ext>`_.
*   The file’s MIME type must match the expected file extension. For example,
    a real PNG image with a `.exe` file extension is rejected.
*   The file extension must be allowed by the storage and, for a backend user
    without admin rights, by the file mount, see
    `Restricting the file extensions of a storage <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages-file-extensions>`_.

Feature flags controlling this behavior:

*   :php:`security.system.enforceAllowedFileExtensions`
*   :php:`security.system.enforceFileExtensionMimeTypeConsistency`

For controlled or low-level operations, consistency checks can be bypassed temporarily:

..  literalinclude:: _ImportCommand.php
    :caption: EXT:my_extension/Classes/Command/ImportCommand.php

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

..  literalinclude:: _ExamplesFileFolder/_CreatingFileReference.php
    :caption: EXT:my_extension/Classes/MyClass.php

The above example comes from the "examples" extension
(reference: https://github.com/TYPO3-Documentation/t3docs-examples/blob/main/Classes/Controller/ModuleController.php).

Here, the `'fieldname'` `'assets'` is used instead of
:php:`image`. Content elements of ctype 'textmedia' use the field 'assets'.

For another table than :sql:`tt_content`, you need to define
the "pid" explicitly when creating the relation:

..  code-block:: php
    :caption: EXT:my_extension/Classes/SomeClass.php

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

See :ref:`Extbase file upload <extbase-domain-fileupload>` for details on how
to achieve this using :ref:`Extbase <extbase-extension-framework>`.


..  _fal-using-fal-examples-file-folder-get-references:

Getting referenced files
========================

This snippet shows how to retrieve FAL items that have been attached
to some other element, in this case the :sql:`media` field of the :sql:`pages`
table:

..  literalinclude:: _ExamplesFileFolder/_GetReferencedFile.php
    :caption: EXT:my_extension/Classes/MyClass.php

where :php:`$uid` is the ID of some page. The return value is an array
of :php:`\TYPO3\CMS\Core\Resource\FileReference` objects.

..  seealso::

    See :ref:`Current content object
    <typo3-request-attribute-current-content-object>` about fetching
    the UID of the current `tt_content` object.


..  _fal-using-fal-examples-file-folder-list-files:

Get files in a folder
=====================

These would be the shortest steps to get the list of files in a given
folder: :ref:`get the storage <fal-using-fal-examples-storage-repository>`, get
a folder object for some path in that storage (path relative to storage root),
finally retrieve the files:

..  literalinclude:: _ExamplesFileFolder/_GetFilesInFolder.php
    :caption: EXT:my_extension/Classes/MyClass.php

..  _fal-using-fal-examples-file-folder-eid:

Dumping a file via `eID` script
===============================

TYPO3 registers an `eID` script that allows dumping / downloading / referencing
files via their FAL IDs. Non-public storages use this script to make their files
available to view or download. File retrieval is done via PHP and delivered
through the `eID` script.

An example URL looks like this:
`index.php?eID=dumpFile&t=f&f=1230&token=135b17c52f5e718b7cc94e44186eb432e0cc6d2f`.

Following URI parameters are available:

*   `t` (*Type*): Can be one of `f` (`sys_file`),
    `r` (`sys_file_reference`) or `p` (`sys_file_processedfile`)
*   `f` (*File*): UID of table :sql:`sys_file`
*   `r` (*Reference*): UID of table :sql:`sys_file_reference`
*   `p` (*Processed*): UID of table :sql:`sys_file_processedfile`
*   `s` (*Size*): Size (width and height) of the file
*   `cv` (*CropVariant*): In case of :sql:`sys_file_reference`, you can
    assign a cropping variant

You have to choose one of these parameters: `f`, `r` or `p`.
It is not possible to combine them in one request.

The parameter `s` has following syntax: `width:height:minW:minH:maxW:maxH`.
You can leave this parameter empty to load the file in its original size.
The parameters `width` and `height` can feature the trailing
`c` or `m` indicator, as known from TypoScript.

The PHP class responsible for handling the file dumping is the
:php:`\TYPO3\CMS\Core\Controller\FileDumpController`, which you may also use
in your code.

..  versionchanged:: 14.0
    Until TYPO3 v13 generating the Hash-based Message Authentication Codes (HMACs)
    was done via :php:`GeneralUtility::hmac()`; this has been deprecated with
    TYPO3 v13.1 and removed with TYPO3 v14.0. Use the
    :php:`\TYPO3\CMS\Core\Crypto\HashService::hmac()` method instead.

See the following example on how to create a URI using the
:php:`FileDumpController` for a :sql:`sys_file` record with a fixed image size:

..  literalinclude:: _ExamplesFileFolder/_SomeFileEid1.php
    :caption: EXT:my_extension/Classes/SomeClass.php

In this example, the crop variant :php:`default` and an image size of 320x280
will be applied to a :sql:`sys_file_reference` record:

..  literalinclude:: _ExamplesFileFolder/_SomeFileEid2.php
    :caption: EXT:my_extension/Classes/SomeClass.php

This example shows how to create a URI to load an image of
`sys_file_processedfile`:

..  literalinclude:: _ExamplesFileFolder/_SomeFileEid3.php
    :caption: EXT:my_extension/Classes/SomeClass.php

The following restrictions apply:

*   You cannot assign any size parameter to processed files, as they are already
    resized.
*   You cannot apply crop variants to :sql:`sys_file` and
    :sql:`sys_file_processedfile` records, only to :sql:`sys_file_reference`
