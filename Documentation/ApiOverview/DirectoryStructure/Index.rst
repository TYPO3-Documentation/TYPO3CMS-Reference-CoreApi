.. include:: /Includes.rst.txt
.. index::
   ! Path
   see: Directory structure; Path
.. _directory-structure:

===================
Directory structure
===================

By default a TYPO3 installation consists of a structure of
main directories within the web server document root. You will find
this structure to be almost always like that. Depending on the installation
variant you choose however, this may be slightly different. For instance,
it is possible to have all PHP files except the entry points :file:`index.php`
within the Composer-managed :file:`vendor/` directory, outside of the document
root. This setup however did not fully settle yet, and is not documented
here in detail. So, if you look at "casual" TYPO3 installations, you will
almost always find the directory structure as outlined below.

Also see :ref:`Environment` for further information, especially how to retrieve
the paths within PHP code.

.. t3-field-list-table::
  :header-rows: 1

  - :Directory,20: Directory
    :Description,80: Description

  - :Directory: :file:`_assets/`
    :Description:
      This directory includes symlinks to resources of extensions, as consequence
      of this and further structure changes the folder :file:`typo3conf/ext/` is
      not created or used anymore.
      So all files like CSS, JavaScript, Icons, Fonts, Images, etc. of extensions
      are not linked anymore directly to the extension folders but to the directory
      :file:`_assets/`.

      .. note::
        This directory :file:`_assets/` and the related changes depend on the
        composer-plugin `typo3/cms-composer-installers` in version 4+.
        Previous versions of `typo3/cms-composer-installers` used the classical
        directory structure with :file:`typo3conf/ext/` for extensions.

        The composer-plugin `typo3/cms-composer-installers` in version 4+ was created
        for TYPO3 Version 12 and backported for default but **optional usage**
        in TYPO3 Version 11. Therefore the version has to be explicitely set (decreased)
        if the classical directory structure shall be used:

        .. code-block:: none

           "typo3/cms-composer-installers": "^3.1",

  - :Directory: :file:`fileadmin/`
    :Description:
      This is a directory in which editors store files. Typically images,
      PDFs or video files appear in this directory and/or its subdirectories.

      Note this is only the default editor's file storage. This directory
      is handled via the :ref:`FAL API <fal>` internally, there may be
      further storage locations configured outside of :file:`fileadmin/`, even
      pointing to different servers or using 3rd party digital asset management
      systems.

      .. note::
        Note this directory is meant for editors! Integrators should
        *not* locate frontend website layout related files in here: Storing
        HTML templates, logos, Css and similar files used to build the website
        layout in here is considered bad practice. Integrators should locate
        and ship these files within a project specific extension.

  - :Directory: :file:`typo3/`
    :Description:
      TYPO3 Backend directory. This directory contains most of the files
      coming with the TYPO3 Core. The files are arranged logically in the
      different system extensions in the :file:`sysext/` directory,
      according to the application area of the particular file. For example,
      the ":code:`frontend`" extension amongst other things contains the
      "TypoScript library", the code for generating the Frontend website. In
      each system extension the PHP files are located in the folder
      :file:`Classes/`. See :ref:`extension files locations <extension-files-locations>`
      for more information on how single extensions are structured.

  - :Directory: :ref:`Environment-config-path` either :file:`typo3conf/` or :file:`config/`
    :Description:
      TYPO3 configuration directory. This directory contains installation wide
      configuration.

      Amongst others, this directory contains the files :file:`LocalConfiguration.php` and
      :file:`AdditionalConfiguration.php`. See chapter
      :ref:`Configuration files <configuration-files>` for details.

  - :Directory: :file:`typo3conf/ext/`
    :Description:
      Directory for local TYPO3 extensions. Each subdirectory contains one extension.

  - :Directory: :ref:`Environment-labels-path` either :file:`typo3conf/l10n` or :file:`var/labels`
    :Description:
      Directory for extension localisations. Contains all downloaded translation
      files.

  - :Directory: :file:`typo3temp/`
    :Description:
      Directory for temporary files. It contains subdirectories (see below)
      for temporary files of extensions and TYPO3 components.

  - :Directory: :file:`typo3temp/assets/`
    :Description:
      Directory for temporary files that should be public available
      (e.g. generated images).

  - :Directory: :file:`typo3temp/var/`
    :Description:
      Directory for temporary files that contains private files (e.g. cached
      Fluid templates) and should not be publicly available.
      See also :ref:`Environment-configuring-paths` for a more detailed description.
