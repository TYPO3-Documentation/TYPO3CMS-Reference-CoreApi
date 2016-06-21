.. include:: ../../Includes.txt


.. _typo3-directory-structure:

TYPO3 directory structure
^^^^^^^^^^^^^^^^^^^^^^^^^

By default a TYPO3 installation consists of the following
directories:


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Directory
         Directory

   Description
         Description


.. container:: table-row

   Directory
         :code:`fileadmin/`

   Description
         This is a directory in which users can store files. Typically images,
         PDFs or HTML files appear in this directory and/or its subdirectories.

         Often this directory is used for downloadable files. This directory is
         the only one accessible using the TYPO3 :code:`File module`.


.. container:: table-row

   Directory
         :code:`typo3/`

   Description
         TYPO3 Backend directory. This directory contains most of the files
         coming with the TYPO3 Core. The files are arranged logically in the
         different system extensions in the :code:`sysext/` directory,
         according to the application area of the particular file. For example,
         the ":code:`frontend`" extension amongst other things contains the
         "TypoScript library", the code for generating the Frontend website. In
         each system extension the PHP files are located in the folder
         :code:`Classes/`. Additionally, :code:`typo3/` can contain some global
         extensions in the :code:`ext/` directory (which is not used by the
         TYPO3 core itself).


.. container:: table-row

   Directory
         :code:`typo3conf/`

   Description
         TYPO3 configuration directory


.. container:: table-row

   Directory
         :code:`typo3conf/ext/`

   Description
         Directory for TYPO3 extensions. Each subdirectory contains one extension.


.. container:: table-row

   Directory
         :code:`typo3temp/`

   Description
         Directory for temporary files. It contains subdirectories for
         temporary files of extensions and TYPO3 components.


.. container:: table-row

   Directory
         :code:`uploads/`

   Description
         Default upload directory. Extensions can use the :code:`uploadfolder`
         setting in :code:`ext_emconf.php` to specify a subdirectory of
         :code:`uploads/` for this extension.


.. ###### END~OF~TABLE ######


This structure is default for a TYPO3 installation. Other non-TYPO3
applications can add their own directories.

