.. include:: /Includes.rst.txt
.. index:: File abstraction layer; Components
.. _fal-architecture-components:

==========
Components
==========

FAL consists of a number of components that interact with each other.
Each component has a clear role in the architecture, which is
detailed in this section.


.. index::
   pair: File abstraction layer; Files
   pair: File abstraction layer; Folders
.. _fal-architecture-components-files-folders:

Files and folders
=================

The files and folders are facades representing files and folders
or whatever equivalent there is in the system the Driver is connecting to
(it could be categories from Digital Asset Management tool, for example).
They are tightly coupled with the storage, which they use to actually
perform any actions. For example a copying action (:php:`$file->copyTo($targetFolder)`)
is technically not implemented by the :php:`\TYPO3\CMS\Core\Resource\File`
object itself but in the storage and Driver.

Apart from the shorthand methods to the action methods of the storage,
the files and folders are pretty lightweight objects with properties
(and related getters and setters) for obtaining information
about their respective file or folder on the file system, such as name or size.

A file can be indexed, which makes it possible to reference the file
from any database record in order to use it, but also speeds up obtaining
cached information such as various metadata or other file properties like size or file name.

A file may be referenced by its uid in the :ref:`sys_file table <fal-architecture-database-sys-file>`, but will
also often be referred to by its identifier, which is the path to the
file from the root of the storage the file belongs to. The
**combined identifier** includes the file's identifier prepended
by the storage's uid and a colon (:code:`:`). Example:
:code:`1:/path/to/file/filename.foo`.


.. index:: File abstraction layer; File reference
.. _fal-architecture-components-file-references:

File references
===============

A :php:`\TYPO3\CMS\Core\Resource\FileReference` basically
represents a usage of a File in a specific location,
e.g. as an image attached to a content element ("tt_content") record.
A FileReference always references a real, underlying File,
but can add context-specific information such as a caption text for an image
when used at a specific location.

In the database, each FileReference is represented by a record in the
:ref:`sys_file_reference table <fal-architecture-database-sys-file-reference>`.

Creating a reference to a file requires the file to be indexed first,
as the reference is done through the normal record relation handling of TYPO3 CMS.

.. note::

   Technically, the :php:`\TYPO3\CMS\Core\Resource\FileReference` implements
   the same interface as the :php:`\TYPO3\CMS\Core\Resource\File` itself.
   So you have all the methods and properties of a file available in the FileReference
   as well. This makes it possible to use both files and references to them.

   Additionally, there is a property "originalFile" on the FileReference which
   lets you get information about the underlying file (e.g.
   :code:`$fileReference->getOriginalFile()->getName()`).


.. index:: File abstraction layer; Storage
.. _fal-architecture-components-storage:

Storage
=======

