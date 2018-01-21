.. include:: ../../Includes.txt

.. _directory-structure:

Directory structure
^^^^^^^^^^^^^^^^^^^

By default a TYPO3 installation consists of a structure of
main directories within the web server document root. You will find
this structure to be almost always like that. Depending on the installation
variant you choose however, this may be slightly different. For instance,
it is possible to have all PHP files except the entry points :file:`index.php`
within the composer managed :file:`vendor/` directory, outside of the document
root. This setup however did not fully settle yet, and is not documented
here in detail. So, if you look at "casual" TYPO3 installations, you will
almost always find the directory structure as outlined below.


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
      different system extensions in the :code:`sysext/` directory,
      according to the application area of the particular file. For example,
      the ":code:`frontend`" extension amongst other things contains the
      "TypoScript library", the code for generating the Frontend website. In
      each system extension the PHP files are located in the folder
      :code:`Classes/`. See :ref:`extension files locations <extension-files-locations>`
      for more information on how single extensions are structured.


  - :Directory: :file:`typo3conf/`
    :Description:
      TYPO3 configuration directory. This directory contains local extensions
      in :file:`typo3conf/ext` folder. It may also contain a :file:`typo3conf/l10n`
      directory that holds localisation files for frontend or backend languages
      other than english.

      The most important file within :file:`typo3conf/` however is
      :file:`LocalConfiguration.php`. This one contains local settings of the main
      global PHP array :php:`$GLOBALS['TYPO3_CONF_VARS`], crucial settings like
      database connect credentials are in here. The file is managed by the install
      tool and the extension manager and the content should not be managed manually
      since extension manager or install tool may override manually changed settings
      again.

      The file :file:`LocalConfiguration.php` can be enriched by :file:`AdditionalConfiguration.php`
      which is never touched by TYPO3 internal management tools. Be aware that having
      settings within :file:`AdditionalConfiguration.php` may prevent the system from
      doing automatic upgrades and should be used with care and only if you know what
      you are doing.


  - :Directory: :file:`typo3conf/ext/`
    :Description:
      Directory for local TYPO3 extensions. Each subdirectory contains one extension.


  - :Directory: :file:`typo3conf/l10n`
    :Description:
      Directory for extension localisations. The "Language" module of the TYPO3 Backend
      manages this directory.


  - :Directory: :file:`typo3temp/`
    :Description:
      Directory for temporary files. It contains subdirectories for
      temporary files of extensions and TYPO3 components.
