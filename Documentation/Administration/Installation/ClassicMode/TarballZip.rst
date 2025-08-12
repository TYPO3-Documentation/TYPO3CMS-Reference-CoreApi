:navigation-title: ZIP/Tarball

..  include:: /Includes.rst.txt
..  _manual-archive-installation:

========================================================
Classic TYPO3 installation using .zip or .tar.gz archive
========================================================

This guide explains how to install TYPO3 manually using FTP or a web hosting
control panel such as cPanel, without requiring command-line access.

Prerequisites:

-   A web server such as **Apache** or **nginx**
-   A PHP version and required extensions supported by the TYPO3 version you
    plan to install. See `System requirements
    <https://docs.typo3.org/permalink/t3coreapi:system-requirements>`_.
-   A database such as MySQL or MariaDB. See `System requirements for version requirements
    <https://docs.typo3.org/permalink/t3coreapi:system-requirements>`_.
-   FTP/SFTP access or web-based file manager (such as cPanel or Plesk)
-   A web browser to run the installation wizard

..  _manual-archive-download:

Download the TYPO3 package
==========================

-   Go to https://get.typo3.org
-   Select the TYPO3 version you want to install
-   Download the `.zip` package to your computer (this is recommended for
    most users)
-   Alternatively, download the `.tar.gz` package if your hosting environment
    supports extracting `.tar.gz` archives

..  _manual-archive-upload-extract:

Upload and extract the package
==============================

-   Open your FTP program or web-based file manager
-   Create a folder on your webspace where you want to install TYPO3, for
    example :path:`/public_html/typo3site`
-   Upload the TYPO3 `.zip` file (for example :file:`typo3_src-13.4.y.zip`) directly
    to this folder and extract it using the tools provided by your servers file manager.

    If your server does not offer an option to extract files,
    see :ref:`manual-archive-alternative-upload`
-   After extraction, you have a folder named something like
    :path:`typo3_src-13.4.15`. Move all files and folder contained from this
    folder into **the folder where your domain or
    subdomain’s document root points to**.

    This may be the root of your webspace (for example :path:`/public_html/`) or a
    subfolder (for example :path:`/public_html/typo3site/`), depending on how your
    domain or subdomain is configured.

..  _manual-archive-upload-extract-symlinks:

Best practice: use symlinks to TYPO3 source (optional)
------------------------------------------------------

On systems where you have shell access, the recommended method is to keep
TYPO3 source packages in a dedicated folder, such as
`/typo3_sources/typo3_src-13.4.y/`, and create symbolic links from your project
folder (webroot) to the required parts of the TYPO3 source.

This keeps your project clean and simplifies future upgrades.

For detailed instructions, refer to
`Classic TYPO3 installation (no Composer required)
<https://docs.typo3.org/permalink/t3coreapi:legacyinstallation>`_.

If shell access is not available, uploading and extracting the TYPO3 package
directly into the folder where your domain points to is the most practical
option.

..  _manual-archive-alternative-upload:

Alternative: upload extracted files
-----------------------------------

If your control panel does not provide an option to extract `.zip` or `.tar`
files:

-   Extract the archive on your local computer
-   Upload all extracted files and folders to your installation folder using
    your FTP program
-   Ensure you upload the contents only, not the containing folder itself

..  _manual-archive-database:

Create a database
=================

-   Log in to your hosting control panel (such as cPanel or Plesk)
-   Create a new database (MySQL or MariaDB) and a user, and assign the user to
    the database with full privileges
-   Make a note of the database name, username, password, server and port (usually 3306) for later use

..  _manual-archive-completion:

Run the installation wizard and complete the installation
=========================================================

In the next steps you will use the installation wizard to connect the database,
create additional required folders, create an administrator and chose or create
a site package / theme:

..  seealso::

    :ref:`classic-installation-wizard`
