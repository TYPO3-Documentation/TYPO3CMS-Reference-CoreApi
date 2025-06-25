:navigation-title: File permissions

..  include:: /Includes.rst.txt
..  index:: pair: Security guidelines; File permissions
..  _security-file-directory-permissions:

================================================
Secure file permissions (operating system level)
================================================

..  figure:: /Images/ManualScreenshots/AdminTools/DirectoryStatus.png
    :alt: Output of the directory status with missing writing permissions for folder public

    The tool "Directory Status" in :guilabel:`Admin Tools > Environment` displays warnings about missing write permissions

This chapter explains how to securely configure file and directory permissions
at the operating system level for TYPO3 installations. It focuses on who can
read and write to files on disk.

To learn how to prevent public access via the web server, see
:ref:`Restrict public file access in the web server <security-restrict-access-server-level>`.

A common risk is allowing one user to read or modify another client's files—
especially in shared environments. A misconfigured server where all sites run
as the same user can allow cross-site scripting, data theft, or manipulation of
TYPO3 files such as :file:`config/system/settings.php`.

TYPO3 can be installed either in classic (non-Composer) mode or using a
Composer-based setup. Each approach requires a slightly different file
permission strategy.

..  contents:: Table of contents

.. _file-permissions-composer:

Composer-based installations
============================

In Composer-based TYPO3 installations, the document root is typically a
:file:`public/` directory. Core files, extensions, and the :file:`vendor/` directory
reside outside the web root, improving security by design.

**Recommendations:**

-   Set the web server's document root to :file:`public/` only.
-   Grant the web server user write access to:

    -   :file:`public/fileadmin/`
    -   :file:`public/typo3temp/`
    -   :file:`var/` (used for cache, logs, sessions, etc.)

-   The :file:`public/_assets/` directory must be **readable** by the web server.
    It is generated during deployment or Composer operations and should not be
    writable at runtime.
-   The :file:`config/` directory should be **read-only** for the web server in
    production environments **unless** certain TYPO3 features require write access:

    -   To allow changing site configurations via the backend, the web server needs
        write access to :file:`config/sites/`.
    -   To allow system maintainers to update settings via the Admin Tools module,
        the web server needs write access to :file:`config/system/settings.php`.

-   Keep :file:`vendor/`, :file:`composer.json`, and :file:`public/index.php`
    read-only for the web server.


.. _file-permissions-classic:

Classic-mode installations
==========================

In classic TYPO3 installations, all TYPO3 files (Core, extensions, uploads) are located
inside the web server's document root. This increases the risk of file exposure or
accidental manipulation, making secure filesystem permissions essential.

**Recommendations:**

-   On shared hosting, ensure each virtual host runs under a separate system user.
-   Revoke write access for the web server user to the TYPO3 core source directories,
    especially :file:`typo3/sysext/` (core system extensions) and :file:`vendor/`
-   Allow write access only to:

    -   :file:`fileadmin/`
    -   :file:`typo3temp/`

    - Only grant write access to subdirectories within :file:`typo3conf/` as needed:

    -   :file:`typo3conf/ext/`, :file:`typo3conf/autoload/`, :file:`typo3conf/PackageStates.php`:
        Required if you want to install or update extensions using the Extension Manager.

    -   :file:`typo3conf/sites/`: Stores site configuration; writable if managing sites
        through the backend.

    -   :file:`typo3conf/system/`: Stores system settings; writable if modifying settings
        via the Admin Tools → Settings module.

    -   :file:`typo3conf/l10n/`: Must be writable to allow downloading or updating
        translation files via the Admin Tools.

-   The rest of the :file:`typo3conf/` directory should remain read-only to the
    web server where possible.

-   On UNIX/Linux systems, enforce appropriate user/group ownership and permissions
    (e.g., `chmod`, `chown`).

..  _security-check-permissions-admin-tools:

Check file permissions in the backend
=====================================

TYPO3 provides a built-in backend tool to verify directory permissions.

You can access it via:

:guilabel:`Admin Tools > Environment > Directory Status`

This view lists key directories such as :file:`fileadmin/`, :file:`config/`,
:file:`var/`, and others, and shows whether the current web server user has
the recommend level of access.

Use this tool to confirm that required directories are writable after
deployment or when debugging permission-related issues.
