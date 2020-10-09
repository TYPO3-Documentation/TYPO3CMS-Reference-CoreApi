.. include:: ../../Includes.txt

.. _directory-structure:

===================
Directory Structure
===================

By default a TYPO3 installation consists of a structure of
main directories within the web server document root. You will find
this structure to be almost always like that. Depending on the installation
variant you choose however, this may be slightly different. For instance,
it is possible to have all PHP files except the entry points :file:`index.php`
within the composer managed :file:`vendor/` directory, outside of the document
root. This setup however did not fully settle yet, and is not documented
here in detail. So, if you look at "casual" TYPO3 installations, you will
almost always find the directory structure as outlined below.

Also see :ref:`Environment` for further information, especially how to retrieve
the paths within PHP code.

.. t3-field-list-table::
  :header-rows: 1

  - :Directory,20: Directory
    :Description,80: Description

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

      The most important file within this folder is
      :file:`LocalConfiguration.php`. This one contains local settings of the
      main global PHP array :php:`$GLOBALS['TYPO3_CONF_VARS`], crucial settings
      like database connect credentials are in here. The file is managed by the
      Install Tool and the Extension Manager and the content should not be
      managed manually since Extension Manager or Install Tool may override
      manually changed settings again.

      The file :file:`LocalConfiguration.php` can be enriched by
      :file:`AdditionalConfiguration.php` which is never touched by TYPO3
      internal management tools. Be aware that having settings within
      :file:`AdditionalConfiguration.php` may prevent the system from doing
      automatic upgrades and should be used with care and only if you know what
      you are doing.


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
