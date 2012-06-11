

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


Files: t3lib\_extFileFunctions basics
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

File operations in the TCE are handled by the class
"t3lib\_extFileFunctions" which extends "t3lib\_basicFileFunctions".
The instructions for file manipulation are passed to this class as a
multidimensional array.


Files Array ($file):
""""""""""""""""""""

Syntax:

::

   $file[ command ][ index ][ key ] = value

Description of keywords in syntax:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Key
         Key
   
   Data type
         Data type
   
   Description
         Description


.. container:: table-row

   Key
         command
   
   Data type
         string (command keyword)
   
   Description
         The command type you want to execute.
         
         *See table below for command keywords, keys and values*


.. container:: table-row

   Key
         index
   
   Data type
         integer
   
   Description
         Integer index in the array which separates multiple commands of the
         same type.


.. container:: table-row

   Key
         key
   
   Data type
         string
   
   Description
         Depending on the command type. The keys will carry the information
         needed to perform the action. Typically a "target" key is used to
         point to the target directory or file while a "data" key carries the
         data.
         
         *See table below for command keywords, keys and values*


.. container:: table-row

   Key
         value
   
   Data type
         string
   
   Description
         The value for the command
         
         *See table below for command keywords, keys and values*


.. ###### END~OF~TABLE ######

Command keywords and values:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Command
         Command
   
   Keys
         Keys
   
   Value
         Value


.. container:: table-row

   Command
         delete
   
   Keys
         "data"
   
   Value
         "data" = Absolute path to the file/folder to delete


.. container:: table-row

   Command
         copy
   
   Keys
         "data"
         
         "target"
         
         "altName"
   
   Value
         "data" = Absolute path to the file/folder to copy
         
         "target" = Absolute path to the folder to copy to (destination)
         
         "altName" = (boolean): If set, a new filename is made by appending
         numbers/unique-string in case the target already exists.


.. container:: table-row

   Command
         move
   
   Keys
         "data"
         
         "target"
         
         "altName"
   
   Value
         (Exactly like copy, just replace the word "copy" with "move")


.. container:: table-row

   Command
         rename
   
   Keys
         "data"
         
         "target"
   
   Value
         "data" = New name, max 30 characters alphanumeric
         
         "target" = Absolute path to the target file/folder


.. container:: table-row

   Command
         newfolder
   
   Keys
         "data"
         
         "target"
   
   Value
         "data" = Folder name, max 30 characters alphanumeric
         
         "target" = Absolute path to the folder where to create it


.. container:: table-row

   Command
         newfile
   
   Keys
         "data"
         
         "target"
   
   Value
         "data" = New filename
         
         "target" = Absolute path to the folder where to create it


.. container:: table-row

   Command
         editfile
   
   Keys
         "data"
         
         "target"
   
   Value
         "data" = The new content
         
         "target" = Absolute path to the target file


.. container:: table-row

   Command
         upload
   
   Keys
         "data"
         
         "target"
         
         upload\_$id
   
   Value
         "data" = ID-number (points to the global var that holds the filename-
         ref ($GLOBALS["HTTP\_POST\_FILES"]["upload\_".$id]["name"])
         
         "target" = Absolute path to the target folder (destination)
         
         upload\_$id = File reference. $id must equal value of
         file[upload][...][data]!
         
         See t3lib\_t3lib\_extFileFunctions::func\_upload()


.. container:: table-row

   Command
         unzip
   
   Keys
         "data"
         
         "target"
   
   Value
         "data" = Absolute path to the zip-file. (fileextension must be "zip")
         
         "target" = The absolute path to the target folder (destination) (if
         not set, default is the same as the zip-file)


.. ###### END~OF~TABLE ######

It is unlikely that you will need to use this internally in your
scripts like you will need t3lib\_TCEmain. It is fairly uncommon to
need the file manipulations in own scripts unless you make a special
application. Therefore the most typical usage of this API is from
tce\_file.php and the core scripts that are activated by the "File >
List" module.

However, if you need it this is an example (taken from tce\_file.php)
of how to initialize the usage.

::

      1:     // Initializing:
      2: $this->fileProcessor = t3lib_div::makeInstance('t3lib_extFileFunctions');
      3: $this->fileProcessor->init($FILEMOUNTS, $TYPO3_CONF_VARS['BE']['fileExtensions']);
      4: $this->fileProcessor->init_actionPerms($BE_USER->user['fileoper_perms']);
      5: 
      6: $this->fileProcessor->start($this->file);
      7: $this->fileProcessor->processData();

Line 2 makes an instance of the class and line 3 initializes the
object with the filemounts of the current user and the array of
allow/deny file extensions in web-space and ftp-space (see below).
Then the file operation permissions are loaded from the user object in
line 4. Finally, the file command array is loaded in line 6 (and
internally additional configuration takes place from
$TYPO3\_CONF\_VARS!). In line 7 the command map is executed.


Web-space, FTP-space and $TYPO3\_CONF\_VARS['BE']['fileExtensions']
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

The control of file extensions goes in two categories. Webspace and
ftpspace. Webspace is folders accessible from a web browser (below
TYPO3\_DOCUMENT\_ROOT) and ftpspace is everything else.

The control is done like this: if an extension matches 'allow' then
the check returns true. If not and an extension matches 'deny' then
the check return false. If no match at all, returns true.

You list extensions comma-separated. If the value is a '\*' every
extension is matched. If no file extension, true is returned if
'allow' is '\*', false if 'deny' is '\*' and true if none of these
matches. This (default) configuration below accepts everything in
ftpspace and everything in webspace except php files:

::

   $TYPO3_CONF_VARS['BE']['fileExtensions'] = array (
       'webspace' => array('allow' => '', 'deny' => 'php'),
       'ftpspace' => array('allow' => '*', 'deny' => '')
   );

