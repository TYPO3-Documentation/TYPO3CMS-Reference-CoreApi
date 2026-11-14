..  include:: /Includes.rst.txt
..  index::
    File abstraction layer; Storages
    File; config/system/file-storages.yaml
..  _fal-administration-storages:

=================================================
Configuring file storages in `file-storages.yaml`
=================================================

:navigation-title: File storages

A
`file storage <https://docs.typo3.org/permalink/t3coreapi:fal-architecture-components-storage>`_
defines where TYPO3 reads and writes files, with which driver, and with which
credentials.

..  typo3:file:: file-storages.yaml
    :scope: project
    :regex: /^((.*\/)?(config|typo3conf)\/system\/)?file-storages\.yaml$/
    :composerPath: config/system/
    :classicPath: typo3conf/system/
    :shortDescription: Configures the file storages of the installation.

    You configure the file storages of an installation in the file
    :file:`config/system/file-storages.yaml`. In classic mode, the file is
    :file:`typo3conf/system/file-storages.yaml`.

There is no backend form for this file. Only the people and tools that
maintain :path:`config/system/` can change a storage, for example system
maintainers, deployment tooling, and upgrade code.

..  versionchanged:: 15.0
    :changelog: breaking-110762-1789862500

    Before, file storages were records of the table `sys_file_storage`,
    edited in the :guilabel:`Content > Records` module. The upgrade wizard
    "Move file storage records to config/system/file-storages.yaml" writes
    these records into the file. Run it where you can commit the result,
    usually in the development environment, and deploy the file before you
    upgrade the production system.

..  contents::
    :local:


..  _fal-administration-storages-default:

The default file storage without `file-storages.yaml`
=====================================================

The file is optional. Without it, TYPO3 uses one local storage with the
identifier `1` and the name `fileadmin`. It points to the directory set in
`$GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir'] <https://docs.typo3.org/permalink/t3coreapi:typo3confvars-be-fileadmindir>`_.
An installation that needs only this storage needs no file.

Every file that the file abstraction layer handles is in a configured storage.
Files of extensions, referenced as `EXT:` or `PKG:`, are
`system resources <https://docs.typo3.org/permalink/t3coreapi:resources>`_
instead.

..  versionchanged:: 15.0
    :changelog: breaking-110361-1785715200

    The virtual fallback storage with the identifier `0`, which covered the
    whole web root, was removed. The upgrade wizard "Migrate files of the
    removed fallback storage (uid 0)" moves its file records into the
    storage that contains the file. It marks a record outside all storages
    as missing and attaches it to the default storage.


..  _fal-administration-storages-example:

Example: A public and a private file storage in `file-storages.yaml`
====================================================================

The following file defines the storage :file:`fileadmin/` and a second
storage for files that the web server must not deliver directly:

..  literalinclude:: _file-storages.yaml
    :caption: config/system/file-storages.yaml

The key of each entry under `storages` is the identifier of the storage. It is
a positive integer, because every reference to a file or folder contains it,
from the `storage` column of the `sys_file` table to a combined identifier
such as `1:/user_upload/`. Do not reuse the identifier of a removed storage:
file mounts, upload folders in TSconfig, and links can still point to it.

When the file defines more than one storage, exactly one of them must set
`default: true`.


..  _fal-administration-storages-options:
..  _fal-architecture-database-sys-file-storage:

Options of a file storage in `file-storages.yaml`
=================================================

All options are optional.

