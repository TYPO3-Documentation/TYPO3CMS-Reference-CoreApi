.. include:: ../../Includes.txt


.. _architecture-signals:

Signals and slots
"""""""""""""""""

FAL comes with a great many signals that offer the opportunity
to hook into FAL processes at a variety of points.

All signals are identified by constants of the
:class:`\\TYPO3\\CMS\\Core\\Resource\\ResourceStorageInterface` interface.
They are list below with some explanation, in particular when
they are sent (if the name is not explicit enough) and what
parameters the corresponding slot will receive.

Most signals exist in pairs, one being sent **before** a given
operation, the other one **after**.

.. note::

   Unless mentioned otherwise, mentions of class "File" below actually refer
   to the :class:`\\TYPO3\\CMS\\Core\\Resource\\FileInterface` interface.

  "Folder" objects actually refer to the :class:`\\TYPO3\\CMS\\Core\\Resource\\Folder`
  class.

SIGNAL_SanitizeFileName
  The sanitize file name operation aims at removing characters from
  file names which are not allowed by the underlying Driver. The
  slot receives the file name and the target folder.

SIGNAL_PreFileAdd
  Receives the target file name, the target folder (as a :class:`Folder` instance)
  and the local file path.

SIGNAL_PostFileAdd
  Receives the :class:`File` instance corresponding to the
  newly stored file and the target folder (as a :class:`Folder` instance).

SIGNAL_PostFileCreate
  Receives the identifier of the newly created file and
  the target folder (as a :class:`Folder` instance).

SIGNAL_PreFileCopy
  Receives a :class:`File` instance for the file to be copied and
  the target folder (as a :class:`Folder` instance).

SIGNAL_PostFileCopy
  Receives a :class:`File` instance for the file that was copied
  (i.e. the original file) and the target folder
  (as a :class:`Folder` instance).

SIGNAL_PreFileMove
  Receives a :class:`File` instance for the file to be moved and
  the target folder (as a :class:`Folder` instance).

SIGNAL_PostFileMove
  Receives a :class:`File` instance for the file that was moved,
  the target folder and the original folder the file was in
  (both as :class:`Folder` instances).

SIGNAL_PreFileDelete
  Receives a :class:`File` instance for the file to be deleted.

SIGNAL_PostFileDelete
  Receives a :class:`File` instance for the file that was deleted.

SIGNAL_PreFileRename
  Receives a :class:`File` instance for the file to be renamed
  and the sanitized new name.

SIGNAL_PostFileRename
  Receives a :class:`File` instance for the file that was renamed
  and the sanitized new name.

SIGNAL_PreFileReplace
  Receives a :class:`File` instance for the file to be replaced
  and the path to the local file that will replace it.

SIGNAL_PostFileReplace
  Receives a :class:`File` instance for the file that was replaced
  and the path to the local file that has replaced it.

SIGNAL_PostFileSetContents
  Receives a :class:`\\TYPO3\\CMS\\Core\\Resource\\AbstractFile` instance
  for the file whose content was changed and the content itself
  (as a string).

SIGNAL_PreFolderAdd
  Receives the name of the new folder and a reference to the
  parent folder, if any (as a :class:`Folder` instance).

SIGNAL_PostFolderAdd
  Receives the newly created folder (as a :class:`Folder` instance).

SIGNAL_PreFolderCopy
  Receives references to the folder to copy and the parent target folder
  (both as :class:`\\TYPO3\\CMS\\Core\\Resource\\FolderInterface` instances)
  and the sanitized name for the copy.

SIGNAL_PostFolderCopy
  Receives references to the original folder and the parent target folder
  (both as :class:`\\TYPO3\\CMS\\Core\\Resource\\FolderInterface` instances)
  and the identifier of the newly copied folder.

SIGNAL_PreFolderMove
  Receives references to the folder to move and the parent target folder
  (both as :class:`Folder` instances) and the sanitized target name.

SIGNAL_PostFolderMove
  Receives references to the folder to move and the parent target folder
  (both as :class:`Folder` instances), the identifier of the moved folder
  and a reference to the original parent folder (as a :class:`Folder` instance).

SIGNAL_PreFolderDelete
  Receives a reference to the folder to delete (as a :class:`Folder` instance).

SIGNAL_PostFolderDelete
  Receives a reference to the deleted folder (as a :class:`Folder` instance).

SIGNAL_PreFolderRename
  Receives a reference to the folder to be renamed (as a :class:`Folder` instance)
  and the sanitized new name.

SIGNAL_PostFolderRename
  Receives a reference to the renamed folder (as a :class:`Folder` instance)
  and the new identifier of the renamed folder.

SIGNAL_PreGeneratePublicUrl
  This signal makes it possible to influence the construction of a
  resource's public URL. If the slot defines the URL, it is kept as
  is and the rest of the URL generation process is ignored.

  It receives a reference to the instance for which the URL should be generated
  (as a :class:`\\TYPO3\\CMS\\Core\\Resource\\ResourceInterface` instance),
  a boolean flag indicating whether the URL should be relative to the current
  script or absolute and a reference to the public URL (which is null at
  this point, but can be then modified by the slot).