The storage is the focal point of the FAL architecture. Even though it doesn't do the actual
low-level actions on a file (that's up to the driver), it still does the largest part of the logic.

Among the many things done by the storage layer are:

- the capabilities check (is the driver capable of writing a file to the target location?)
- the action permission checks (is the user allowed to do file actions at all?)
- the user mount permission check (do the user's file mount restrictions allow
  reading the target file and writing to the target folder?)
- communication with the Driver (it is the ONLY object that does so)
- logging and throwing of exceptions for successful and unsuccessful file operations
  (although some exceptions are also thrown in other layers if necessary, of course)

The storage essentially works with :php:`\TYPO3\CMS\Core\Resource\File`
and :php:`\TYPO3\CMS\Core\Resource\Folder` objects.


.. index:: File abstraction layer; Drivers
.. _fal-architecture-components-drivers:

Drivers
=======

The driver does the actual actions on a file (e.g. moving, copying, etc.).
It can rely on the storage having done all the necessary checks before,
so it doesn't need to worry about permissions and other rights.

In the communication between storage and Driver, the storage hands over identifiers
to the Driver where appropriate. For example, the :php:`copyFileWithinStorage()`
method of the Driver API has the following method signature:

.. code-block:: php

    /**
     * Copies a file *within* the current storage.
     * Note that this is only about an inner storage copy action,
     * where a file is just copied to another folder in the same storage.
     *
     * @param string $fileIdentifier
     * @param string $targetFolderIdentifier
     * @param string $fileName
     * @return string the Identifier of the new file
     */
    public function copyFileWithinStorage($fileIdentifier, $targetFolderIdentifier, $fileName);


.. index:: File abstraction layer; File index
.. _fal-architecture-components-file-index:

The file index
==============

Indexing a file creates a database record for the file, containing meta-information both
*about* the file (file-system properties) and *from* the file (e.g. EXIF information for
images). Collecting file-system data is done by the Driver, while all additional properties
have to be fetched by additional services.

This distinction is important because it makes clear that FAL does in fact two things:
It manages files in terms of *assets* we use in our Content Management System. In that regard,
files are not different from any other content, like texts. On the other hand, it also manages
files in terms of a *representation* of such an asset. While the former thing only uses the
contents, the latter heavily depends on the file itself and thus is considered low-level,
driver-dependent stuff.

Managing the *asset* properties of a file (related to its contents) is not done by the
storage/Driver combination, but by services that build on these low-level parts.

Technically, both indexed and non-indexed files are represented by the same object type
(:php:`\TYPO3\CMS\Core\Resource\File`), but being indexed is nevertheless an important
step for a file.

.. note::

   An object of an indexed file could theoretically even live without
   its storage as long as it is only about querying the object for file properties,
   as all these properties reside in the database and are read from there when constructing
   the object. This is currently not the case, as Files are always retrieved
   via storages.


.. index:: pair: File abstraction layer; Collections
.. _fal-architecture-components-collections:

Collections
===========

Collections are groups of files defined in various ways. They can be picked up
individually, by the selection of a folder or by the selection of one or
more categories. Collections can be used by content elements or plugins
for various needs.

The TYPO3 CMS Core makes usage of collections for the "File Links"
content object type.


.. index::
   Services
   pair: File abstraction layer; Services
   Services; FileProcessingService
   Services; MagicImageService
   Services; UserFileInlineLabelService
   Services; UserFileMountService
.. _fal-architecture-components-services:

Services
========

The File abstraction layer also comes with a number of services:

:php:`\TYPO3\CMS\Core\Resource\Service\FileProcessingService`
  This service processes files to generate previews or scaled/cropped images.
  These two functions are known as task types and are identified by class
  constants.

  The task which generates preview images is used in most places in the backend
  where thumbnails are called for. It is identified by constant
  :php:`\TYPO3\CMS\Core\Resource\ProcessedFile::CONTEXT_IMAGEPREVIEW`.

  The other task is about cropping and scaling an image, typically for frontend
  output. It is dentified by constant :php:`\TYPO3\CMS\Core\Resource\ProcessedFile::CONTEXT_IMAGECROPSCALEMASK`).

  The configuration for :php:`\TYPO3\CMS\Core\Resource\ProcessedFile::CONTEXT_IMAGECROPSCALEMASK`
  is the one used for the :ref:`imgResource function <t3tsref:imgresource>`,
  but only taking the crop, scale and mask settings into account.

:php:`\TYPO3\CMS\Core\Resource\Service\MagicImageService`
  This service creates resized ("magic") images as can be used in the
  Rich-Text Editor, for example.

:php:`\TYPO3\CMS\Core\Resource\Service\UserFileInlineLabelService`
  This service is called to generate the label of a "sys\_file\_reference"
  entry, i.e. what will appear in the header of an IRRE element.

:php:`\TYPO3\CMS\Core\Resource\Service\UserFileMountService`
  This service provides a single public method which builds a list of
  folders (and subfolders, recursively) inside any given storage. It is
  used when defining File Mounts.
