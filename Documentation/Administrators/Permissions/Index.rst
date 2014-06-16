.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _admin-permissions:

------------------
Permissions
------------------

As for pages and contents, permissions can also be defined for files, though not as fine-grained as for content (= on a per-file/folder level).

The permissions in the File Abstraction Layer are grouped in two main groups: system and user permissions. System permissions are required to perform operations in the system, by every part of the system. They are strictly enforced and prevent an action no matter what component triggered them (think of a click in the file list vs. a processed file that is being saved -- the former could be stopped because the user does not have enough permissions, while the latter is always performed if the storage is writable).

Administrators always have full access. The only reason they might be denied access is that the underlying file system/storage service does not allow access to a resource. TODO how are permissions from the storage device handled?


.. _admin-user-permissions:

User Permissions
""""""""""""""""

User permissions for files used to be set in the "Fileoperation permissions" section of
backend user or backend user group records. This way still works since the introduction
of FAL. But it has been deprecated because FAL offers more fine grained permission settings.

As of TYPO3 6.0 it is recommended to set user default permissions in User TSconfig either
in backend user records or backend user group records.

**Default permissions for a user or user group (read permissions only):** ::

    permissions.file.default {
        addFile = 0
        readFile = 1
        writeFile = 0
        copyFile = 0
        moveFile = 0
        renameFile = 0
        unzipFile = 0
        deleteFile = 0
        addFolder = 0
        readFolder = 1
        writeFolder = 0
        copyFolder = 0
        moveFolder = 0
        renameFolder = 0
        deleteFolder = 0
        recursivedeleteFolder = 0
    }

It is also possible to set different permissions for different storages.
For that you need to know the uid of the storage record and specify it
in User TSconfig along with the permissions like that:

**Permissions for storage with uid "1" (all permissions):** ::

    permissions.file.storage.1 {
        addFile = 1
        readFile = 1
        writeFile = 1
        copyFile = 1
        moveFile = 1
        renameFile = 1
        unzipFile = 1
        deleteFile = 1
        addFolder = 1
        readFolder = 1
        writeFolder = 1
        copyFolder = 1
        moveFolder = 1
        renameFolder = 1
        deleteFolder = 1
        recursivedeleteFolder = 1
    }

Configured permissions for a specific storage always take precedence over
default permissions.

If no permissions are defined in TSconfig, then the settings in the user and in the group record are
taken into account and will be treated as default permissions for all storages.

The model for the permissions is closely coupled to the one used on \*NIX systems,
i.e. folders are seen as a collection of files and folders. To change that collection
(by adding, removing, renaming files/folders), you need to have write permissions on the folder,
not only on the files themselves. But for only changing the contents of a file,
no writer permissions are required on the folder.


.. _admin-user-permissions-details:

User file permissions in detail
-------------------------------

addFile
  create new files, upload files

readFile
  Show contents of files

writeFile
  Edit/Save contents of file, even if write permissions to folders are not granted

copyFile
  Allow copying of files; needs writeFolder permissions for the target folder

moveFile
  Allow moving files; needs writeFolder permissions for source and target folders

renameFile
  Allow renaming a file; needs writeFolder permissions

unzipFile
  Allow unzipping a file; needs writeFolder permissions on the target folder

deleteFile
  delete a file; needs writeFolder permissions

addFolder
  add/create new folders; needs writeFolder permissions for the parent folder

readFolder
  list contents of folder

writeFolder
  Permission to change contents of folder (add files, rename files, add folders, rename folders). Changing contents of existing files is not governed by this permission!

copyFolder
  Needs writeFolder permissions for the target folder

moveFolder
  Needs writeFolder permissions for both target and source folder (because it is removed from the latter, which changes the folder).

renameFolder
  Needs writeFolder permissions (because it changes the folder itself and also the containing folder's contents)

deleteFolder
  Remove an (empty) folder; needs write folder permissions

recursivedeleteFolder
  Remove a folder even if it has contents; needs write folder permissions

