:navigation-title: Windows servers

..  include:: /Includes.rst.txt
..  index:: Classic mode installation; Wget and symlinks; Windows

..  _classic-symlink-installation-windows:

==========================================================
Classic TYPO3 installation using symlinks on a Windows server
==========================================================

While it is possible to run TYPO3 on Windows, you might encounter Windows-
specific limitations or issues.

If you have the choice, we recommend using a **LAMP** stack (Linux, Apache,
MySQL or MariaDB, and PHP). You can then install TYPO3 using
`Composer <https://docs.typo3.org/permalink/t3coreapi:installation-composer>`_
(recommended) or in
`classic mode <https://docs.typo3.org/permalink/t3coreapi:classic-symlink-installation>`_.

For local development on Windows PCs, we recommend using **WSL2** or running
Linux-based environments using **Docker**.

..  contents::
    :local:
    :depth: 1

..  _classic-symlink-installation-windows-zip:

Download and extract the TYPO3 package using zip
================================================

Download the TYPO3 source package from `https://get.typo3.org/
<https://get.typo3.org/>`_ and extract the :file:`.zip` file on your server.

Ensure that the package is placed **one level above the web server's document
root**.

..  _classic-symlink-installation-windows-symlinks:

Create the required symlinks using mklink
=========================================

Use the Windows command shell (cmd.exe) with administrator rights to create the
following symlinks in your document root:

..  code-block:: bash
    :caption: C:\path\to\your\site\

    cd public
    mklink /d typo3_src ..\typo3_src-13.4.y
    mklink /d typo3 typo3_src\typo3
    mklink index.php typo3_src\index.php

..  note::
    On Windows, **mklink** requires administrator rights.

..  important::
    Make sure to include the entire TYPO3 source directory, including the
    :path:`vendor` directory. Missing this directory will result in missing
    dependencies.

Expected directory structure on Windows
=======================================

After creating the symlinks, your directory structure should look like this:

..  directory-tree::

    *   :path:`typo3_src-13.4.y\`
    *   :path:`public\`
        *   :path:`typo3_src -> ..\typo3_src-13.4.y\`
        *   :path:`typo3 -> typo3_src\\typo3\\`
        *   :file:`index.php -> typo3_src\index.php`

..  _classic-symlink-installation-completion:
..  _legacyinstallation-completion:

Run the installation wizard and complete the installation
=========================================================

In the next steps, you will use the installation wizard to:

-   Connect TYPO3 to your database
-   Create required folders
-   Create an administrator user
-   Choose or create a site package (theme)

..  seealso::

    :ref:`classic-installation-wizard`
