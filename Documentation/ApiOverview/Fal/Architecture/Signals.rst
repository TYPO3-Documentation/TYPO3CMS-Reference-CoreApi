.. include:: ../../../Includes.txt


.. _fal-architecture-signals:

Signals and slots
^^^^^^^^^^^^^^^^^

FAL comes with a series of signals that offer the opportunity
to hook into FAL processes at a variety of points.

They are listed below with some explanation, in particular when
they are sent (if the name is not explicit enough) and what
parameters the corresponding slot will receive. They are grouped
by emitting class.

Most signals exist in pairs, one being sent **before** a given
operation, the other one **after**.

.. note::

   Unless mentioned otherwise, mentions of class "File" below actually refer
   to the :php:`\TYPO3\CMS\Core\Resource\FileInterface` interface.

   "Folder" objects actually refer to the :php:`\TYPO3\CMS\Core\Resource\Folder`
   class.

.. _fal-architecture-signals-resource-storage:

\\TYPO3\\CMS\\Core\\Resource\\ResourceStorage
"""""""""""""""""""""""""""""""""""""""""""""

All signals are identified by constants of the
:php:`\TYPO3\CMS\Core\Resource\ResourceStorageInterface` interface.

SIGNAL_SanitizeFileName
  The sanitize file name operation aims at removing characters from
  file names which are not allowed by the underlying Driver. The
  slot receives the file name and the target folder.

SIGNAL_PreFileAdd
  Receives the target file name, the target folder (as a :php:`Folder` instance)
  and the local file path.

SIGNAL_PostFileAdd
  Receives the :php:`File` instance corresponding to the
  newly stored file and the target folder (as a :php:`Folder` instance).

SIGNAL_PostFileCreate
  Receives the identifier of the newly created file and
  the target folder (as a :php:`Folder` instance).

SIGNAL_PreFileCopy
  Receives a :php:`File` instance for the file to be copied and
  the target folder (as a :php:`Folder` instance).

SIGNAL_PostFileCopy
  Receives a :php:`File` instance for the file that was copied
  (i.e. the original file) and the target folder
  (as a :php:`Folder` instance).

SIGNAL_PreFileMove
  Receives a :php:`File` instance for the file to be moved and
  the target folder (as a :php:`Folder` instance).

SIGNAL_PostFileMove
  Receives a :php:`File` instance for the file that was moved,
  the target folder and the original folder the file was in
  (both as :php:`Folder` instances).

SIGNAL_PreFileDelete
  Receives a :php:`File` instance for the file to be deleted.

SIGNAL_PostFileDelete
  Receives a :php:`File` instance for the file that was deleted.

SIGNAL_PreFileRename
  Receives a :php:`File` instance for the file to be renamed
  and the sanitized new name.

SIGNAL_PostFileRename
  Receives a :php:`File` instance for the file that was renamed
  and the sanitized new name.

SIGNAL_PreFileReplace
  Receives a :php:`File` instance for the file to be replaced
  and the path to the local file that will replace it.

SIGNAL_PostFileReplace
  Receives a :php:`File` instance for the file that was replaced
  and the path to the local file that has replaced it.

SIGNAL_PostFileSetContents
  Receives a :php:`\TYPO3\CMS\Core\Resource\AbstractFile` instance
  for the file whose content was changed and the content itself
  (as a string).

SIGNAL_PreFolderAdd
  Receives the name of the new folder and a reference to the
  parent folder, if any (as a :php:`Folder` instance).

SIGNAL_PostFolderAdd
  Receives the newly created folder (as a :php:`Folder` instance).

SIGNAL_PreFolderCopy
  Receives references to the folder to copy and the parent target folder
  (both as :php:`\TYPO3\CMS\Core\Resource\FolderInterface` instances)
  and the sanitized name for the copy.

SIGNAL_PostFolderCopy
  Receives references to the original folder and the parent target folder
  (both as :php:`\TYPO3\CMS\Core\Resource\FolderInterface` instances)
  and the identifier of the newly copied folder.

SIGNAL_PreFolderMove
  Receives references to the folder to move and the parent target folder
  (both as :php:`Folder` instances) and the sanitized target name.

SIGNAL_PostFolderMove
  Receives references to the folder to move and the parent target folder
  (both as :php:`Folder` instances), the identifier of the moved folder
  and a reference to the original parent folder (as a :php:`Folder` instance).

SIGNAL_PreFolderDelete
  Receives a reference to the folder to delete (as a :php:`Folder` instance).

SIGNAL_PostFolderDelete
  Receives a reference to the deleted folder (as a :php:`Folder` instance).

SIGNAL_PreFolderRename
  Receives a reference to the folder to be renamed (as a :php:`Folder` instance)
  and the sanitized new name.

SIGNAL_PostFolderRename
  Receives a reference to the renamed folder (as a :php:`Folder` instance)
  and the new identifier of the renamed folder.

SIGNAL_PreGeneratePublicUrl
  This signal makes it possible to influence the construction of a
  resource's public URL. If the slot defines the URL, it is kept as
  is and the rest of the URL generation process is ignored.

  It receives a reference to the instance for which the URL should be generated
  (as a :php:`\TYPO3\CMS\Core\Resource\ResourceInterface` instance),
  a boolean flag indicating whether the URL should be relative to the current
  script or absolute and a reference to the public URL (which is null at
  this point, but can be then modified by the slot).


.. _fal-architecture-signals-resource-factory:

\\TYPO3\\CMS\\Core\\Resource\\ResourceFactory
"""""""""""""""""""""""""""""""""""""""""""""

