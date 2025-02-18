..  include:: /Includes.rst.txt
..  index:: pair: File abstraction layer; Events
..  _fal-architecture-events:

=============
PSR-14 events
=============

The file abstraction layer (FAL) comes with a series of
:ref:`PSR-14 events <EventDispatcher>` that offer the opportunity to
hook into FAL processes at a variety of points.

They are listed below with some explanation, in particular when
they are sent (if the name is not explicit enough) and what
parameters the corresponding event will receive. They are grouped
by emitting class.

Most events exist in pairs, one being sent **before** a given
operation, the other one **after**.

..  note::
    Unless communicated otherwise, mentions of the :php:`File` class below
    actually refer to the :php:`\TYPO3\CMS\Core\Resource\FileInterface` interface.

    :php:`Folder` objects actually refer to the
    :php:`\TYPO3\CMS\Core\Resource\Folder` class.


..  contents:: **Table of contents:**
    :local:

..  _fal-architecture-events-default-upload-folder-resolver:

:php:`\TYPO3\CMS\Core\Resource\DefaultUploadFolderResolver`
===========================================================

:ref:`AfterDefaultUploadFolderWasResolvedEvent`

    Allows to modify the default upload folder after it has been resolved for
    the current page or user.


..  _fal-architecture-events-preview-processing:

:php:`\TYPO3\CMS\Core\Resource\OnlineMedia\Processing\PreviewProcessing`
========================================================================

:ref:`AfterVideoPreviewFetchedEvent`

    Modifies the preview file of online media previews (like YouTube and Vimeo).


..  _fal-architecture-events-resource-storage:

:php:`\TYPO3\CMS\Core\Resource\ResourceStorage`
===============================================

:ref:`SanitizeFileNameEvent`
    The sanitize file name operation aims to remove characters from
    filenames which are not allowed by the underlying
    :ref:`driver <fal-architecture-components-drivers>`. The event receives the
    filename and the target folder.

:ref:`BeforeFileAddedEvent`
    Receives the target file name, the target folder (as a :php:`Folder`
    instance) and the local file path.

:ref:`AfterFileAddedEvent`
    Receives the :php:`File` instance corresponding to the
    newly stored file and the target folder (as a :php:`Folder` instance).

:ref:`BeforeFileCreatedEvent`
    Receives the file name to be created and
    the target folder (as a :php:`Folder` instance).

:ref:`AfterFileCreatedEvent`
    Receives the name of the newly created file and
    the target folder (as a :php:`Folder` instance).

:ref:`BeforeFileCopiedEvent`
    Receives a :php:`File` instance for the file to be copied and
    the target folder (as a :php:`Folder` instance).

:ref:`AfterFileCopiedEvent`
    Receives a :php:`File` instance for the file that was copied
    (i.e. the original file) and the target folder
    (as a :php:`Folder` instance).

:ref:`BeforeFileMovedEvent`
    Receives a :php:`File` instance for the file to be moved and
    the target folder (as a :php:`Folder` instance).

:ref:`AfterFileMovedEvent`
    Receives a :php:`File` instance for the file that was moved,
    the target folder and the original folder the file was in
    (both as :php:`Folder` instances).

:ref:`BeforeFileDeletedEvent`
    Receives a :php:`File` instance for the file to be deleted.

:ref:`AfterFileDeletedEvent`
    Receives a :php:`File` instance for the file that was deleted.

:ref:`BeforeFileRenamedEvent`
    Receives a :php:`File` instance for the file to be renamed
    and the sanitized new name.

:ref:`AfterFileRenamedEvent`
    Receives a :php:`File` instance for the file that was renamed
    and the sanitized new name.

:ref:`BeforeFileReplacedEvent`
    Receives a :php:`File` instance for the file to be replaced
    and the path to the local file that will replace it.

:ref:`AfterFileReplacedEvent`
    Receives a :php:`File` instance for the file that was replaced
    and the path to the local file that has replaced it.

:ref:`BeforeFileContentsSetEvent`
    Receives a :php:`File` instance
    for the file whose content will be changed and the content itself
    (as a string).

:ref:`AfterFileContentsSetEvent`
    Receives a :php:`File` instance
    for the file whose content was changed and the content itself
    (as a string).

:ref:`BeforeFolderAddedEvent`
    Receives the name of the new folder and a reference to the
    parent folder, if any (as a :php:`Folder` instance).

:ref:`AfterFolderAddedEvent`
    Receives the newly created folder (as a :php:`Folder` instance).

:ref:`BeforeFolderCopiedEvent`
    Receives references to the folder to copy and the parent target folder
    (both as :php:`\TYPO3\CMS\Core\Resource\FolderInterface` instances)
    and the sanitized name for the copy.

:ref:`AfterFolderCopiedEvent`
    Receives references to the original folder and the parent target folder
    (both as :php:`\TYPO3\CMS\Core\Resource\FolderInterface` instances)
    and the identifier of the newly copied folder.

:ref:`BeforeFolderMovedEvent`
    Receives references to the folder to move and the parent target folder
    (both as :php:`Folder` instances) and the sanitized target name.