..  confval-menu::
    :name: fal-storage-options
    :display: table
    :type:
    :default:

    ..  confval:: name
        :name: fal-storage-name
        :type: string
        :default: `Storage <identifier>`

        The name of the storage in the backend, for example in the file tree
        of the :guilabel:`Media` module.

    ..  confval:: driver
        :name: fal-storage-driver
        :type: string
        :default: `Local`

        The short name of the
        `driver <https://docs.typo3.org/permalink/t3coreapi:fal-architecture-components-drivers>`_.
        The TYPO3 Core provides the driver `Local` for the local file system.
        Extensions can register further drivers, for example for a cloud
        service.

    ..  confval:: default
        :name: fal-storage-default
        :type: bool
        :default: `true` for a single storage, `false` otherwise

        TYPO3 uses the default storage for every operation that does not name
        a storage.

    ..  confval:: browsable
        :name: fal-storage-browsable
        :type: bool
        :default: `true`

        If `false`, users cannot browse the storage in the :guilabel:`Media`
        module or in the link browser.

    ..  confval:: public
        :name: fal-storage-public
        :type: bool
        :default: `true`

        If `false`, the public URL of a file points to a script of the
        TYPO3 Core instead of the file itself. The URL looks like
        `index.php?eID=dumpFile&t=f&f=1230&token=135b17c52f5e718b7cc94e44186eb432e0cc6d2f`.
        The class
        :php-short:`\TYPO3\CMS\Core\Controller\FileDumpController`
        delivers the file. It does not check access itself. Use the PSR-14
        event
        `ModifyFileDumpEvent <https://docs.typo3.org/permalink/t3coreapi:modifyfiledumpevent>`_
        to add the checks.

        ..  warning::
            This does not protect your files if the base path of the storage
            is within your web root. Anyone who knows the path to a file can
            still load it. For a strict access restriction, put the base path
            outside the web root. Alternatively, block direct access to the
            directory in the web server, for example in an Apache
            :file:`.htaccess` file.

    ..  confval:: writable
        :name: fal-storage-writable
        :type: bool
        :default: `true`

        If `false`, the storage is read-only.

    ..  confval:: online
        :name: fal-storage-online
        :type: bool
        :default: `true`

        If `false`, the storage cannot be accessed in the backend. Use it to
        switch off a storage on purpose.

        When the driver of a storage cannot access its files, for example
        because a cloud service is not available, TYPO3 marks the storage as
        offline as well. This state lasts until the caches are flushed. It
        does not change the file.

        ..  warning::
            This does not protect your files if the base path of the storage
            is within your web root, or if a cloud service makes them public.
            Anyone who knows the path to a file can still load it.

    ..  confval:: autoExtractMetadata
        :name: fal-storage-autoextractmetadata
        :type: bool
        :default: `true`

        If `true`, TYPO3 extracts the metadata of a file when it adds the file
        to the storage, see
        `metadata extractors <https://docs.typo3.org/permalink/t3coreapi:fal-metadata-extractors>`_.

    ..  confval:: processingFolder
        :name: fal-storage-processingfolder
        :type: string
        :default: :file:`_processed_/` in the storage

        The folder for
        `processed files <https://docs.typo3.org/permalink/t3coreapi:fal-architecture-folders-processed-files>`_,
        such as resized images. A combined identifier such as
        `2:/processed/` puts them into another storage.

    ..  confval:: allowedFileExtensions
        :name: fal-storage-allowedfileextensions
        :type: list of strings
        :default: empty

        The file extensions that a file needs to enter the storage, for
        example `[jpg, jpeg, png, webp]`. A comma-separated string such as
        `'pdf,docx,xlsx'` works as well. An empty list allows every file
        extension, see
        `Restricting the file extensions of a file storage <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages-file-extensions>`_.

        ..  versionadded:: 15.0
            :changelog: feature-103594-1791966674

    ..  confval:: configuration
        :name: fal-storage-configuration
        :type: map
        :default: empty

        The options of the driver. For the `Local` driver, see
        `Options of the Local driver <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages-local>`_.
        A driver of an extension documents its own options.


..  _fal-administration-storages-local:

Options of the Local driver for file storages
=============================================

..  confval-menu::
    :name: fal-storage-local-options
    :display: table
    :type:

    ..  confval:: basePath
        :name: fal-storage-local-basepath
        :type: string
        :required: true

        The directory of the storage. The driver uses an absolute path as it
        is. A relative path starts at the project path, the directory with the
        :file:`composer.json` file. In a Composer-based installation,
        `public/fileadmin/` is the directory :file:`fileadmin/` in the web
        root. `storage/private/` is a directory next to :path:`config/` and
        :path:`var/`, outside the web root. In classic mode, the project path
        and the web root are the same directory.

        A storage with a directory below the web root has public URLs. A
        storage outside the web root needs `baseUri`, or TYPO3 delivers its
        files through the file dump script, see `public`.

        A directory outside the project path must be allowed in
        `$GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath'] <https://docs.typo3.org/permalink/t3coreapi:typo3confvars-be-lockrootpath>`_.
        Otherwise the storage is offline.

        ..  literalinclude:: _additional.php
            :caption: config/system/additional.php

        See also the
        `security bulletin "Path Traversal in TYPO3 File Abstraction Layer Storages" <https://typo3.org/security/advisory/typo3-core-sa-2024-001>`__.

        ..  versionchanged:: 15.0
            :changelog: feature-110762-1789250000

            Before, a relative path started at the web root and needed the
            option `pathType: relative`. A path with this option still starts
            at the web root.

    ..  confval:: baseUri
        :name: fal-storage-local-baseuri
        :type: string

        The URL of the base path, for example when another host delivers the
        files. TYPO3 uses it only for a public storage.

    ..  confval:: caseSensitive
        :name: fal-storage-local-casesensitive
        :type: bool

        Whether the file system distinguishes upper and lower case in file
        names. If the option is not set, the driver detects it.


