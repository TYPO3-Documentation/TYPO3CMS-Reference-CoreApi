.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt





.. _high-priority-functions:

High priority functions
^^^^^^^^^^^^^^^^^^^^^^^

The functions listed in this table are of high priority. Generally
they provide APIs to functionality which TYPO3 should always handle in
the same way. This will help you to code TYPO3 applications with less
bugs and greater compatibility with various system conditions it will
run under.

Remember, this list only serves to point out important functions! The
real documentation is found in the source scripts (and the
`online API <http://typo3.org/documentation/api/>`_). The comments given are only a supplement to that.


.. _high-priority-functions-general-utility:

\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility
"""""""""""""""""""""""""""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`_GP`

         :code:`\_GET`

         :code:`\_POST`
   :Comments:
         **Getting values from GET or POST vars**

         APIs for getting values in GET or POST variables with slashes stripped
         regardless of PHP environment. Always use these functions instead of
         direct access to :code:`$_GET` or :code:`$_POST`.

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::_GP($varname)` will give you the value of either the GET
         or POST variable with priority to POST if present. This is useful if
         you don't know whether a parameter is passed as GET or POST. Many
         scripts will use this function to read variables during initialization::

                // Setting GPvars:
            $this->file = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('file');
            $this->size = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('size');

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::_GET()` will give you GET vars. For security reasons you
         should use this if you know your parameters are passed as GET
         variables. This example gives you the whole :code:`$_GET` array::

            $params = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET();

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::_POST()` will give you POST variables. Works like
         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::_GET()`. For security reasons you should use this if you
         know your parameters are passed as POST variables.

         This example gives you the content of the POST variable
         TSFE\_ADMIN\_PANEL, for instance it could come from a form field like
         :code:`<input name="TSFE_ADMIN_PANEL[command]" ..../>` ::

            $input = \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('TSFE_ADMIN_PANEL');


 - :Function:
         :code:`makeInstance`
   :Comments:
         **Creating objects**

         Factory API for creating an instance of an object given a class name. This
         function makes sure the "XCLASS extension" principle can be used on
         (almost) any class in TYPO3. You **must** use this method when
         creating objects in TYPO3.

         Examples::

            	// Making an instance of class "\\TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser":
            $parseObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser');

            	// Make an object with arguments passed to the constructor:
            $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            	'My message text',
            	'Message Header',
            	\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING,
            	TRUE
            );


 - :Function:
         :code:`getIndpEnv`
   :Comments:
         **Environment-safe server and environment variables.**

         API function for delivery of system and environment variables on any
         web-server brand and server OS. Always use this API instead of
         :code:`$_ENV/$_SERVER` or :code:`getenv()` if possible.

         Examples::

            if (\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('HTTP_ACCEPT_LANGUAGE') == $test)...
            if (\TYPO3\CMS\Core\Utility\GeneralUtility::cmpIP(\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('REMOTE_ADDR'), $pcs[1]))...
            $prefix = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL');
            $redirectTo = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SITE_URL').$redirectTo;
            if (!\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SSL')) ...


 - :Function:
         :code:`loadTCA`
   :Comments:
         **Loading full table description into $TCA**

         If you want to access or change any part of the $TCA array for a table
         except the :code:`['ctrl']` part then you should call this function first. The
         :code:`$TCA` might not contain the full configuration for the table (depending
         on configuration of the table) and to make sure it is loaded, if it
         isn't already, you call this function.

         Examples of PHP code which traverses the ['columns'] part of an
         unknown table and loads the table before. ::

            \TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA($this->table);
            foreach ($TCA[$this->table]['columns'] as $fN) {
                $fieldListArr[] = $fN;
            }




 - :Function:
         :code:`getFileAbsFileName`

         :code:`validPathStr`

         :code:`isAbsPath`

         :code:`isAllowedAbsPath`

         :code:`fixWindowsFilePath`
   :Comments:
         **Evaluate files and directories for security reasons**

         When you allow references to files to be input from users there is
         always the risk that they try to cheat the system to include something
         else than intended. These functions makes it easy for you to evaluate
         filenames for validity before reading, writing or including them.

         Here the functions are described in order of importance:

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName()` - Returns the absolute filename
         of a relative reference, resolves the "EXT:" prefix (way of referring
         to files inside extensions) and checks that the file is inside the
         :code:`PATH_site` of the TYPO3 installation and implies a check with
         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::validPathStr()`. Returns false if checks failed. Does not
         check if the file exists. ::

            	// Getting absolute path of a temporary file
            $cacheFile = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('typo3temp/tempfile.tmp');
				// Include file if it exists:
            $file = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($fileRef);
            if (@is_file($file)) {
				include($file);
            }

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::validPathStr()` - Checks for malicious file paths.
         Returns true if no '//', '..' or '\\' is in the $theFile. This should
         make sure that the path is not pointing 'backwards' and further
         doesn't contain double/back slashes. ::

				// If the path is true and validates as a valid path string
            if ($path && \TYPO3\CMS\Core\Utility\GeneralUtility::validPathStr($path)) {
            	...
            }

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::isAbsPath()` - Checks if the input path is absolute or
         relative (detecting either '/' or 'x:/' as first part of string) and
         returns true if so. ::

            	// Returns relative filename for icon:
            if (\TYPO3\CMS\Core\Utility\GeneralUtility::isAbsPath($Ifilename)) {
            	$Ifilename = '../' . substr($Ifilename, strlen(PATH_site));
            }

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::isAllowedAbsPath()` - Returns true if the path is
         absolute, without backpath '..' and within the :code:`PATH_site` OR within
         the :code:`lockRootPath`. Contrary to :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName()` this
         function can also validate files in filemounts outside the web-root of
         the installation, but this is rarely used! ::

            if (@file_exists($path) && \TYPO3\CMS\Core\Utility\GeneralUtility::isAllowedAbsPath($path)) {
                $fI = pathinfo($path);
                     ....

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::fixWindowsFilePath()` - Fixes a path for Windows-
         backslashes and reduces double-slashes to single slashes


 - :Function:
         :code:`mkdir`
   :Comments:
         **Creates directory**

         One would think that creating directories is one thing you can do
         directly with PHP. Well, it turns out to be quite error-prone if it
         should be compatible with Windows servers and safe-mode at the same
         time. So TYPO3 offers a substitution function you should always use.

         Example::

            $root.=$dirParts . '/';
            if (!is_dir($extDirPath . $root))    {
                \TYPO3\CMS\Core\Utility\GeneralUtility::mkdir($extDirPath . $root);
                if (!@is_dir($extDirPath . $root))    {
                    return 'Error: The directory "' .
                            $extDirPath . $root .
                            '" could not be created...';
                }
            }


 - :Function:
        :code:`upload_to_tempfile`

        :code:`unlink_tempfile`

        :code:`tempnam`
   :Comments:
         **Functions for handling uploads and temporary files**

         You need to use these functions for managing uploaded files you want
         to access as well as creating temporary files within the same session.
         These functions are safe\_mode and open\_basedir compatible which is
         the main point of you using them!

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::upload_to_tempfile()` - Will move an uploaded file
         (normally in "/tmp/xxxxx") to a temporary filename in
         :code:`PATH\_site . 'typo3temp/'`.
         Remember to use :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::unlink_tempfile()` afterwards - otherwise
         temp-files will build up! They are *not* automatically deleted in
         :code:`PATH\_site . 'typo3temp/'`!

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::unlink_tempfile()` - Deletes (unlink) a temporary
         filename in :code:`PATH\_site . 'typo3temp/'` given as input. The function
         will check that the file exists, is in :code:`PATH_site . 'typo3temp/'` and
         does not contain back-spaces ("../") so it should be pretty safe. Use
         this after :code:`upload_to_tempfile()` or :code:`tempnam()` from this class!

         This example shows how to handle an uploaded file you just want to
         read and then delete again::

                // Read uploaded file:
            $uploadedTempFile = \TYPO3\CMS\Core\Utility\GeneralUtility::upload_to_tempfile(
                $_FILES['upload_ext_file']['tmp_name']
            );
            $fileContent = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($uploadedTempFile);
            \TYPO3\CMS\Core\Utility\GeneralUtility::unlink_tempfile($uploadedTempFile);

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::tempnam()` - Create temporary filename (creates file
         with unique file name). This function should be used for getting
         temporary filenames - will make your applications safe for
         "open\_basedir = on". Remember to delete the temporary files after
         use! This is done by :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::unlink_tempfile()`.

         In the following example it is shown how two temporary filenames are
         created for being processed with an external program (diff) after
         which they are deleted again::

                // Create file 1 and write string
            $file1 = \TYPO3\CMS\Core\Utility\GeneralUtility::tempnam('diff1_');
            \TYPO3\CMS\Core\Utility\GeneralUtility::writeFile($file1, $str1);
                // Create file 2 and write string
            $file2 = \TYPO3\CMS\Core\Utility\GeneralUtility::tempnam('diff2_');
            \TYPO3\CMS\Core\Utility\GeneralUtility::writeFile($file2, $str2);
                // Perform diff.
            $cmd = $GLOBALS['TYPO3_CONF_VARS']['BE']['diff_path'].
                       ' '.$this->diffOptions . ' ' . $file1 . ' ' . $file2;
            exec($cmd, $res);
            unlink($file1);
            unlink($file2);


 - :Function:
         :code:`fixed_lgd_cs`
   :Comments:
         **Truncating a string for visual display, observing the character set
         (backend only)**

         This function allows you to truncate a string from e.g. "Hello World"
         to "Hello Wo..." so for example very long titles of records etc. will
         not break the visual appearance of your backend modules.

         Since text strings cannot be cropped at any byte if the character set
         is utf-8 or another multibyte charset this function will process the
         string assuming the character set to be the one used in the backend.

         It is recommended to use $BE\_USER->uc['titleLen'] for the length
         parameter. ::

              // Limits Record title to 30 chars
            \TYPO3\CMS\Core\Utility\GeneralUtility::fixed_lgd_cs($thisRecTitle, 30);
              // Limits string to title-length configured for backend user:
            $title = \TYPO3\CMS\Core\Utility\GeneralUtility::fixed_lgd_cs(
                         $row['title'],
                         $this->BE_USER->uc['titleLen']
            );


 - :Function:
         :code:`formatForTextarea`
   :Comments:
         **Preparing a string for output between <textarea> tags.**

         Use this function to prepare content for <textarea> tags. Then you
         will avoid extra / stripped whitespace when the form is submitted
         multiple times. ::

                // Create item:
            $item = '
                <textarea>' .
                \TYPO3\CMS\Core\Utility\GeneralUtility::formatForTextarea($value) .
                '</textarea>';


 - :Function:
         :code:`locationHeaderUrl`

   :Comments:
         **Preparing a URL for a HTTP location-header**

         Use this to prepare redirection URLs for location-headers. It will
         convert the URL to be absolute. This is also useful in other cases
         where an absolute URL must be used, for example when passing a
         callback URL to some third-party software. Redirection example::

            header('Location: ' . \TYPO3\CMS\Core\Utility\GeneralUtility::locationHeaderUrl($this->retUrl));
            exit;


.. _high-priority-functions-backend-utility:

\\TYPO3\\CMS\\Backend\\Utility\\BackendUtility
""""""""""""""""""""""""""""""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`deleteClause`
   :Comments:
         **Get SQL WHERE-clause filtering "deleted" records**

         Tables from $TCA might be configured to set an integer flag when
         deleting a record instead of actually removing it from the database.
         Records with the deleted-flag set *should never* be selected in
         TYPO3 unless you have a specific reason to do so.
         To make sure you never make that mistake always call this
         function which will pass you a SQL WHERE-clause like :code:`" AND deleted=0"`
         if the table given as argument has been configured with a deleted-
         field.

         .. note::
            In the frontend this is built into the :code:`enableFields()` method.

         Example::

            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                            'pid, uid, title, TSconfig, is_siteroot, storage_pid',
                            'pages',
                            'uid = ' . intval($uid) . ' ' .
                                \TYPO3\CMS\Backend\Utility\BackendUtility::deleteClause('pages') . ' ' .
                                $clause
                        );


 - :Function:
         :code:`getFuncMenu`

         :code:`getFuncCheck`
   :Comments:
         **Create "Function menu" in backend modules**

         Creates a selector box menu or checkbox with states automatically
         saved in the backend user session. Such a function menu could look
         like this:

         .. figure:: ../../../Images/FunctionMenu.png
            :alt: The function menu from the Web > Info module

            The function menu from the Web > Info module

         The selector box is made by this function call. It sets the
         ID variable (zero if not available), the GET var name, "SET[mode]",
         the current value from :code:`MOD_SETTINGS` and finally the array of menu
         options, :code:`MOD_MENU['mode']`::

            \TYPO3\CMS\Backend\Utility\BackendUtility::getFuncMenu(
                $this->id,
                'SET[mode]',
                $this->MOD_SETTINGS['mode'],
                $this->MOD_MENU['mode']
            )

         Prior to making the menu it is required that the :code:`MOD_MENU` array is
         set up with an array of options. This could look like this (getting
         some labels from the "locallang" system). In addition the incoming
         "SET" GET-variable must be registered in the session which is also
         done in this listing::

            $this->MOD_MENU = array(
                'mode' => array(
                    0 => $LANG->getLL('user_overview'),
                    'perms' => $LANG->getLL('permissions')
                )
            );
                // Clean up settings:
            $this->MOD_SETTINGS = \TYPO3\CMS\Backend\Utility\BackendUtility::getModuleData(
                                    $this->MOD_MENU,
                                    \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('SET'),
                                    $this->MCONF['name']
                                );

         You can have checkboxes as well:

         .. figure:: ../../../Images/FunctionMenuCheckBoxes.png
            :alt: The function menu from the Web > Info module

            The function menu from the Web > Info module

         Then the function call looks like this. Notice the fourth
         argument is gone because a checkbox does not have any information
         about options like a selector box would have. ::

            \TYPO3\CMS\Backend\Utility\BackendUtility::getFuncCheck(
                0,
                'SET[own_member_only]',
                $this->MOD_SETTINGS['own_member_only']
            );

         For checkboxes you must set the key in the :code:`MOD_MENU` array as well.
         Otherwise the values are not registered in the user session::

            'own_member_only' => '',


 - :Function:
         :code:`editOnClick`
   :Comments:
         **Create onclick-JavaScript code that links to edit form for a record**

         Use this function to create a link to the "alt\_doc.php" core script
         which can generate editing forms for any :code:`$TCA` configured record. The
         actual editing command is passed to "alt\_doc.php" through the GET
         parameter "&edit".

         For detailed examples, see :ref:`t3api:edit-links-examples`.

         Example::

            $params = '&edit[pages][' . $row['uid'] . ']=edit';
            $link = '<a href="#" onclick="' .
                        htmlspecialchars(\TYPO3\CMS\Backend\Utility\BackendUtility::editOnClick($params, '', -1)).
                        '">Edit</a>';


 - :Function:
         :code:`viewOnClick`
   :Comments:
         **Create onclick-JavaScript code that opens a page in the frontend**

         It will detect the correct domain name if needed and provide the link
         with the right back path. Also it will re-use any window already open. ::

                // "View page" link is added:
            $link = '<a href="#" onclick="' .
                    htmlspecialchars(\TYPO3\CMS\Backend\Utility\BackendUtility::viewOnClick(
                        $pageId,
                        $GLOBALS['BACK_PATH'],
                        \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($pageId)
                    )) . '">View page</a>';


 - :Function:
         :code:`wrapInHelp`
   :Comments:
         **Create icon or short description for Context Sensitive Help (CSH)**

         You are encouraged to integrate Content Sensitive Help in your backend
         modules and for your database tables. This will help users to use
         TYPO3 and your TYPO3 applications more easily. The help appears as icons.
         Hovering over these reveals the (short) help text.

         .. figure:: ../../../Images/ContextSensitiveHelp.png
            :alt: The CSH displayed in a help bubble

         Example::

              // Setting "table name" to module name with prefix
            $tableIdentifier = '_MOD_' . $this->MCONF['name'];

              // Creating CSH icon and short description (for item "property"):
            $HTMLcode .= \TYPO3\CMS\Backend\Utility\BackendUtility::wrapInHelp($tableIdentifier, 'property');


.. _high-priority-functions-extension-management-utility:

\\TYPO3\\CMS\\Core\\Utility\\ExtensionManagementUtility
"""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`isLoaded`
   :Comments:
         **Returns true if an extension is loaded (installed)**

         Use if you just need to check if an extension is loaded in a TYPO3 installation.

         Example::

            	// If the extension "sys_note" is loaded, then...
            if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('sys_note'))    ...

            	// Check if the "indexed_search" extension is loaded.
            	// If not, an exception will be thrown!
            try {
            	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('indexed_search', TRUE);
            }
            catch (BadFunctionCallException $e) {
            	...
            }

            		// Assign value "popup" if extension "tsconfig_help" is loaded
            $type = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('tsconfig_help') ? 'popup' : '';


 - :Function:
         :code:`extPath`

         :code:`extRelPath`

         :code:`siteRelPath`
   :Comments:
         **Get file path to an extension directory**

         If you need to get the absolute or relative filepaths to an extension
         you should use these functions. Extension can be located in three
         different positions in the filesystem whether they are
         :ref:`local, global or system extensions <t3api:extension-scope>`.
         These functions will always give you the right path.

         Examples::

            	// Include a PHP file from the extension "extrep_wizard".
            	// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath() returns the absolute path to the
            	// extension directory.
            require_once(
                \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('extrep_wizard') .
                'pi/class.tx_extrepwizard.php'
            );
            	// Get relative path (relative to PATH_typo3) to an icon (backend)
            $icon = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tt_rating') . 'rating.gif';
            	// Get relative path (relative to PATH_site) to an icon (frontend)
            return '<img src="'.
                \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('indexed_search') . 'pi/res/locked.gif'
                ... />';