:ref:`AfterFolderMovedEvent`
    Receives references to the folder to move and the parent target folder
    (both as :php:`Folder` instances), the identifier of the moved folder
    and a reference to the original parent folder (as a :php:`Folder` instance).

:ref:`BeforeFolderDeletedEvent`
    Receives a reference to the folder to delete (as a :php:`Folder` instance).

:ref:`AfterFolderDeletedEvent`
    Receives a reference to the deleted folder (as a :php:`Folder` instance).

:ref:`BeforeFolderRenamedEvent`
    Receives a reference to the folder to be renamed (as a :php:`Folder`
    instance) and the sanitized new name.

:ref:`AfterFolderRenamedEvent`
    Receives a reference to the renamed folder (as a :php:`Folder` instance)
    and the new identifier of the renamed folder.

:ref:`GeneratePublicUrlForResourceEvent`
    This event makes it possible to influence the construction of the public URL
    of a resource. If the event defines the URL, it is kept as is and the rest
    of the URL generation process is ignored.

    It receives a reference to the instance for which the URL should be generated
    (as a :php:`\TYPO3\CMS\Core\Resource\ResourceInterface` instance),
    a boolean flag indicating whether the URL should be relative to the current
    script or absolute and a reference to the public URL (which is null at
    this point, but can be then modified by the event).

..  _fal-architecture-events-storage-repository:

:php:`\TYPO3\CMS\Core\Resource\StorageRepository`
=================================================

:ref:`BeforeResourceStorageInitializationEvent`
    This event is dispatched by the method
    :php:`\TYPO3\CMS\Core\Resource\StorageRepository::getStorageObject()`
    before a :ref:`storage <fal-architecture-components-storage>` object has
    been fetched. The event receives a reference to the storage.

:ref:`AfterResourceStorageInitializationEvent`
    This event is dispatched by the method
    :php:`\TYPO3\CMS\Core\Resource\StorageRepository::getStorageObject()`
    after a :ref:`storage <fal-architecture-components-storage>` object has
    been fetched. The event receives a reference to the storage.


..  _fal-architecture-events-file-index-repository:

:php:`\TYPO3\CMS\Core\Resource\Index\FileIndexRepository`
=========================================================

:ref:`AfterFileAddedToIndexEvent`
    Receives an array containing the information collected about the file
    whose index (i.e. :ref:`sys_file <fal-architecture-database-sys-file>` table
    entry) was just created.

:ref:`AfterFileUpdatedInIndexEvent`
    Receives an array containing the information collected about the file
    whose index (i.e. :ref:`sys_file <fal-architecture-database-sys-file>` table
    entry) was just updated.

:ref:`AfterFileRemovedFromIndexEvent`
    Receives the uid of the file (i.e.
    :ref:`sys_file <fal-architecture-database-sys-file>` table entry) which was
    deleted.

:ref:`AfterFileMarkedAsMissingEvent`
    Receives the uid of the file (i.e.
    :ref:`sys_file <fal-architecture-database-sys-file>` table entry) which was
    marked as missing.


..  _fal-architecture-events-metadata-repository:

:php:`\TYPO3\CMS\Core\Resource\Index\MetaDataRepository`
========================================================

:ref:`EnrichFileMetaDataEvent`
    This event is dispatched after metadata has been retrieved for a given
    file. The event receives the metadata as an :php:`\ArrayObject` instance.

:ref:`AfterFileMetaDataCreatedEvent`
    Receives an array containing the metadata collected about the file
    just after it has been inserted into the
    :ref:`sys_file_metadata <fal-architecture-database-sys-file-metadata>` table.

:ref:`AfterFileMetaDataUpdatedEvent`
    This event is dispatched after metadata for a given file has been
    updated. The event receives the metadata as an array containing all
    metadata fields (and not just the updated ones).

:ref:`AfterFileMetaDataDeletedEvent`
    Receives the uid of the file whose metadata has just been deleted.


..  _fal-architecture-events-file-processing-service:

:php:`\TYPO3\CMS\Core\Resource\Service\FileProcessingService`
=============================================================

:ref:`BeforeFileProcessingEvent`
    This event is dispatched before a file is processed. The event receives
    a reference to the processed file and to the original file (both as
    :php:`File` instances), a string defining the type of task being
    executed and an array containing the configuration for that task.

:ref:`AfterFileProcessingEvent`
    This event is dispatched after a file has been processed. The event receives
    a reference to the processed file and to the original file (both as
    :php:`File` instances), a string defining the type of task being
    executed and an array containing the configuration for that task.

See the :ref:`section about services <fal-architecture-components-services>`
for more information about this class.


..  _fal-architecture-events-extended-file-utility:

:php:`\TYPO3\CMS\Core\Utility\File\ExtendedFileUtility`
=======================================================

:ref:`AfterFileCommandProcessedEvent`
    ..  versionadded:: 11.4

    The event can be used to perform additional tasks for specific file
    commands. For example, trigger a custom indexer after a file has been
    uploaded.
