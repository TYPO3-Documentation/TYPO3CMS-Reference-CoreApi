

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


TYPO3 directory structure
^^^^^^^^^^^^^^^^^^^^^^^^^

By default a TYPO3 installation consists from the following
directories:


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Directory
         Directory
   
   Description
         Description


.. container:: table-row

   Directory
         fileadmin/
   
   Description
         This is a directory where users can store files. Typically images or
         HTML files appear in this directory and/or its subdirectories.
         
         Often this directory is used for downloadable files. This directory is
         the only one accessible using the TYPO3 Filemodule.


.. container:: table-row

   Directory
         t3lib/
   
   Description
         TYPO3 library directory


.. container:: table-row

   Directory
         typo3/
   
   Description
         TYPO3 Backend directory. This directory contains the Backend files.
         
         Additionally, it contains some extensions in the ext/(not used by the
         TYPO3 core) and sysext/directories. For example, the " :code:`cms` "
         extension contains the code for generating the Frontend website.


.. container:: table-row

   Directory
         typo3conf/
   
   Description
         TYPO3 configuration directory


.. container:: table-row

   Directory
         typo3conf/ext/
   
   Description
         Directory for TYPO3 extensions


.. container:: table-row

   Directory
         typo3temp/
   
   Description
         Directory for temporary files. It contains subdirectories for
         temporary files of extensions and TYPO3 components.


.. container:: table-row

   Directory
         uploads/
   
   Description
         Default upload directory. For example, all images uploaded with “Image
         with text” content element will be in this directory. Extensions can
         use uploadfoldersetting in the ext\_emconf.phpto specify extension's
         own upload directory inside this directory.


.. ###### END~OF~TABLE ######


This structure is default for TYPO3 installation. Other non-TYPO3
applications can add their own directories.

