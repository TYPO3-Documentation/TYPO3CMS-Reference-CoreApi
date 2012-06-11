

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


The "tce\_file.php" API
^^^^^^^^^^^^^^^^^^^^^^^

This script serves as the file administration part of the TYPO3 Core
Engine. It's a gateway for TCE (TYPO3 Core Engine) file-handling
through POST forms. It uses "t3lib\_extfilefunc" for the manipulation
of the files.

This script is used from the File > List module where you can rename,
create, delete etc. files and directories on the server.

You can send data to this file either as GET or POST vars where POST
takes precedence. The variable names you can use are:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   GP var name
         GP var name:
   
   Data type
         Data type
   
   Description
         Description


.. container:: table-row

   GP var name
         file
   
   Data type
         array
   
   Description
         Array of file operations. See previous information about
         "t3lib\_extFileFunctions"
         
         This could typically be a GET var like
         "&file[delete][0][data]=[absolute file path]" or a POST form field
         like "<input type="text" name="file[newfolder][0][data]"
         value=""/><input type="hidden" name="file[newfolder][0][target]"
         value="[absolute path to folder to create in]"/>"


.. container:: table-row

   GP var name
         redirect
   
   Data type
         string
   
   Description
         Redirect URL. Script will redirect to this location after performing
         operations.


.. container:: table-row

   GP var name
         CB
   
   Data type
         array
   
   Description
         Clipboard command array. May trigger changes in "file"


.. container:: table-row

   GP var name
         vC
   
   Data type
         string
   
   Description
         Verification code


.. container:: table-row

   GP var name
         overwriteExistingFiles
   
   Data type
         boolean
   
   Description
         If existing files should be overridden.


.. ###### END~OF~TABLE ######

