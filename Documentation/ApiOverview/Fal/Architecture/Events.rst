.. include:: /Includes.rst.txt
.. index:: pair: File abstraction layer; Events
.. _fal-architecture-events:

=============
PSR-14 Events
=============

FAL comes with a series of PSR-14 events that offer the opportunity
to hook into FAL processes at a variety of points.

They are listed below with some explanation, in particular when
they are sent (if the name is not explicit enough) and what
parameters the corresponding event will receive. They are grouped
by emitting class.

Most events exist in pairs, one being sent **before** a given
operation, the other one **after**.

.. note::

   Unless mentioned otherwise, mentions of class :php:`File` below actually refer
   to the :php:`\TYPO3\CMS\Core\Resource\FileInterface` interface.

   :php:`Folder` objects actually refer to the :php:`\TYPO3\CMS\Core\Resource\Folder`
   class.

.. _fal-architecture-events-resource-storage:

\\TYPO3\\CMS\\Core\\Resource\\ResourceStorage
=============================================

SanitizeFileNameEvent
  The sanitize file name operation aims at removing characters from
  file names which are not allowed by the underlying Driver. The
  event receives the file name and the target folder.

BeforeFileAddedEvent
  Receives the target file name, the target folder (as a :php:`Folder` instance)
  and the local file path.

AfterFileAddedEvent
  Receives the :php:`File` instance corresponding to the
  newly stored file and the target folder (as a :php:`Folder` instance).

AfterFileCreatedEvent
  Receives the identifier of the newly created file and
  the target folder (as a :php:`Folder` instance).

BeforeFileCopiedEvent
  Receives a :php:`File` instance for the file to be copied and
  the target folder (as a :php:`Folder` instance).

AfterFileCopiedEvent
  Receives a :php:`File` instance for the file that was copied
  (i.e. the original file) and the target folder
  (as a :php:`Folder` instance).

BeforeFileMovedEvent
  Receives a :php:`File` instance for the file to be moved and
  the target folder (as a :php:`Folder` instance).

AfterFileMovedEvent
  Receives a :php:`File` instance for the file that was moved,
  the target folder and the original folder the file was in
  (both as :php:`Folder` instances).

BeforeFileDeletedEvent
  Receives a :php:`File` instance for the file to be deleted.

AfterFileDeletedEvent
  Receives a :php:`File` instance for the file that was deleted.

BeforeFileRenamedEvent
  Receives a :php:`File` instance for the file to be renamed
  and the sanitized new name.

AfterFileRenamedEvent
  Receives a :php:`File` instance for the file that was renamed
  and the sanitized new name.

BeforeFileReplacedEvent
  Receives a :php:`File` instance for the file to be replaced
  and the path to the local file that will replace it.

AfterFileReplacedEvent
  Receives a :php:`File` instance for the file that was replaced
  and the path to the local file that has replaced it.

AfterFileContentsSetEvent
  Receives a :php:`\TYPO3\CMS\Core\Resource\AbstractFile` instance
  for the file whose content was changed and the content itself
  (as a string).

BeforeFolderAddedEvent
  Receives the name of the new folder and a reference to the
  parent folder, if any (as a :php:`Folder` instance).

AfterFolderAddedEvent
  Receives the newly created folder (as a :php:`Folder` instance).

BeforeFolderCopiedEvent
  Receives references to the folder to copy and the parent target folder
  (both as :php:`\TYPO3\CMS\Core\Resource\FolderInterface` instances)
  and the sanitized name for the copy.

AfterFolderCopiedEvent
  Receives references to the original folder and the parent target folder
  (both as :php:`\TYPO3\CMS\Core\Resource\FolderInterface` instances)
  and the identifier of the newly copied folder.

BeforeFolderMovedEvent
  Receives references to the folder to move and the parent target folder
  (both as :php:`Folder` instances) and the sanitized target name.

AfterFolderMovedEvent
  Receives references to the folder to move and the parent target folder
  (both as :php:`Folder` instances), the identifier of the moved folder
  and a reference to the original parent folder (as a :php:`Folder` instance).

BeforeFolderDeletedEvent
  Receives a reference to the folder to delete (as a :php:`Folder` instance).

AfterFolderDeletedEvent
  Receives a reference to the deleted folder (as a :php:`Folder` instance).

BeforeFolderRenamedEvent
  Receives a reference to the folder to be renamed (as a :php:`Folder` instance)
  and the sanitized new name.

AfterFolderRenamedEvent
  Receives a reference to the renamed folder (as a :php:`Folder` instance)
  and the new identifier of the renamed folder.

GeneratePublicUrlForResourceEvent
  This event makes it possible to influence the construction of a
  resource's public URL. If the event defines the URL, it is kept as
  is and the rest of the URL generation process is ignored.

  It receives a reference to the instance for which the URL should be generated
  (as a :php:`\TYPO3\CMS\Core\Resource\ResourceInterface` instance),
  a boolean flag indicating whether the URL should be relative to the current
  script or absolute and a reference to the public URL (which is null at
  this point, but can be then modified by the event).

.. _fal-architecture-events-storage-repository:

\\TYPO3\\CMS\\Core\\Resource\\StorageRepository
===============================================

BeforeResourceStorageInitializationEvent
  This event is dispatched by method :code:`\TYPO3\CMS\Core\Resource\StorageRepository::getStorageObject()`
  before a storage object has been fetched. The event receives a reference
  to the storage.

AfterResourceStorageInitializationEvent
  This event is dispatched by method :code:`\TYPO3\CMS\Core\Resource\StorageRepository::getStorageObject()`
  after a Storage object has been fetched. The event receives a reference
  to the Storage.


.. _fal-architecture-events-file-index-repository:

\\TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository
========================================================

AfterFileAddedToIndexEvent
  Receives an array containing the information collected about the file
  whose index (i.e. "sys\_file" table entry) was just created.

AfterFileUpdatedInIndexEvent
  Receives an array containing the information collected about the file
  whose index (i.e. "sys\_file" table entry) was just updated.

AfterFileRemovedFromIndexEvent
  Receives the uid of the file (i.e. "sys\_file" table entry) which was deleted.

AfterFileMarkedAsMissingEvent
  Receives the uid of the file (i.e. "sys\_file" table entry) which was
  marked as missing.


.. _fal-architecture-events-metadata-repository:

\\TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository
=======================================================

EnrichFileMetaDataEvent
  This event is dispatched after metadata has been retrieved for a given
  file. The event receives the metadata as an :php:`\ArrayObject` instance.

AfterFileMetaDataCreatedEvent
  Receives an array containing the metadata collected about the file
  just after it has been inserted into the "sys\_file\_metadata" table.

AfterFileMetaDataUpdatedEvent
  This event is dispatched after metadata for a given file has been
  updated. The event receives the metadata as an array containing all
  metadata fields (and not just the updated ones).

AfterFileMetaDataDeletedEvent
  Receives the uid of the file whose metadata has just been deleted.


.. _fal-architecture-events-file-processing-service:

\\TYPO3\\CMS\\Core\\Resource\\Service\\FileProcessingService
============================================================

BeforeFileProcessingEvent
  This event is dispatched before a file is processed. The event receives
  a reference to the processed file and to the original file (both as
  :php:`File` instances), a string defining the type of task being
  executed and an array containing the configuration for that task.

AfterFileProcessingEvent
  This event is dispatched after a file has been processed. The event receives
  a reference to the processed file and to the original file (both as
  :php:`File` instances), a string defining the type of task being
  executed and an array containing the configuration for that task.

See the :ref:`section about Services <fal-architecture-components-services>`
for more information about this class.
