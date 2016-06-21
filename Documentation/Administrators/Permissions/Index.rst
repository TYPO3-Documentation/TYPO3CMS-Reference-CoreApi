.. include:: ../../Includes.txt


.. _Admin-Permissions:

===========
Permissions
===========

As for pages and contents, permissions can also be defined for files,
though not as fine-grained as for content (= on a per-file/folder
level). The permissions in the File Abstraction Layer are grouped in two main
groups:

- system permissions
- and user permissions

System Permissions
==================

System permissions are required by every part of the system to
perform operations. They are
strictly enforced and prevent an action no matter what component
triggered them.

For example think of a click in the file list versus a processed file
that is to be saved. The former could be stopped because the user
does not have enough permissions. The latter should always happen
if the storage is writable.

Administrators always have full access. The only reason they might not
have access is that the underlying file system or storage service does
not allow access to a resource.

.. todo::

   How are permissions from the storage device handled?



.. _admin-user-permissions:

User Permissions
================

User permissions for files used to be set in the "Fileoperation
permissions" section of the "backend user" or "backend user group" records.
This still works with FAL. But it is a
deprecated way because FAL offers more fine grained permission settings.

.. tip::

   As of TYPO3 6.0 it is recommended to set user default permissions in
   **User TSconfig** either in **backend user records** or **backend user group**
   records.

.. _Admin-Default-User-Permissions:

Default User Permissions
------------------------

The default permissions for backend users and backend user groups
are **READONLY**:

.. code-block:: typoscript

   permissions.file.default {
      addFile      = 0
      readFile     = 1
      writeFile    = 0
      copyFile     = 0
      moveFile     = 0
      renameFile   = 0
      unzipFile    = 0
      deleteFile   = 0
      addFolder    = 0
      readFolder   = 1
      writeFolder  = 0
      copyFolder   = 0
      moveFolder   = 0
      renameFolder = 0
      deleteFolder = 0
      recursivedeleteFolder = 0
   }

.. _Admin-User-Permissions-Per-Storage:

User Permissions Per Storage
----------------------------

It is also possible to set different permissions for different storages.
To achieve this you need to know the uid of the storage record and specify it
in User TSconfig along with the permissions.

Example: Permissions = ALL for storage with uid "1":

.. code-block:: typoscript

   permissions.file.storage.1 {
      addFile      = 1
      readFile     = 1
      writeFile    = 1
      copyFile     = 1
      moveFile     = 1
      renameFile   = 1
      unzipFile    = 1
      deleteFile   = 1
      addFolder    = 1
      readFolder   = 1
      writeFolder  = 1
      copyFolder   = 1
      moveFolder   = 1
      renameFolder = 1
      deleteFolder = 1
      recursivedeleteFolder = 1
   }

.. note::

   Configured permissions for a *specific* storage take precedence over
   default permissions.

If no permissions are defined in TSconfig, then the settings in the user
and in the group record are taken into account and will be treated as
default permissions for all storages.



.. _Permissions-Details:

Permissions Details
===================

This model for permissions behaves very similar to permission systems
on Unix and Linux systems. Folders are seen as a collection of files and
folders. If you want to change *that collection* by adding, removing or renaming
files or folders folders you need to have **write permissions for the folder** as well.
If you only want to change the contents of a file you need write permissions
for the file but not for the containing folder.

addFile
  Create new files, upload files

readFile
  Show contents of files

writeFile
  Edit or Save contents of file, even if NO write permissions to folders are granted

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
  add or create new folders; needs writeFolder permissions for the parent folder

readFolder
  list contents of folder

writeFolder
  Permission to change contents of folder (add files, rename files, add folders,
  rename folders). Changing contents of existing files is not governed by this
  permission!

copyFolder
  Needs writeFolder permissions for the target folder

moveFolder
  Needs writeFolder permissions for both target and source folder (because it is
  removed from the latter, which changes the folder).

renameFolder
  Needs writeFolder permissions (because it changes the folder itself and also
  the containing folder's contents).

deleteFolder
  Remove an (empty) folder; needs write folder permissions

recursivedeleteFolder
  Remove a folder even if it has contents; needs write folder permissions

