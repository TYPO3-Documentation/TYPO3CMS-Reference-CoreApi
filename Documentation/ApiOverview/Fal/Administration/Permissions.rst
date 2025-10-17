..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Permissions
..  _fal-administration-permissions:

===========
Permissions
===========

Permissions in the file abstraction layer are the result of a
combination of various mechanisms.

..  contents::
    :local:


..  _fal-administration-permissions-system:

System permissions
==================

System permissions are strictly enforced and may prevent an action
no matter what component triggered them.

Administrators always have full access. The only reason they might not
have access is that the underlying file system or storage service does
not allow access to a resource (for example, some file is read-only in the
local file system).


..  index:: File abstraction layer; File mounts
..  _fal-administration-permissions-mounts:

File mounts
===========

:ref:`File mounts <file-mounts>`
restrict users to a certain folder in a certain storage. This is
an obvious permission restriction: users will never be able to act
on a file or folder outside of their allotted file mounts.


..  _fal-administration-permissions-user:

User permissions
================

User permissions for files can be set in the
:ref:`"File operation permissions" section <access-lists-file-permissions>`
of the backend user or backend user group records.

It is also possible to set permissions using :ref:`user TSconfig <t3tsref:usertsconfig>`,
defined either at backend user or backend user group level. The TSconfig way is
recommended because it allows for more flexibility. See some examples below and
read on in the section about :ref:`permissions <t3tsref:userTsConfigPermissions>`
in the user TSconfig reference.

The default permissions for backend users and backend user groups
are **read-only**:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

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

If no permissions are defined in TSconfig, the settings in the backend user
and in the backend user group record are taken into account and treated as
default permissions for all :ref:`storages <fal-architecture-components-storage>`.


..  _fal-administration-permissions-user-storage:

User permissions per storage
----------------------------

Using :ref:`user TSconfig <t3tsref:usertsconfig>` it is possible to set
different permissions for different
:ref:`storages <fal-architecture-components-storage>`. This syntax uses the uid
of the targeted storage record.

The following example grants all permission for the storage with uid "1":

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

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

..  note::
    Configured permissions for a *specific* storage take precedence over
    default permissions.


..  _fal-administration-permissions-user-details:

User permissions details
------------------------

This model for permissions behaves very similar to permission systems
on Unix and Linux systems. Folders are seen as a collection of files and
folders. If you want to change *that collection* by adding, removing or renaming
files or folders you need to have **write permissions for the folder** as well.
If you only want to change the content of a file you need write permissions
for the file but not for the containing folder.

Here is the detail of what the various permission options mean:

:typoscript:`addFile`
    Create new files, upload files.

:typoscript:`readFile`
    Show content of files.

:typoscript:`writeFile`
    Edit or save contents of files, even if NO write permissions to folders are granted.

:typoscript:`copyFile`
    Allow copying of files; needs writeFolder permissions for the target folder.

:typoscript:`moveFile`
    Allow moving files; needs writeFolder permissions for source and target folders.

:typoscript:`renameFile`
    Allow renaming files; needs writeFolder permissions.

:typoscript:`deleteFile`
    Delete a file; needs writeFolder permissions.

:typoscript:`addFolder`
    Add or create new folders; needs writeFolder permissions for the parent folder.

:typoscript:`readFolder`
    List contents of folder.

:typoscript:`writeFolder`
    Permission to change contents of folder (add files, rename files, add folders,
    rename folders). Changing contents of existing files is not governed by this
    permission!

:typoscript:`copyFolder`
    Needs writeFolder permissions for the target folder.

:typoscript:`moveFolder`
    Needs writeFolder permissions for both target and source folder (because it is
    removed from the latter, which changes the folder).

:typoscript:`renameFolder`
    Needs writeFolder permissions (because it changes the folder itself and also
    the containing folder's contents).

:typoscript:`deleteFolder`
    Remove an (empty) folder; needs write folder permissions.

:typoscript:`recursivedeleteFolder`
    Remove a folder even if it has contents; needs write folder permissions.


.. index:: File abstraction layer; Default upload folder
.. _fal-administration-permissions-upload-folder:

Default upload folder
=====================

When nothing else is defined, any file uploaded by a user will end up
in :file:`fileadmin/user_upload/`. The user TSconfig property
:ref:`defaultUploadFolder <t3tsref:useroptions-defaultuploadfolder>`, allows
to define a different default upload folder on a backend user or backend user
group level, for example:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

    options.defaultUploadFolder = 3:users/uploads/


Since TYPO3 v12.3 it is also possible to modify default upload folder per page
(or subtree) using page TSConfig property :typoscript:`options.defaultUploadFolder`,
for example:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/page.tsconfig

    # Set default upload folder to "fileadmin/page_upload" on PID 1
    [page["uid"] == 1]
        options.defaultUploadFolder = 1:/page_upload/
    [end]

There are a number of circumstances where it might be convenient
to change the default upload folder. The PSR-14 event
:ref:`AfterDefaultUploadFolderWasResolvedEvent` exists to provide
maximum flexibility in that regard. For example, take a look at the extension
`default_upload_folder`_, which makes it possible to define a default upload
folder for a given field of a given table (using custom TSconfig).

..  _default_upload_folder: https://github.com/beechit/default_upload_folder


..  _fal-administration-permissions-frontend:

Frontend permissions
====================

The system extension `filemetadata`_ adds a :sql:`fe_groups` field to the
:ref:`sys_file_metadata <fal-architecture-database-sys-file-metadata>` table.
This makes it possible to attach frontend permissions to files. However, these
permissions are not enforced in any way by the TYPO3 Core. It is up to extension
developers to create tools which make use of these permissions.

As an example, you may want to take a look at extension
:t3ext:`fal_securedownload`
which also makes use of the "Is publicly available?" property of
:ref:`File storages <fal-administration-storages>`.

..  _filemetadata: https://packagist.org/packages/typo3/cms-filemetadata
