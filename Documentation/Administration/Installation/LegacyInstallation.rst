.. include:: /Includes.rst.txt

.. index:: legacy installation

.. _legacyinstallation:

===================
Legacy Installation
===================

..  warning::
    This guide details how TYPO3 can be installed without using Composer. This method of installation
    is now considered **out of date**, users are strongly encouraged to use the
    :ref:`Composer-based installation instructions <install>`.

Installing on a Unix Server
===========================

#. Download TYPO3's source package from `https://get.typo3.org/
   <https://get.typo3.org/>`_:

   .. code-block:: bash
      :caption: /var/www/site/$

      wget --content-disposition https://get.typo3.org/13

   Ensure that the package is one level above the web server's document root.

   .. note::
      Make sure to check the :ref:`release_integrity` of the downloaded files.


#. Unpack the :file:`typo3_src-13.x.y.tar.gz`:

   .. code-block:: bash
      :caption: /var/www/site/$

      tar xzf typo3_src-13.x.y.tar.gz

   Note that the `x` in the extracted folder will be replaced with the latest
   minor number and the `y` by the bugfix number of TYPO3.


#. Create the following symlinks in the document root:


   .. code-block:: bash
      :caption: /var/www/site/$

      mkdir public
      cd public
      ln -s ../typo3_src-13.x.y typo3_src
      ln -s typo3_src/index.php index.php
      ln -s typo3_src/typo3 typo3

   .. important::
      Make sure to upload the whole TYPO3 source directory including the
      :path:`vendor` directory, otherwise you will miss important dependencies.

#. This will then create the following structure:

..  directory-tree::

    *   :path:`typo3_src-13.x.y/`
    *   :path:`public/`

        *   :path:`typo3_src -> ../typo3_src-13.x.y/`
        *   :path:`typo3 -> typo3_src/typo3/`
        *   :file:`index.php -> typo3_src/index.php`

Installing on a Windows Server
==============================

#. Download TYPO3's source package from `https://get.typo3.org/
   <https://get.typo3.org/>`_ and extract the :file:`.zip` file on the web server.

   Ensure that the package is one level above the web server's document root.


#. Use the shell to create the following symlinks in the document root:

   .. code-block:: bash
      :caption: /var/www/site/$

      cd public
      mklink /d typo3_src ..\typo3_src-13.x.y
      mklink /d typo3 typo3_src\typo3
      mklink index.php typo3_src\index.php

#. This will then create the following structure:

    ..  directory-tree::

        *   :path:`typo3_src-13.x.y/`
        *   :path:`public/`

            *   :path:`typo3_src -> ../typo3_src-13.x.y/`
            *   :path:`typo3 -> typo3_src/typo3/`
            *   :file:`index.php -> typo3_src/index.php`


Completing The Installation
===========================

After the source package has been extracted and the symlinks created, continue from the
:ref:`Access TYPO3 via a web browser <install-access-typo3-via-a-web-browser>`
section of the :ref:`instructions for installing TYPO3 using Composer <install>` to
complete the installation.

.. toctree::
   :hidden:
   :titlesonly:

   ReleaseIntegrity
