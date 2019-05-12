.. include:: ../../../Includes.txt


.. _fal-administration-permissions:

===========
Permissions
===========

Permissions in the File Abstraction Layer are the result of a
combination of various mechanisms.


.. _fal-administration-permissions-system:

System Permissions
==================

System permissions are strictly enforced and may prevent an action
no matter what component triggered them.

Administrators always have full access. The only reason they might not
have access is that the underlying file system or storage service does
not allow access to a resource (e.g. some file is read-only in the
local file system).


.. _fal-administration-permissions-mounts:

File Mounts
===========

Files mounts (discussed in the :ref:`Getting Started Tutorial <t3start:file-mounts>`)
restrict users to a certain folder in a certain Storage. This is
an obvious permission restriction: users will never be able to act
on a file or folder outside of their allotted file mounts.


.. _fal-administration-permissions-user:

User Permissions
================

User permissions for files can be set in the
:ref:`"Fileoperation permissions" section <t3start:file-permissions>`
of the Backend User or Backend User Group records.

It is also possible to set permissions using :ref:`User TSconfig <t3tsconfig:usertsconfig>`,
defined either at Backend User or Backend User Group level. The TSconfig way is recommended because
it allows for more flexibility. See some examples below and read on in the section about
:ref:`permissions <t3tsconfig:userTsConfigPermissions>` in the user TSconfig reference.

The default permissions for backend users and backend user groups
are **read-only**:

.. code-block:: typoscript

   permissions.file.default {
      addFile      = 0
      readFile     = 1
      writeFile    = 0
      copyFile     = 0
      moveFile     = 0
      renameFile   = 0
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

If no permissions are defined in TSconfig, the settings in the Backend User
and in the Backend User Group record are taken into account and treated as
default permissions for all Storages.


.. _fal-administration-permissions-user-storage:

User Permissions per Storage
----------------------------

Using :ref:`User TSconfig <t3tsconfig:usertsconfig>` it is possible to set different permissions
for different Storages. This syntax uses the uid of the targeted
Storage record.

The following example grants all permission for the Storage with uid "1":

.. code-block:: typoscript

   permissions.file.storage.1 {
      addFile      = 1
      readFile     = 1
      writeFile    = 1
      copyFile     = 1
      moveFile     = 1
      renameFile   = 1
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

   Configured permissions for a *specific* Storage take precedence over
   default permissions.



.. _fal-administration-permissions-user-details:

User Permissions Details
------------------------

This model for permissions behaves very similar to permission systems
on Unix and Linux systems. Folders are seen as a collection of files and
folders. If you want to change *that collection* by adding, removing or renaming
files or folders you need to have **write permissions for the folder** as well.
If you only want to change the content of a file you need write permissions
for the file but not for the containing folder.

Here is the detail of what the various permission options mean:

addFile
  Create new files, upload files.

readFile
  Show content of files.

writeFile
  Edit or save contents of files, even if NO write permissions to folders are granted.

copyFile
  Allow copying of files; needs writeFolder permissions for the target folder.

moveFile
  Allow moving files; needs writeFolder permissions for source and target folders.

renameFile
  Allow renaming files; needs writeFolder permissions.

deleteFile
  Delete a file; needs writeFolder permissions.

addFolder
  Add or create new folders; needs writeFolder permissions for the parent folder.

readFolder
  List contents of folder.

writeFolder
  Permission to change contents of folder (add files, rename files, add folders,
  rename folders). Changing contents of existing files is not governed by this
  permission!

copyFolder
  Needs writeFolder permissions for the target folder.

moveFolder
  Needs writeFolder permissions for both target and source folder (because it is
  removed from the latter, which changes the folder).

renameFolder
  Needs writeFolder permissions (because it changes the folder itself and also
  the containing folder's contents).

deleteFolder
  Remove an (empty) folder; needs write folder permissions.

recursivedeleteFolder
  Remove a folder even if it has contents; needs write folder permissions.


.. _fal-administration-permissions-upload-folder:

Default Upload Folder
=====================

When nothing else is defined, any file uploaded by a user will end up
in :file:`fileadmin/user_upload`. The user TSconfig property
:ref:`defaultUploadFolder <t3tsconfig:useroptions-defaultuploadfolder>`, allows to define a
different default upload folder on a backend user or backend user group level, example:

.. code-block:: typoscript

   options.defaultUploadFolder = 3:users/uploads/


There are a number of circumstances where it might be convenient
to change the default upload folder. A hook exists to provide
maximum flexibility in that regard. For example, take a look at
extension `default_upload_folder <https://github.com/beechit/default_upload_folder>`_,
which makes it possible to define a default upload folder for
a given field of a given table (using custom TSconfig).


.. _fal-administration-permissions-frontend:

Frontend Permissions
====================

System extension "filemetadata" adds a "fe_groups" field to the
"sys\_file\_metadata" table. This makes it possible to attach
frontend permissions to files. However these permissions are not
enforced in any way by the TYPO3 CMS Core. It is up to extension
developers to create tools which make use of these permissions.

As an example, you may want to take a look at extension
`fal_securedownload <https://extensions.typo3.org/extension/fal_securedownload>`_
which also makes use of the "Is publicly available?" property of
:ref:`File Storages <fal-administration-storages>`.
