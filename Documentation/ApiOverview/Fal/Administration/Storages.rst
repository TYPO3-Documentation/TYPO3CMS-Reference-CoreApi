..  include:: /Includes.rst.txt
..  index:: File abstraction layer; Storages
..  _fal-administration-storages:

=============
File storages
=============

:ref:`File storages <fal-architecture-components-storage>` can be administered
through the :guilabel:`Content > Records` module. They have a few properties which
deserve further explanation.

..  include:: /Images/AutomaticScreenshots/Fal/AdministrationFileStorageAccessTab.rst.txt

Is browsable?
    If this box is not checked, the storage will not be browsable by
    users via the :guilabel:`Media` module, nor via the link browser
    window.

Is publicly available?
    When this box is unchecked, the :php:`publicUrl` property of files is
    replaced by an eID call pointing to a file dumping script provided
    by the TYPO3 Core. The public URL looks something like
    :code:`index.php?eID=dumpFile&t=f&f=1230&token=135b17c52f5e718b7cc94e44186eb432e0cc6d2f`.
    Behind the scenes, the class :php:`\TYPO3\CMS\Core\Controller\FileDumpController`
    is invoked to manage the download. The class itself does not implement
    any access checks, but provides the PSR-14 event :ref:`ModifyFileDumpEvent`
    for doing so.

    ..  warning::
        This does not protect your files, if the configured storage folder is
        within your web root. They will still be available to anyone who knows
        the path to the file. To implement a strict access restriction, the
        storage must point to some path outside the web root. Alternatively, the
        folder it points to must contain web server restrictions to block direct
        access to the files it contains (for example, in an Apache
        :file:`.htaccess` file).

Is writable?
    When this box is unchecked, the storage is read-only.

Is online?
    A storage that is not online cannot be accessed in the backend. This flag is
    set automatically when files are not accessible (for example, when a
    third-party storage service is not available) and the underlying driver
    detects someone trying to access files in that storage.

    The important thing to note is that a storage must be turned online again
    manually.

    ..  warning::
        This does not protect your files, if the configured storage folder is
        within your web root or accessible via a third-party storage service
        which is publicly available. The files will still be available to anyone
        who knows the path to the file.

    Assuming that a web project is located in the directory
    :file:`/var/www/example.org/` (the "project root path" for Composer-based
    projects) and the publicly accessible directory is located at
    :file:`/var/www/example.org/public/` (the "public root path" or "web root"), accessing
    resources via the File Abstraction Layer component is limited to the
    mentioned directories and its sub-directories.

    To grant **additional** access to directories, they must be explicitly
    configured in the system settings of
    :ref:`$GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath'] <typo3ConfVars_be_lockRootPath>`
    - either using the Install Tool or according to deployment techniques.

    Example:

    ..  code-block:: php
        :caption: config/system/settings.php

        // Configure additional directories outside of the project's folder
        // as absolute paths
        $GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath'] = [
            ‘/var/shared/documents/’,
            ‘/var/shared/images/’,
        ];

    Storages that reference directories not explicitly granted will be marked as
    "offline" internally - no resources can be used in the website's frontend
    and backend context.

    See also the `security bulletin "Path Traversal in TYPO3 File Abstraction Layer Storages" <https://typo3.org/security/advisory/typo3-core-sa-2024-001>`__.
