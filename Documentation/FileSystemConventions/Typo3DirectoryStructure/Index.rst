.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


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
         This is a directory in which users can store files. Typically images or
         HTML files appear in this directory and/or its subdirectories.

         Often this directory is used for downloadable files. This directory is
         the only one accessible using the TYPO3 :code:`File module`.


.. container:: table-row

   Directory
         :code:`t3lib/`

   Description
         TYPO3 library directory


.. container:: table-row

   Directory
         :code:`typo3/`

   Description
         TYPO3 Backend directory. This directory contains the Backend files.

         Additionally, it contains some extensions in the :code:`ext/` (not used by the
         TYPO3 core) and :code:`sysext/` directories. For example, the ":code:`frontend`"
         extension contains the code for generating the Frontend website.


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
         Default upload directory. For example, all images uploaded with the
         "Image with text" content element will be stored in this directory.
         Extensions can use the :code:`uploadfolder` setting in the :code:`ext\_emconf.php` to
         specify a subdirectory of :code:`uploads/` for this extension.


.. ###### END~OF~TABLE ######


This structure is default for a TYPO3 installation. Other non-TYPO3
applications can add their own directories.

