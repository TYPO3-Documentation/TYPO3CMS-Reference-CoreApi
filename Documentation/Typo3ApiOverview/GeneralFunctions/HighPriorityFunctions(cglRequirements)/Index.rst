.. include:: Images.txt

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


High priority functions (CGL requirements)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The functions listed in this table are of high priority. Generally
they provide APIs to functionality which TYPO3 should always handle in
the same way. This will help you to code TYPO3 applications with less
bugs and greater compatibility with various system conditions it will
run under.

Remember, this list only serves to point out important functions! The
real documentation is found in the source scripts. The comments given
are only a supplement to that.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Function
         Function
   
   Comments
         Comments


.. container:: table-row

   Function
         t3lib\_div::\_GP
         
         t3lib\_div::\_GET
         
         t3lib\_div::\_POST
   
   Comments
         **Getting values from GET or POST vars**
         
         APIs for getting values in GET or POST variables with slashes stripped
         regardless of PHP environment. Always use these functions instead of
         direct access to $\_GET or $\_POST.
         
         t3lib\_div::\_GP($varname) will give you the value of either the GET
         or POST variable with priority to POST if present. This is useful if
         you don't know whether a parameter is passed as GET or POST. Many
         scripts will use this function to read variables in the init function:
         
         ::
         
                // Setting GPvars:
            $this->file = t3lib_div::_GP('file');
            $this->size = t3lib_div::_GP('size');
         
         t3lib\_div::\_GET() will give you GET vars. For security reasons you
         should use this if you know your parameters are passed as GET
         variables. This example gives you the whole $\_GET array:
         
         ::
         
            $params = t3lib_div::_GET();
         
         t3lib\_div::POST() will give you POST variables. Works like
         t3lib\_div::\_GET(). For security reasons you should use this if you
         know your parameters are passed as POST variables.
         
         This example gives you the content of the POST variable
         TSFE\_ADMIN\_PANEL, for instance it could come from a form field like
         "<input name="TSFE\_ADMIN\_PANEL[command]" ..../>
         
         ::
         
            $input = t3lib_div::_POST('TSFE_ADMIN_PANEL');


.. container:: table-row

   Function
         t3lib\_div::makeInstance
   
   Comments
         **Creating objects**
         
         Factory API for creating an object instance of a class name. This
         function makes sure the "XCLASS extension" principle can be used on
         (almost) any class in TYPO3. You  **must** use this function when
         creating objects in TYPO3.
         
         Examples:
         
         ::
         
            // Making an instance of class "t3lib_TSparser":
            $parseObj = t3lib_div::makeInstance('t3lib_TSparser');
            
            // Make an object with an argument passed to the constructor (TYPO3 4.3+):
            $xmlObj = t3lib_div::makeInstance('t3lib_xml', 'typo3_export');
         
         NOTE: t3lib\_div::makeInstanceClassName() has been deprecated in TYPO3
         4.3 and should not be used anymore.


.. container:: table-row

   Function
         t3lib\_div::getIndpEnv
   
   Comments
         **Environment-safe server and environment variables.**
         
         API function for delivery of system and environment variables on any
         web-server brand and server OS. Always use this API instead of
         $\_ENV/$\_SERVER or getenv() if possible.
         
         Examples:
         
         ::
         
            if (t3lib_div::getIndpEnv('HTTP_ACCEPT_LANGUAGE') == $test)...
            if (t3lib_div::cmpIP(t3lib_div::getIndpEnv('REMOTE_ADDR'), $pcs[1]))...
            $prefix = t3lib_div::getIndpEnv('TYPO3_REQUEST_URL');
            $redirectTo = t3lib_div::getIndpEnv('TYPO3_SITE_URL').$redirectTo;
            if (!t3lib_div::getIndpEnv('TYPO3_SSL')) ...


.. container:: table-row

   Function
         t3lib\_div::loadTCA
   
   Comments
         **Loading full table description into $TCA**
         
         If you want to access or change any part of the $TCA array for a table
         except the ['ctrl'] part then you should call this function first. The
         $TCA might not contain the full configuration for the table (depending
         on configuration of the table) and to make sure it is loaded, if it
         isn't already, you call this function.
         
         Examples of PHP code which traverses the ['columns'] part of an
         unknown table and loads the table before.
         
         ::
         
            t3lib_div::loadTCA($this->table);
            foreach ($TCA[$this->table]['columns'] as $fN) {
                $fieldListArr[] = $fN;
            }


