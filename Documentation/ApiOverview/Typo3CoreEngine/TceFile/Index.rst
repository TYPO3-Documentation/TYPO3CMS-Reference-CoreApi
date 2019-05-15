.. include:: ../../../Includes.txt


.. _tce-file-api:

=======================
The "tce\_file.php" API
=======================

This script serves as the file administration part of the TYPO3 Core
Engine. It's a gateway for TCE (TYPO3 Core Engine) file-handling
through POST forms. It uses :code:`\TYPO3\CMS\Core\Utility\File\ExtendedFileUtility` for the manipulation
of the files.

This script is used from the File > List module where you can rename,
create, delete etc. files and directories on the server.

You can send data to this file either as GET or POST vars where POST
takes precedence. The variable names you can use are:

.. t3-field-list-table::
 :header-rows: 1

 - :Variable,20: GP var name
   :Type,20: Data type
   :Description,60: Description


 - :Variable:
         file
   :Type:
         array
   :Description:
         Array of file operations. See previous information about
         :ref:`basic file functions <file-functions>`.

         This could typically be a GET var like
         :code:`&file[delete][0][data]=[absolute file path]` or a POST form field
         like::

            "<input type="text" name="file[newfolder][0][data]" value=""/>
            <input type="hidden" name="file[newfolder][0][target]"
            value="[absolute path to folder to create in]"/>"


 - :Variable:
         redirect
   :Type:
         string
   :Description:
         Redirect URL. Script will redirect to this location after performing
         operations.


 - :Variable:
         CB
   :Type:
         array
   :Description:
         Clipboard command array. May trigger changes in "file"


 - :Variable:
         vC
   :Type:
         string
   :Description:
         Verification code


 - :Variable:
         overwriteExistingFiles
   :Type:
         boolean
   :Description:
         If existing files should be overridden.

