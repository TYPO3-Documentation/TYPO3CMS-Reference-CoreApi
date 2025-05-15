:navigation-title: Wget and Symlinks

..  include:: /Includes.rst.txt
..  index:: Classic mode installation; Wget and symlinks

..  _classic-symlink-installation:

===================================================================
Classic TYPO3 installation using symlinks on windows
===================================================================

..  note::
    These instructions describe how to install TYPO3 in classic mode.
    This approach makes updates, deployment, and maintenance more difficult
    compared to using Composer.

    If possible, use the dependency manager `Composer <https://getcomposer.org/>`_.
    See :ref:`Composer-based installation instructions <install>`.

This guide explains how to install TYPO3 manually on a Linux/Unix or Windows
server using a `.tar.gz` or `.zip` archive. Shell access is required to
create symbolic links, which makes future upgrades easier.

Prerequisites:

-   Shell (SSH) access to the server.
    If you do not have shell access, see
    `Manual TYPO3 installation using .zip or .tar.gz archive
    <https://docs.typo3.org/permalink/t3coreapi:manual-archive-installation>`_.
-   Basic server tools such as `wget` or `curl`, `tar`, and `ln` or `mklink`
-   A web server such as **Apache** or **nginx**
-   A PHP version and required extensions supported by the TYPO3 version you
    plan to install. See `System requirements
    <https://docs.typo3.org/permalink/t3coreapi:system-requirements>`_.
-   A database such as MySQL or MariaDB
-   A web browser to run the installation wizard

You can install TYPO3 on any server that meets the `system requirements
<https://docs.typo3.org/permalink/t3coreapi:system-requirements>`_,
including a suitable PHP version and database.

You can download TYPO3 either via a web browser from https://get.typo3.org/
or directly on the server using `wget` or `curl`.

..  todo::
    Document recommended server tools like SSH, cron jobs, etc., and link to
    that chapter when available.

To ensure that future upgrades can be performed smoothly and with minimal
downtime, it is highly recommended to use symbolic links.

..  contents::

..  _classic-symlink-installation-linux:
..  _legacyinstallation-linux:

Installing TYPO3 on a Linux or Unix server
==========================================

..  _classic-symlink-installation-linux-download:

Download the TYPO3 source package using wget
--------------------------------------------

Download the TYPO3 source package from `https://get.typo3.org/
<https://get.typo3.org/>`_:

..  code-block:: bash
    :caption: /var/www/site/$

    wget --content-disposition https://get.typo3.org/13

Ensure that the package is placed one level above the web server's document root.

..  note::
    Make sure to check the :ref:`release_integrity` of the downloaded files.

..  _classic-symlink-installation-linux-untar:

Unpack the TYPO3 package using tar
----------------------------------

Unpack the :file:`typo3_src-13.4.y.tar.gz`:

..  code-block:: bash
    :caption: /var/www/site/$

    tar xzf typo3_src-13.4.y.tar.gz

The `x` and `y` placeholders in the folder name will be replaced with the
latest minor and patch version numbers of TYPO3.

..  _classic-symlink-installation-linux-ln:

Create the required symlinks using ln
-------------------------------------

Create the following symlinks in your document root:

..  code-block:: bash
    :caption: /var/www/site/$

    cd public
    ln -s ../typo3_src-13.4.y typo3_src
    ln -s typo3_src/index.php index.php
    ln -s typo3_src/typo3 typo3

..  important::
    Make sure to upload the entire TYPO3 source directory, including the
    :path:`vendor` directory. Missing this directory will result in missing
    dependencies.

..  _classic-symlink-installation-linux-directory:

Expected directory structure
----------------------------

After creating the symlinks, your directory structure should look like this:

..  directory-tree::

    *   :path:`typo3_src-13.4.y/`
    *   :path:`public/`
        *   :path:`typo3_src -> ../typo3_src-13.4.y/`
        *   :path:`typo3 -> typo3_src/typo3/`
        *   :file:`index.php -> typo3_src/index.php`
