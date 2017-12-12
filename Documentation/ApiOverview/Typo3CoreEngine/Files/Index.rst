.. include:: ../../../Includes.txt






.. _file-functions:

File functions basics
^^^^^^^^^^^^^^^^^^^^^

File operations in the TCE are handled by the class
:code:`\TYPO3\CMS\Core\Utility\File\ExtendedFileUtility`
which extends :code:`\TYPO3\CMS\Core\Utility\File\BasicFileUtility`.
The instructions for file manipulation are passed to this class as a
multidimensional array.


.. _tce-files-array:

Files Array
"""""""""""

Syntax::

   $file[ command ][ index ][ key ] = value

Description of keywords in syntax:

.. t3-field-list-table::
 :header-rows: 1

 - :Key,20: Key
   :Type,20: Data type
   :Description,60: Description


 - :Key:
         command
   :Type:
         string (command keyword)
   :Description:
         The command type you want to execute.

         *See table below for :ref:`command keywords, keys and values<tce-file-keywords>`*


 - :Key:
         index
   :Type:
         integer
   :Description:
         Integer index in the array which separates multiple commands of the
         same type.


 - :Key:
         key
   :Type:
         string
   :Description:
         Depending on the command type. The keys will carry the information
         needed to perform the action. Typically a "target" key is used to
         point to the target directory or file while a "data" key carries the
         data.

         *See table below for :ref:`command keywords, keys and values<tce-file-keywords>`*


 - :Key:
         value
   :Type:
         string
   :Description:
         The value for the command

         *See table below for :ref:`command keywords, keys and values<tce-file-keywords>`*


.. _tce-file-keywords:

Command keywords and values
~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. t3-field-list-table::
 :header-rows: 1

 - :Command,20: Command
   :Keys,20: Keys
   :Value,60: Value


 - :Command:
         delete
   :Keys:
         "data"
   :Value:
         "data" = Absolute path to the file/folder to delete


 - :Command:
         copy
   :Keys:
         "data"

         "target"

         "altName"
   :Value:
         "data" = Absolute path to the file/folder to copy

         "target" = Absolute path to the folder to copy to (destination)

         "altName" = (boolean): If set, a new filename is made by appending
         numbers/unique-string in case the target already exists.


 - :Command:
         move
   :Keys:
         "data"

         "target"

         "altName"
   :Value:
         (Exactly like copy, just replace the word "copy" with "move")


 - :Command:
         rename
   :Keys:
         "data"

         "target"
   :Value:
         "data" = New name, max 30 characters alphanumeric

         "target" = Absolute path to the target file/folder


 - :Command:
         newfolder
   :Keys:
         "data"

         "target"
   :Value:
         "data" = Folder name, max 30 characters alphanumeric

         "target" = Absolute path to the folder where to create it


 - :Command:
         newfile
   :Keys:
         "data"

         "target"
   :Value:
         "data" = New filename

         "target" = Absolute path to the folder where to create it


 - :Command:
         editfile
   :Keys:
         "data"

         "target"
   :Value:
         "data" = The new content

         "target" = Absolute path to the target file


 - :Command:
         upload
   :Keys:
         "data"

         "target"

         upload\_$id
   :Value:
         "data" = ID-number (points to the global var that holds the filename-
         ref (:code:`$_FILES["upload_" . $id]["name"]`).

         "target" = Absolute path to the target folder (destination)

         upload\_$id = File reference. $id must equal value of
         :code:`file[upload][...][data]`!

         See :code:`\TYPO3\CMS\Core\Utility\File\ExtendedFileUtility::func_upload()`.


 - :Command:
         unzip
   :Keys:
         "data"

         "target"
   :Value:
         "data" = Absolute path to the zip-file. (file extension must be "zip")

         "target" = The absolute path to the target folder (destination) (if
         not set, default is the same as the zip-file)

It is unlikely that you will need to use this internally in your
scripts like you will need :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`. It
is fairly uncommon to need the file manipulations in own scripts unless you
make a special application. Therefore the most typical usage of this API is
from :ref:`\TYPO3\CMS\Backend\Controller\File\FileController <tce-file-api>`
and the core scripts that are activated by the "File > List" module.

However, if needed, this is an example of how to initialize usage. It is taken
from :file:`ImportExportController.php`:

.. code-block:: php
   :linenos:

      // Initializing:
   $this->fileProcessor = GeneralUtility::makeInstance(ExtendedFileUtility::class);
   $this->fileProcessor->setActionPermissions();

   $this->fileProcessor->start($this->file);
   $this->fileProcessor->processData();

*Explanation:* Line 2 creates an instance of the class. Then the file operation
permissions are loaded from the user object in line 3. Finally, the file
command array is loaded in line 5 and internally additional configuration takes
place according to :php:`$GLOBALS['TYPO3_CONF_VARS']`!. In line 6 the command
map is executed.