.. container:: table-row

   Function
         t3lib\_BEfunc::deleteClause
   
   Comments
         **Get SQL WHERE-clause filtering "deleted" records**
         
         Tables from $TCA might be configured to set an integer flag when
         deleted instead of being physically deleted from the database. In any
         case records with the deleted-flag set  *must never* be selected in
         TYPO3. To make sure you never make that mistake always call this
         function which will pass you a SQL WHERE-clause like " AND deleted=0"
         if the table given as argument has been configured with a deleted-
         field.
         
         (Notice: In the frontend this is build into the "enableFields()"
         function.)
         
         Example:
         
         ::
         
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                            'pid,uid,title,TSconfig,is_siteroot,storage_pid',
                            'pages',
                            'uid='.intval($uid).' '.
                                t3lib_BEfunc::deleteClause('pages').' '.
                                $clause    
                        );


.. container:: table-row

   Function
         t3lib\_extMgm::isLoaded
   
   Comments
         **Returns true if an extension is loaded (installed)**
         
         If you need to check if an extension is loaded in a TYPO3 installation
         simply use this function to ask for that.
         
         Example:
         
         ::
         
              // If the extension "sys_note" is loaded, then...
            if (t3lib_extMgm::isLoaded('sys_note'))    ...
              // If the "cms" extension is NOT loaded, return false
            if (!t3lib_extMgm::isLoaded('cms'))    return;
              // Check if the "indexed_search" extension is loaded. If not, exit PHP!
            t3lib_extMgm::isLoaded('indexed_search', TRUE);
              // Assign value "popup" if extension "tsconfig_help" is loaded
            $type = t3lib_extMgm::isLoaded('tsconfig_help') ? 'popup' : '';


.. container:: table-row

   Function
         t3lib\_extMgm::extPath
         
         t3lib\_extMgm::extRelPath
         
         t3lib\_extMgm::siteRelPath
   
   Comments
         **Get file path to an extension directory**
         
         If you need to get the absolute or relative filepaths to an extension
         you should use these functions. Extension can be located in three
         different positions in the filesystem whether they are local, global
         or system extensions. These functions will always give you the right
         path.
         
         Examples:
         
         ::
         
              // Include a PHP file from the extension "extrep_wizard".
              // t3lib_extMgm::extPath() returns the absolute path to the 
              // extension directory.
            require_once(
                t3lib_extMgm::extPath('extrep_wizard') .
                'pi/class.tx_extrepwizard.php'
            );
              // Get relative path (relative to PATH_typo3) to an icon (backend)
            $icon = t3lib_extMgm::extRelPath('tt_rating') . 'rating.gif';
              // Get relative path (relative to PATH_site) to an icon (frontend)
            return '<img src="'.
                t3lib_extMgm::siteRelPath('indexed_search') . 'pi/res/locked.gif' 
                ... />';


