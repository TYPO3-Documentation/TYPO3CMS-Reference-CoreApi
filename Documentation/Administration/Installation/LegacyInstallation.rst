:navigation-title: Legacy installation

..  include:: /Includes.rst.txt
..  index:: legacy installation

..  _legacyinstallation:

=========================
Legacy TYPO3 installation
=========================

On any webserver that full fills the `System Requirements <https://docs.typo3.org/permalink/t3coreapi:system-requirements>`_,
including a suitable PHP version and Database it is possible to install TYPO3
by downloading and unpacking a `.tar` or `.zip` file. You can download
this file from https://get.typo3.org/ or - if available - via wget or curl.

..  todo: Document recommended Server tools like ssh, cronjob, etc and link to
    that chapter

To ensure future updates can be achieved smoothly and without noticeable downtime
it is highly recommended to use symlinks.

..  tip::
    It is recommended to use the dependency manager `Composer <https://getcomposer.org/>`_
    if possible: See :ref:`Composer-based installation instructions <install>`.

..  warning::
    Do not change any files belonging to the TYPO3 Core source as it makes updating
    hard or impossible.

    You can use `Events and hooks <https://docs.typo3.org/permalink/t3coreapi:hooks>`_
    or third party extensions.

    If you absolutely have to change files in the Core source, keep a
    `.diff <https://en.wikipedia.org/wiki/Diff>`_ file so you can reapply the
    changes to the next TYPO3 version on update.

..  _legacyinstallation-linux:

Installing on a Linux/Unix server
=================================

#.  Download TYPO3's source package from `https://get.typo3.org/
    <https://get.typo3.org/>`_:

    ..  code-block:: bash
        :caption: /var/www/site/$

       wget --content-disposition https://get.typo3.org/12

    Ensure that the package is one level above the web server's document root.

    ..  note::
        Make sure to check the :ref:`release_integrity` of the downloaded files.


#.  Unpack the :file:`typo3_src-12.4.x.tar.gz`:

    ..  code-block:: bash
        :caption: /var/www/site/$

       tar xzf typo3_src-12.4.x.tar.gz

    Note that the `x` in the extracted folder will be replaced with the latest bugfix version of TYPO3.


#.  Create the following symlinks in the document root:


    ..  code-block:: bash
        :caption: /var/www/site/$

       cd public
       ln -s ../typo3_src-12.4.x typo3_src
       ln -s typo3_src/index.php index.php
       ln -s typo3_src/typo3 typo3

    ..  important::
        Make sure to upload the whole TYPO3 source directory including the
        :path:`vendor` directory, otherwise you will miss important dependencies.

#.  This will then create the following structure:

..  directory-tree::

    *   :path:`typo3_src-12.4.x/`
    *   :path:`public/`

        *   :path:`typo3_src -> ../typo3_src-12.4.x/`
        *   :path:`typo3 -> typo3_src/typo3/`
        *   :file:`index.php -> typo3_src/index.php`

..  _legacyinstallation-windows:

Installing on a Windows server
==============================

#.  Download TYPO3's source package from `https://get.typo3.org/
    <https://get.typo3.org/>`_ and extract the :file:`.zip` file on the web server.

    Ensure that the package is one level above the web server's document root.

#.  Use the shell to create the following symlinks in the document root:

    .. code-block:: bash
       :caption: /var/www/site/$

       cd public
       mklink /d typo3_src ..\typo3_src-12.4.x
       mklink /d typo3 typo3_src\typo3
       mklink index.php typo3_src\index.php

#.  This will then create the following structure:

    ..  directory-tree::

        *   :path:`typo3_src-12.4.x/`
        *   :path:`public/`

            *   :path:`typo3_src -> ../typo3_src-12.4.x/`
            *   :path:`typo3 -> typo3_src/typo3/`
            *   :file:`index.php -> typo3_src/index.php`

..  _legacyinstallation-completion:

Completing the installation
===========================

After the source package has been extracted and the symlinks created, continue from the
:ref:`Access TYPO3 via a web browser <install-access-typo3-via-a-web-browser>`
section of the :ref:`instructions for installing TYPO3 using Composer <install>` to
complete the installation.

..  toctree::
    :hidden:
    :titlesonly:

    ReleaseIntegrity
