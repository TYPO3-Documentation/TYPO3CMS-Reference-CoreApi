.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin:

Admin Documentation
-------------------

This chapter explains what admins need to know when working with files and TYPO3. In particular it explains
what to note when upgrading an older version of TYPO3 to TYPO3 6.0 and thereby make the switch to FAL.


.. _admin-introduction:

Introduction / Basic Concepts
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The file abstraction layer (FAL) brings a number of changes relevant to the administrator of a TYPO3 site. This chapter is trying to shed light on these points.


.. _admin-references:

No copies: References!
""""""""""""""""""""""

The most fundamental change the introduction of FAL brings is that files are not copied any more for each usage but referenced instead for each time you use it on a page.

For the editors, this means that:

* Less disk space is used: If the same image is displayed in 4 different locations on the site, only one fourth of the disk space is needed.
* Assets can be centrally replaced: It's possible to centrally replace a file with an updated version without having to change it in each individual place where it's used.
* Tracking usages is possible: It's possible to identify for any asset where it is used throughout the page and display or count the references to it. This makes it technically possible to display warnings when deleting an asset to warn the user of existing references to it.


.. _admin-storages:

Storages
""""""""

The central concept of FAL is that of Storages. Storages can be seen as "mounted directories" either local or from remote systems. Not only additional mounts are handled as storages, but also the main fileadmin/ directory. The fileadmin/ storage will be created automatically when you upgrade an installation to TYPO3 6.0, but from then on it behaves just like any other storage.

To create a new storage, just create a new "Storage" record using the List module (Web->List) on the root page (uid=0). You can now create any number of other Storages alonside the fileadmin/ directory or even remove the initial fileadmin/ storage altogether or change its location easily by editing its Storage record. (Beware that this could break relations to the files from the content records though, unless you move the files along on the filesystem as well.)


.. _admin-irre:

Images as IRRE-Child records
""""""""""""""""""""""""""""

When attaching images to a content record, TYPO3 now uses an IRRE inline child record for each of the image where settings such as the alt- or title text can be configured along with the image links and the description. This makes the interface for the editor much cleaner, and remove the disadvantage of older versions where e.g. such meta data (caption text, image links, descriptions) had to be entered newline-separated in different fields.

The IRRE child records are records from the "sys_file_references" table with each child record representing one reference from a content element (or other table) to a file. The file is again represented by a sys_file record. For more information regarding the database structure, see the [[[DeveloperDocumentation/DatabaseStructure.rst Developer Documentation]]].


.. _admin-migrating:

Migrating
^^^^^^^^^


.. _admin-changes:

Necessary changes
"""""""""""""""""

When a pre-FAL installtion is migrated to FAL, this is what needs to be changes (see next chapter about the tools that help you achieve that):

* Filemounts in the sys_filemounts table need to be migrated
* For every mount point with an absolute path, a new storage is created with the absolute path as base path
* For every mount point, the sys_file_mount is converted to a new structure where mounts act as "filters" on storages which can be assigned to users

* A new "Storage" record has been created for you, which mounts the basic "fileadmin/" directory.

* The media and image fields of the Content and Pages table have been changed to use proper FAL relations. This technically means that images have been copied to the fileadmin directory and proper relations made. This means that:

  * For each file in fileadmin/, a sys_file record has been created (also called the "index records")
  * For each usage of the file from a content element, a relation records has been created (table "sys_file_references") which relates the content record to the index record



.. _admin-compatibility:

Extension compatibility
"""""""""""""""""""""""

Generally, all extensions which just use files in a frontend extension or have database records with files attached to them should work the same way still and continue to be working without any adoption. (Note: Extensions which depend on DAM however need manual adoption, see the developers section for more details.)

However, if you want to support FAL "the right way" and not just by means of the backwards compatibility layer, the developers of the extensions should take update the extensions to make use of the API as ountlined in the developers documentation.


.. _admin-remote-storages:

Using Remote Storages
"""""""""""""""""""""

To use a remote storage, you have to do two things:
1) Install a driver extension for the remote system (e.g. WebDAV)

Drivers are shipped in normal TYPO3 extensions and can be found on the TYPO3 Extension Repository. One example driver is the "WebDAV" driver (http://forge.typo3.org/projects/show/extension-fal_webdav), but it is also possible to program a custom driver which could e.g. connect to a cloud storage like Amazon S3 or similar.

Once the driver extension is installed, you can proceed to the next step.

2) Create a new Storage record for the remote storage

When you create the Storage record for the remote Storage, you are asked for more details on the connection to the remote Storage such as authentification credentials (if necessary) and server URLs. Once the Storage is configured, its data should be shown in the File->Filelist module just like files from a local storage.


.. _admin-indexing:

Indexing
""""""""

TODO: Write.

* fine-tuning
* cron-automation


.. _admin-permissions:

User Permissions
""""""""""""""""

User permissions for files used to be set in the "Fileoperation permissions" section of
backend user or backend user group records. This way still works since the introduction
of FAL but has been deprecated because FAL offers more fine grained permission settings.

As of TYPO3 6.0 it is recommended to set user default permissions in User TSConfig either
in backend user records or backend user group records.

**Default permissions for a user or user group (read permissions only):** ::

    permissions.file.default {
        addFile = 0
        readFile = 1
        editFile = 0
        writeFile = 0
        uploadFile = 0
        copyFile = 0
        moveFile = 0
        renameFile = 0
        unzipFile = 0
        removeFile = 0
        addFolder = 0
        readFolder = 1
        moveFolder = 0
        writeFolder = 0
        renameFolder = 0
        removeFolder = 0
        removeSubfolders = 0
    }

It is also possible to set different permissions for different storages.
For that you need to know the uid of the storage record and specify it
in User TSConfig along with the permissions like that:

**Permissions for storage with uid "1" (all permissions):** ::

    permissions.file.storage.1 {
        addFile = 1
        readFile = 1
        editFile = 1
        writeFile = 1
        uploadFile = 1
        copyFile = 1
        moveFile = 1
        renameFile = 1
        unzipFile = 1
        removeFile = 1
        addFolder = 1
        readFolder = 1
        moveFolder = 1
        writeFolder = 1
        renameFolder = 1
        removeFolder = 1
        removeSubfolders = 1
    }

Configuring permissions for a specific storage always takes precedence over
default permissions.

If no permissions are defined in TSConfig, settings in user and group record are
taken into account and will be treated as default permissions for all storages.


.. _admin-faq:

Frequently Asked Questions (FAQ)
""""""""""""""""""""""""""""""""

What happened to the TCEForms "group" field with internal_type "file"?
  It's still working in the same way it used to work, copying files to the uploads/ folder for maximum backwards compatibility.
  However, it is adviced to adopt extensions to use FAL natively as the field type is now deprecated.

What happened to the typo3temp/ folder?
  The typo3temp/ folder is no longer used. Instead, a configurable temporary directory (on a per-Storage basis) replaces that concept instead.
  Temporary files are now called "processedFiles" and are tracked in the database table sys_file_processedfile.