The signal is identified by a constant of the
:php:`\TYPO3\CMS\Core\Resource\ResourceFactoryInterface`
interface.

SIGNAL_PostProcessStorage
  This signal is emitted by method :code:`\TYPO3\CMS\Core\Resource\ResourceFactory::getStorageObject()`
  after a Storage object has been fetched. The slot receives a reference
  to the Storage.


.. _fal-architecture-signals-file-index-repository:

\\TYPO3\\CMS\\Core\\Resource\\Index\\FileIndexRepository
""""""""""""""""""""""""""""""""""""""""""""""""""""""""

recordCreated
  Receives an array containing the information collected about the file
  whose index (i.e. "sys\_file" table entry) was just created.

recordUpdated
  Receives an array containing the information collected about the file
  whose index (i.e. "sys\_file" table entry) was just updated.

recordDeleted
  Receives the uid of the file (i.e. "sys\_file" table entry) which was deleted.

recordMarkedAsMissing
  Receives the uid of the file (i.e. "sys\_file" table entry) which was
  marked as missing.


.. _fal-architecture-signals-metadata-repository:

\\TYPO3\\CMS\\Core\\Resource\\Index\\MetaDataRepository
"""""""""""""""""""""""""""""""""""""""""""""""""""""""

recordPostRetrieval
  This signal is emitted after metadata has been retrieved for a given
  file. The slot receives the metadata as an :php:`\ArrayObject` instance.

recordCreated
  Receives an array containing the metadata collected about the file
  just after it has been inserted into the "sys\_file\_metadata" table.

recordUpdated
  This signal is emitted after metadata for a given file has been
  updated. The slot receives the metadata as an array containing all
  metadata fields (and not just the updated ones).

recordDeleted
  Receives the uid of the file whose metadata has just been deleted.


.. _fal-architecture-signals-file-processing-service:

\\TYPO3\\CMS\\Core\\Resource\\Service\\FileProcessingService
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

All signals are identified by constants of the
:php:`\TYPO3\CMS\Core\Resource\Service\FileProcessingService`
class.

SIGNAL_PreFileProcess
  This signal is emitted before a file is processed. The slot receives
  a reference to the processed file and to the original file (both as
  :php:`File` instances), a string defining the type of task being
  executed and an array containing the configuration for that task.

SIGNAL_PostFileProcess
  This signal is emitted after a file has been processed. The slot receives
  a reference to the processed file and to the original file (both as
  :php:`File` instances), a string defining the type of task being
  executed and an array containing the configuration for that task.

See the :ref:`section about Services <fal-architecture-components-services>`
for more information about this class.