..  _fal-administration-storages-file-extensions:

Restricting the file extensions of a file storage
=================================================

The option `allowedFileExtensions` limits which files can enter a storage, for
example a storage for images:

..  literalinclude:: _file-storages-images.yaml
    :caption: config/system/file-storages.yaml (excerpt)

:php-short:`\TYPO3\CMS\Core\Resource\ResourceStorage` checks the list for each
operation that puts a file into the storage or gives a file a new extension:

*   uploading, adding, and creating a file, also replacing a file by an upload
*   copying a file, or a folder with all the visible files it contains
*   moving a file from another storage
*   renaming or moving a file to another extension

A rejected operation throws an
:php-short:`\TYPO3\CMS\Core\Resource\Exception\IllegalFileExtensionException`.
The backend shows it as a message, and it shows the allowed file extensions
where users add files.

The list does not affect a file that is already in the storage, as long as the
file keeps its extension. Users can rename it, move it within the storage,
delete it, and replace its content without an upload. A copy of the file is a
new file, so TYPO3 rejects it. TYPO3 does not check processed files, such as
thumbnails.

The list only guards the operations of
:php-short:`\TYPO3\CMS\Core\Resource\ResourceStorage`. It is not a filter.
Files that reach the storage another way, for example by FTP or a deployment,
are indexed, listed, and referenced like any other file. Enforce the
restriction where these files are written.

The list never allows more than the global settings do. TYPO3 checks
`$GLOBALS['TYPO3_CONF_VARS']['BE']['fileDenyPattern'] <https://docs.typo3.org/permalink/t3coreapi:typo3confvars-be-filedenypattern>`_
first. The global list of allowed file extensions and the check of the MIME
type apply as before, see
`Security and consistency checks <https://docs.typo3.org/permalink/t3coreapi:fal-using-fal-examples-file-folder-add-file-security>`_.

To restrict a folder of a storage for some backend users only, use the field
of the file mount, see
`Restricting the file extensions of a file mount <https://docs.typo3.org/permalink/t3coreapi:access-filemounts-file-extensions>`_.


..  _fal-administration-storages-placeholders:

Environment variables and imports in `file-storages.yaml`
=========================================================

TYPO3 reads the file with its
`YAML loader <https://docs.typo3.org/permalink/t3coreapi:yamlfileloader>`_.
Like in the site configuration, you can use `%env()%` placeholders and
`imports`. Put values that differ between
environments into environment variables, for example credentials of a cloud
service or an absolute path:

..  literalinclude:: _file-storages-env.yaml
    :caption: config/system/file-storages.yaml (excerpt)

TYPO3 keeps the evaluated file in the `core` cache. A change of the file takes
effect at once. After you change an imported file or an environment variable,
flush the caches.


..  _fal-administration-storages-errors:

Errors in `file-storages.yaml`
==============================

TYPO3 reads the file in a tolerant way, so that one mistake does not stop
every file access of the site. It logs each problem:

*   TYPO3 ignores an unknown option of a storage.
*   A storage with an invalid value, or with a placeholder for an environment
    variable that is not set, is offline.
*   If several storages are marked as default, the first of them is the
    default storage. If none is marked, the first storage is.

A YAML syntax error, an identifier that is not a positive integer, or a
storage that is not a map of options stops all file access.


..  _fal-administration-storages-code:

Changing file storages from PHP code
====================================

In a console command or in setup code,
:php-short:`\TYPO3\CMS\Core\Resource\Configuration\FileStorageConfigurationWriter`
adds, replaces, and removes storages in the file. It checks the result and
keeps `%env()%` placeholders of the storages it does not change. Do not write
the file during a web request: it fails on a read-only file system and
differs between several web servers.

To add a local directory as a storage, call
:php-short:`\TYPO3\CMS\Core\Resource\StorageRepository->addLocalStorage()`.
It returns the identifier of the new storage and never uses an identifier
that is still referenced.

To read the normalized options of all storages, use
:php-short:`\TYPO3\CMS\Core\Resource\Configuration\FileStorageConfiguration`.

After each change of the file, TYPO3 dispatches the PSR-14 event
`FileStorageConfigurationChangedEvent <https://docs.typo3.org/permalink/t3coreapi:filestorageconfigurationchangedevent>`_.