.. _high-priority-functions-icon-utility:

\\TYPO3\\CMS\\Backend\\Utility\\IconUtility
"""""""""""""""""""""""""""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`getSpriteIcon`

         :code:`getSpriteIconForFile`

         :code:`getSpriteIconForRecord`
   :Comments:
         **Getting correct icons**

         Always use these functions if you need to get some arbitrary icon
         (:code:`getSpriteIcon()`), the correct icon for a record
         (:code:`getSpriteIconForRecord()`) or for a file (:code:`getSpriteIconForFile()`).
         For records, there needs to be a proper definition in the :ref:`$TCA <t3tca:start>`.

         More information about skinning is found in the :ref:`t3skinning:start`. ::

            	// Getting default icon for the "tt_content" table
            $icon = \TYPO3\CMS\Backend\Utility\IconUtility::getSpriteIconForRecord(
            	'tt_content',
            	array()
            );

            	// Getting an icon where record content may define the look
            $icon = \TYPO3\CMS\Backend\Utility\IconUtility::getSpriteIconForRecord(
            	$table,
            	$row
            );

            	// Getting a given icon, for example the "new document" action
            \TYPO3\CMS\Backend\Utility\IconUtility::getSpriteIcon('actions-document-new');


.. _high-priority-functions-database-connection:

\\TYPO3\\CMS\\Core\\Database\\DatabaseConnection
""""""""""""""""""""""""""""""""""""""""""""""""

This class is always accessed via its global instance :code:`$GLOBALS['TYPO3_DB']`.

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`exec_INSERTquery`

         :code:`exec_UPDATEquery`

         :code:`exec_DELETEquery`

         :code:`exec_SELECTquery`
   :Comments:
         **Database Access API**

         To be compatible with the DataBase Abstraction Layer (DBAL) you should always
         use the global object :code:`$GLOBALS['TYPO3_DB']` for database access. The class
         :code:`\TYPO3\CMS\Dbal\Database\DatabaseConnection` contains a list of MySQL wrapper functions (:code:`sql()`,
         :code:`sql_fetch_assoc()`, etc.) which you can use almost out of the box
         as a start. This way your extension will be able to run properly on other
         supported DBMSes (i.e. MS SQL Server, Oracle and PostgreSQL).

         .. note::
            When writing code for the TYPO3 backend, you should rely on :ref:`TCEmain <using-tcemain>`
            whenever possible.

         **Inserting a record:**

         Just fill an array with "fieldname => value" pairs and pass it to
         :code:`exec_INSERTquery()` along with the table name in which it should be
         inserted::

            $insertFields = array(
                'md5hash' => $md5,
                'tstamp' => time(),
                'type' => 2,
                'params' => $inUrl
            );
            $GLOBALS['TYPO3_DB']->exec_INSERTquery(
                'cache_md5params',
                $insertFields
            );

         **Updating a record:**

         Create an array of "fieldname => value" pairs before calling
         :code:`exec_UPDATEquery()`. The function call is almost like inserting, but
         you need to add a WHERE clause to target the update to the record you
         want to update. It is the second argument you set to a value like
         "uid=???". ::

            $fields_values = array(
                'title' => $data['sys_todos'][$key]['title'],
                'deadline' => $data['sys_todos'][$key]['deadline'],
                'description' => $data['sys_todos'][$key]['description'],
                'tstamp' => time()
            );
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
                'sys_todos',
                'uid=' . intval($key),
                $fields_values
            );

         **Deleting a record:**

         Call :code:`exec_DELETEquery()` with the tablename *and* the WHERE clause
         selecting the record to delete::

            $GLOBALS['TYPO3_DB']->exec_DELETEquery(
                'sys_todos',
                'uid=' . intval($key)
            );

         **Selecting a record:**

         Call :code:`exec_SELECTquery()` with at least the first three arguments
         (field list to select, table name and WHERE clause). The return value
         is a result pointer (or object) which should be passed to
         :code:`sql_fetch_assoc()` in a loop in order to traverse the result rows. ::

            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                '*',
                $theTable,
                $theField . '="' .
                    $GLOBALS['TYPO3_DB']->quoteStr($theValue, $theTable) . '"' .
                    $this->deleteClause($theTable) . ' ' .
                    $whereClause,
                $groupBy,
                $orderBy,
                $limit
            );
            $rows = array();
            while(($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
                $rows[] = $row;
            }
            $GLOBALS['TYPO3_DB']->sql_free_result($res);
            if (count($rows))    return $rows;

         .. tip::
            There are many more select methods in :code:`\TYPO3\CMS\Dbal\Database\DatabaseConnection`, look at
            its API for details.



.. _high-priority-functions-beuser:

\\TYPO3\\CMS\\Core\\Authentication\\BackendUserAuthentication
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

This class is always accessed via its global instance :code:`$GLOBALS['BE_USER']`.

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`isAdmin`
   :Comments:
         **Returns true if current backend user is "admin"**

         Use this if you need to restrict a user from doing something unless he
         is "admin"::

            if ($GLOBALS['BE_USER']->isAdmin()) {
            	...
            }


 - :Function:
         :code:`getPagePermsClause`
   :Comments:
         **Return WHERE clause for filtering pages for which the current user
         has the requested permission**

         The most typical usage of this is to call the function with the value
         "1" (= "show"). Then the WHERE clause returned will filter away all pages to
         which the user has no read-access.


.. _coding-guidelines:

TYPO3 Coding Guidelines
"""""""""""""""""""""""

You should also refer to the :ref:`TYPO3 Core Coding Guidelines (CGL) <t3cgl:start>`
document which is the authoritative source to know about which coding
practices are required for TYPO3 core and extension programming.

