:navigation-title: Classic mode

..  include:: /Includes.rst.txt
..  index:: Classic mode installation

..  _classic-installation:
..  _legacyinstallation:

======================================================
Classic mode TYPO3 installation (No Composer required)
======================================================

This installation method includes access to the `TYPO3 Extension Repository (TER) <https://extensions.typo3.org>`_ via a regular backend module. It is ideal for managed hosting, automated updates by the hosting provider, and simpler setups. It is also well-suited for beginners, due to the GUI-based extension handling. Consider :ref:`installing TYPO3 with Composer <installation-composer>`, if you value flexibility in dependency management, integration with version control, and easier environment automation. :ref:`Migrating a TYPO3 project to Composer <migratetocomposer>` is possible later, but takes effort and means restructuring the project.

There are two installation methods for a Classic mode TYPO3 installation.
If you have shell (SSH) access we recommend using `wget and
symlinks <https://docs.typo3.org/permalink/t3coreapi:classic-symlink-installation>`_.

If you only have access via FTP[1]_ or the file manager of your hosting provider, use
a `.zip or .tar.gz archive <https://docs.typo3.org/permalink/t3coreapi:manual-archive-installation>`_.

Choose one of the two methods:

..  card-grid::
    :columns: 1
    :columns-md: 3
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: `.zip or .tar.gz archive <https://docs.typo3.org/permalink/t3coreapi:manual-archive-installation>`_

        Prerequisites:

        -   A web server with PHP and database support
        -   FTP/SFTP access or web-based file manager (such as cPanel or Plesk)
        -   A web browser to run the installation wizard

    ..  card:: `wget and symlinks <https://docs.typo3.org/permalink/t3coreapi:classic-symlink-installation>`_

        Prerequisites:

        -   Shell (SSH) access to the server
        -   Basic server tools such as `wget` or `curl`, `tar`, and `ln` or `mklink`
        -   A web server with PHP and database support
        -   A web browser to run the installation wizard

    ..  card:: `Docker demo <https://docs.typo3.org/permalink/t3coreapi:classic-docker-installation>`_

        Prerequisites:

        -   Docker installed.
        -   Basic knowledge of Docker.
        -   A web browser to run the installation wizard

The next steps are needed no matter what installation method you chose in the
step before:

..  card-grid::
    :columns: 1
    :columns-md: 1
    :gap: 4
    :class: pb-4

    ..  card:: `Run the installation wizard <https://docs.typo3.org/permalink/t3coreapi:classic-installation-wizard>`_

        A web-based wizard guides you through the next steps, such as connecting
        your installation to the database, creating an administrator user, and
        setting up the file system.


    ..  card:: `Choose or create a site package (theme) <https://docs.typo3.org/permalink/t3start:creating-a-site-package>`_

        TYPO3 does not come with a default theme. In order to display any content
        on your website, you need to install or create a site package.

You can use the `Release integrity <https://docs.typo3.org/permalink/t3coreapi:release-integrity>`_
to test if the package you just downloaded is signed correctly.

..  toctree::
    :hidden:
    :titlesonly:

    TarballZip
    WgetSymlink
    Windows
    InstallationWizard
    ReleaseIntegrity

.. [1] In this documentation FTP is used as a synonym for file transfer, not specifically for the "File Transfer Protocol". 
       The reason is, that all communication with FTP, including username and password, is not encrypted. You should rather
       use protocols like SFTP, FTPS, SCP or RSYNC, where all communication is encrypted.