.. container:: table-row

   Function
         t3lib\_div::getFileAbsFileName
         
         t3lib\_div::validPathStr
         
         t3lib\_div::isAbsPath
         
         t3lib\_div::isAllowedAbsPath
         
         t3lib\_div::fixWindowsFilePath
   
   Comments
         **Evaluate files and directories for security reasons**
         
         When you allow references to files to be input from users there is
         always the risk that they try to cheat the system to include something
         else than intended. These functions makes it easy for you to evaluate
         filenames for validity before reading, writing or including them.
         
         Here the functions are described in order of importance:
         
         **t3lib\_div::getFileAbsFileName()** - Returns the absolute filename
         of a relative reference, resolves the "EXT:" prefix (way of referring
         to files inside extensions) and checks that the file is inside the
         PATH\_site of the TYPO3 installation and implies a check with
         t3lib\_div::validPathStr(). Returns false if checks failed. Does not
         check if the file exists.
         
         ::
         
              // Getting absolute path of a temporary file:
            $cacheFile = t3lib_div::getFileAbsFileName('typo3temp/tempfile.tmp');
              // Include file if it exists:
            $file = t3lib_div::getFileAbsFileName($fileRef);
            if (@is_file($file))    {
                include($file);
            }
         
         **t3lib\_div::validPathStr()** - Checks for malicious file paths.
         Returns true if no '//', '..' or '\' is in the $theFile. This should
         make sure that the path is not pointing 'backwards' and further
         doesn't contain double/back slashes.
         
         ::
         
                // If the path is true and validates as a valid path string:
            if ($path && t3lib_div::validPathStr($path))    ...
         
         **t3lib\_div::isAbsPath()** - Checks if the input path is absolute or
         relative (detecting either '/' or 'x:/' as first part of string) and
         returns true if so.
         
         ::
         
              // Returns relative filename for icon:
            if (t3lib_div::isAbsPath($Ifilename))    {
                $Ifilename = '../' . substr($Ifilename, strlen(PATH_site));
            }
         
         **t3lib\_div::isAllowedAbsPath()** - Returns true if the path is
         absolute, without backpath '..' and within the PATH\_site OR within
         the lockRootPath. Contrary to t3lib\_div::getFileAbsFileName() this
         function can also validate files in filemounts outside the web-root of
         the installation, but this is rarely used!
         
         ::
         
            if (@file_exists($path) && t3lib_div::isAllowedAbsPath($path))    {
                $fI = pathinfo($path);
                     ....
         
         **t3lib\_div::fixWindowsFilePath()** - Fixes a path for Windows-
         backslashes and reduces double-slashes to single slashes


.. container:: table-row

   Function
         t3lib\_div::mkdir
   
   Comments
         **Creates directory**
         
         One would think that creating directories is one thing you can do
         directly with PHP. Well, it turns out to be quite error-prone if it
         should be compatible with Windows servers and safe-mode at the same
         time. So TYPO3 offers a substitution function you should always use.
         
         Example:
         
         ::
         
            $root.=$dirParts . '/';
            if (!is_dir($extDirPath . $root))    {
                t3lib_div::mkdir($extDirPath . $root);
                if (!@is_dir($extDirPath.$root))    {
                    return 'Error: The directory "' .
                            $extDirPath.$root.
                            '" could not be created...';
                }
            }


.. container:: table-row

   Function
         t3lib\_div::upload\_to\_tempfile
         
         t3lib\_div::unlink\_tempfile
         
         t3lib\_div::tempnam
   
   Comments
         **Functions for handling uploads and temporary files**
         
         You need to use these functions for managing uploaded files you want
         to access as well as creating temporary files within the same session.
         These functions are safe\_mode and open\_basedir compatible which is
         the main point of you using them!
         
         **t3lib\_div::upload\_to\_tempfile()** - Will move an uploaded file
         (normally in "/tmp/xxxxx") to a temporary filename in
         PATH\_site."typo3temp/" from where TYPO3 can use it under safe\_mode.
         Remember to use t3lib\_div::unlink\_tempfile() afterwards - otherwise
         temp-files will build up! They are  *not* automatically deleted in
         PATH\_site."typo3temp/"!
         
         **t3lib\_div::unlink\_tempfile()** - Deletes (unlink) a temporary
         filename in 'PATH\_site."typo3temp/"' given as input. The function
         will check that the file exists, is in PATH\_site."typo3temp/" and
         does not contain back-spaces ("../") so it should be pretty safe. Use
         this after upload\_to\_tempfile() or tempnam() from this class!
         
         This example shows how to handle an uploaded file you just want to
         read and then delete again:
         
         ::
         
                // Read uploaded file:
            $uploadedTempFile = t3lib_div::upload_to_tempfile(
                $GLOBALS['HTTP_POST_FILES']['upload_ext_file']['tmp_name']
            );
            $fileContent = t3lib_div::getUrl($uploadedTempFile);
            t3lib_div::unlink_tempfile($uploadedTempFile);
         
         **t3lib\_div::tempnam()** - Create temporary filename (creates file
         with unique file name). This function should be used for getting
         temporary filenames - will make your applications safe for
         "open\_basedir = on". Remember to delete the temporary files after
         use! This is done by t3lib\_div::unlink\_tempfile()
         
         In the following example it is shown how two temporary filenames are
         created for being processed with an external program (diff) after
         which they are deleted again:
         
         ::
         
                // Create file 1 and write string
            $file1 = t3lib_div::tempnam('diff1_');
            t3lib_div::writeFile($file1, $str1);
                // Create file 2 and write string
            $file2 = t3lib_div::tempnam('diff2_');
            t3lib_div::writeFile($file2, $str2);
                // Perform diff.
            $cmd = $GLOBALS['TYPO3_CONF_VARS']['BE']['diff_path'].
                       ' '.$this->diffOptions . ' ' . $file1 . ' ' . $file2;
            exec($cmd, $res);
            unlink($file1);
            unlink($file2);


.. container:: table-row

   Function
         t3lib\_div::fixed\_lgd\_cs
   
   Comments
         **Truncating a string for visual display, observing the character set
         (backend only)**
         
         This function allows you to truncate a string from e.g. "Hello World"
         to "Hello Wo..." so for example very long titles of records etc. will
         not break the visual appearance of your backend modules.
         
         Since text strings cannot be cropped at any byte if the character set
         is utf-8 or another multibyte charset this function will process the
         string assuming the character set to be the one used in the backend.
         
         It is recommended to use $BE\_USER->uc['titleLen'] for the length
         parameter.
         
         ::
         
              // Limits Record title to 30 chars
            t3lib_div::fixed_lgd_cs($thisRecTitle, 30);
              // Limits string to title-length configured for backend user:
            $title = t3lib_div::fixed_lgd_cs(
                         $row['title'],
                         $this->BE_USER->uc['titleLen']
            );


.. container:: table-row

   Function
         t3lib\_div::formatForTextarea
   
   Comments
         **Preparing a string for output between <textarea> tags.**
         
         Use this function to prepare content for <textarea> tags. Then you
         will avoid extra / stripped whitespace when the form is submitted
         multiple times.
         
         ::
         
                // Create item:
            $item = '
                <textarea>' .
                t3lib_div::formatForTextarea($value) .
                '</textarea>';


.. container:: table-row

   Function
         t3lib\_div::locationHeaderUrl
   
   Comments
         **Preparing a URL for a HTTP location-header**
         
         Use this to prepare redirection URLs for location-headers. It will
         convert the URL to be absolute. This is also useful in other cases
         where an absolute URL must be used, for example when passing a
         callback URL to some third-party software. Redirection example:
         
         ::
         
            header('Location: ' . t3lib_div::locationHeaderUrl($this->retUrl));
            exit;


.. container:: table-row

   Function
         t3lib\_BEfunc::getFuncMenu
         
         t3lib\_BEfunc::getFuncCheck
   
   Comments
         **Create "Function menu" in backend modules**
         
         Creates a selector box menu or checkbox with states automatically
         saved in the backend user session. Such a function menu could look
         like this:
         
         |img-13| The selector box is made by this function call. It sets the
         ID variable (zero if not available), the GET var name, "SET[mode]",
         the current value from MOD\_SETTINGS and finally the array of menu
         options, MOD\_MENU['mode']:
         
         ::
         
            t3lib_BEfunc::getFuncMenu(
                $this->id,
                'SET[mode]',
                $this->MOD_SETTINGS['mode'],
                $this->MOD_MENU['mode']
            )
         
         Prior to making the menu it is required that the MOD\_MENU array is
         set up with an array of options. This could look like this (getting
         some labels from the "locallang" system). In addition the incoming
         "SET" GET-variable must be registered in the session which is also
         done in this listing:
         
         ::
         
            $this->MOD_MENU = array(
                'mode' => array(
                    0 => $LANG->getLL('user_overview'),
                    'perms' => $LANG->getLL('permissions')
                )
            );
                // Clean up settings:
            $this->MOD_SETTINGS = t3lib_BEfunc::getModuleData(
                                    $this->MOD_MENU,
                                    t3lib_div::_GP('SET'), 
                                    $this->MCONF['name']
                                );
         
         You can have a checkbox as well:
         
         |img-14| Then the function call looks like this. Notice the fourth
         argument is gone because a checkbox does not have any information
         about options like a selector box would have.
         
         ::
         
            t3lib_BEfunc::getFuncCheck(
                0,
                'SET[own_member_only]',
                $this->MOD_SETTINGS['own_member_only']
            );
         
         For checkboxes you must set the key in the MOD\_MENU array as well.
         Otherwise the values are not registered in the user session:
         
         ::
         
            'own_member_only' => '',


.. container:: table-row

   Function
         t3lib\_BEfunc::editOnClick
   
   Comments
         **Create onclick-JavaScript code that links to edit form for a
         record**
         
         Use this function to create a link to the "alt\_doc.php" core script
         which can generate editing forms for any $TCA configured record. The
         actual editing command is passed to "alt\_doc.php" through the GET
         parameter "&edit".
         
         See the section with `"Various examples" for detailed examples
         <#Links%20to%20edit%20records%7Coutline>`_ of this!
         
         Example:
         
         ::
         
            $params = '&edit[pages][' . $row['uid'] . ']=edit';
            $link = '<a href="#" onclick="' .
                        htmlspecialchars(t3lib_BEfunc::editOnClick($params, '', -1)).
                        '">Edit</a>';


.. container:: table-row

   Function
         t3lib\_BEfunc::viewOnClick
   
   Comments
         **Create onclick-JavaScript code that opens a page in the frontend**
         
         It will detect the correct domain name if needed and provide the link
         with the right back path. Also it will re-use any window already open.
         
         ::
         
                // "View page" link is added:
            $link = '<a href="#" onclick="' .
                    htmlspecialchars(t3lib_BEfunc::viewOnClick(
                        $pageId,
                        $GLOBALS['BACK_PATH'],
                        t3lib_BEfunc::BEgetRootLine($pageId)
                    )) . '">View page</a>';


.. container:: table-row

   Function
         $GLOBALS['TBE\_TEMPLATE']->
         
         issueCommand
   
   Comments
         **Creates a link to "tce\_db.php" (with a command like copy,
         move,delete for records)**
         
         Creates a URL to the TYPO3 Core Engine interface provided from the
         core script, "tce\_db.php". The $params array is filled with date or
         cmd values. For detailed list of options `see section about TCE
         elsewhere in this document <#The%20%22tce_db.php%22%20API%7Coutline>`_
         .
         
         Example:
         
         ::
         
                // Delete 
            $params = '&cmd[tt_content][' . $row['uid'] . '][delete]=1';
            $out .= '<a href="' .
                htmlspecialchars($GLOBALS['SOBE']->doc->issueCommand($params)).
                '" onclick="' .
                htmlspecialchars("return confirm('Want to delete?');").
                '">Delete record</a>';


.. container:: table-row

   Function
         t3lib\_BEfunc::helpTextIcon
         
         t3lib\_BEfunc::helpText
         
         t3lib\_BEfunc::cshItem
   
   Comments
         **Create icon or short description for Context Sensitive Help (CSH)**
         
         You are encouraged to integrate Content Sensitive help in your backend
         modules and for your database tables. This will help users to use
         TYPO3 and your TYPO3 applications more easily.
         
         With these functions you can create content sensitive help texts (and
         links to more details) like this:
         
         |img-15| (Note: For the short description to be displayed and not only
         the icon the user must set up "Field help mode" in the User>Setup
         module to "Display full text message".)
         
         **Examples:**
         
         ::
         
              // Setting "table name" to module name with prefix
            $tableIdent = '_MOD_' . $this->MCONF['name'];
            
              // Creating CSH icon and short description:
            $HTMLcode .=
                t3lib_BEfunc::helpTextIcon($tableIdent, 'quickEdit', $BACK_PATH).
                t3lib_BEfunc::helpText($tableIdent, 'quickEdit', $BACK_PATH).
                '<br />';
         
         Prior to calling helpTextIcon and helpText you might need to load the
         description table with:
         
         ::
         
            if ($BE_USER->uc['edit_showFieldHelp'])    {
                $LANG->loadSingleTableDescription($tableIdent);
            }
         
         Alternatively you can use t3lib\_BEfunc::cshItem(). It's a quicker way
         of integrating the descriptions since description files are loaded
         automatically and the text/icon mode is integrated in a single
         function call. This is recommended for sporadic usage:
         
         ::
         
            $HTMLcode .=
            t3lib_BEfunc::cshItem($tableIdent,'quickEdit', $BACK_PATH);


.. container:: table-row

   Function
         t3lib\_iconWorks::getIconImage
         
         t3lib\_iconWorks::getIcon
   
   Comments
         **Getting correct icon for database table record**
         
         Always use these functions if you need to get the icon for a record.
         Works only for records from tables which are defined in $TCA
         
         ::
         
              // Getting default icon for the "tt_content" table:
            t3lib_iconWorks::getIconImage('tt_content', array(), $this->backPath, '');
            
              // Getting an icon where record content may define the look:
            $icon = t3lib_iconWorks::getIconImage(
                        $this->table,
                        $row,
                        $this->backPath,
                        'align="top" class="c-recIcon"'
                    );
            
              // Getting the icon filename only:
            $ficon = t3lib_iconWorks::getIcon($table, $row);


.. container:: table-row

   Function
         t3lib\_iconWorks::skinImg
   
   Comments
         **Processing icons for skin API**
         
         Pass the filename and width/height attributes of all images you use in
         your backend applications through this function. See `Skin API
         description <#How%20to%20make%20your%20extensions%20compatible%20with%
         20skinning%7Coutline>`_ for more details.
         
         ::
         
            $skin_enabled_icon = '<img' .
                t3lib_iconWorks::skinImg(
                    $this->doc->backPath,
                    'gfx/recordlock_warning3.gif',
                    'width="17" height="12"'
                ) .
                ' alt="" />';


.. container:: table-row

   Function
         $GLOBALS['TYPO3\_DB']->
         
         exec\_INSERTquery
         
         exec\_UPDATEquery
         
         exec\_DELETEquery
         
         exec\_SELECTquery
   
   Comments
         **Database Access API**
         
         To be compatible with Database Abstraction Layers you should always
         use the global object $TYPO3\_DB for database access. The class
         "t3lib\_db" contains a list of MySQL wrapper functions (sql(),
         sql\_fetch\_assoc(), etc...) which you can use almost out of the box
         as a start. Just search/replace.
         
         But it is recommended that you port your application to using the four
         execution functions directly. These will both build the query for you
         and execute it.
         
         See the `Coding Guidelines <../../../../doc_core_cgl/doc/manual.sxw#Da
         tabase%20connectivity%7Coutline>`_ , t3lib\_db API and `Inside TYPO3
         <#Database%7Coutline>`_ document for more information.
         
         **Inserting a record:**
         
         Just fill an array with "fieldname => value" pairs and pass it to
         exec\_INSERTquery() along with the table name in which it should be
         inserted:
         
         ::
         
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
         exec\_UPDATEquery(). The function call is almost like inserting, but
         you need to add a WHERE clause to target the update to the record you
         want to update. It is the second argument you set to a value like
         "uid=???".
         
         ::
         
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
         
         Call exec\_DELETEquery() with the tablename  *and* the WHERE clause
         selecting the record to delete:
         
         ::
         
            $GLOBALS['TYPO3_DB']->exec_DELETEquery(
                'sys_todos', 
                'uid=' . intval($key)
            );
         
         **Selecting a record:**
         
         Call exec\_SELECTquery() with at least the first three arguments
         (field list to select, table name and WHERE clause). The return value
         is a result pointer (or object) which should be passed to
         ->sql\_fetch\_assoc() in a loop in order to traverse the result rows.
         
         ::
         
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


.. container:: table-row

   Function
         $GLOBALS['BE\_USER']->
         
         isAdmin
   
   Comments
         **Return true if current backend user is "admin"**
         
         Use this if you need to restrict a user from doing something unless he
         is "admin".


.. container:: table-row

   Function
         $GLOBALS['BE\_USER']->
         
         getPagePermsClause
   
   Comments
         **Return WHERE clause for filtering pages which permission mismatch
         for current user**
         
         The most typical usage of this is to call the function with the value
         "1". Then the WHERE clause returned will filter away all pages to
         which the user has no read-access.


.. ###### END~OF~TABLE ######


TYPO3 Coding Guidelines
"""""""""""""""""""""""

You should also refer to the TYPO3 Core Coding Guidelines (CGL)
document which is the authoritative source to know about which coding
practices are required for TYPO3 core and extension programming. It
also contains some more information about recommended API usage.

