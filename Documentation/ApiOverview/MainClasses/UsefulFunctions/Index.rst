.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt






.. _useful-functions:

Functions typically used and nice to know
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

These functions are generally just nice to know. They provide
functionality which you will often need in TYPO3 applications and
therefore they will save you time and make your applications easier
for others to understand as well since you use commonly known
functions.

Please take time to learn these functions!


.. _useful-general-utility:

\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility
"""""""""""""""""""""""""""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`inList`
   :Comments:
         Check if an item exists in a comma-separated list of items. ::

            if (\TYPO3\CMS\Core\Utility\GeneralUtility::inList('gif,jpg,png', $ext)) {//...}


 - :Function:
         :code:`isFirstPartOfStr`
   :Comments:
         Returns true if the first part of input string matches the second
         argument. ::

            \TYPO3\CMS\Core\Utility\GeneralUtility::isFirstPartOfStr($path, PATH_site);


 - :Function:
         :code:`formatSize`
   :Comments:
         Formats a number of bytes as Kb/Mb/Gb for visual output. ::

            $size = ' (' . \TYPO3\CMS\Core\Utility\GeneralUtility::formatSize(filesize($v)) . 'bytes)';


 - :Function:
         :code:`validEmail`
   :Comments:
         Evaluates a string as an email address. ::

            if ($email && \TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($email)) {


 - :Function:
         :code:`trimExplode`

         :code:`intExplode`

         :code:`revExplode`
   :Comments:
         Various flavors of exploding a string by a token.

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode()` - Explodes a string by a token and trims
         the whitespace away around each item. Optionally any zero-length
         elements are removed. Very often used to explode strings from
         configuration, user input etc. where whitespace can be expected
         between values but is insignificant. ::

            array_unique(\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $rawExtList, 1));
            \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(chr(10), $content);

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode()` - Explodes a by a token and converts each
         item to an integer value. Very useful to force integer values out of a
         value list, for instance for an SQL query. ::

            // Make integer list
            implode(\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $row['subgroup']), ',');

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::revExplode()` - Reverse explode() which allows you to
         explode a string into X parts but from the back of the string instead. ::

            $p = \TYPO3\CMS\Core\Utility\GeneralUtility::revExplode('/', $path, 2);


 - :Function:
         :code:`array_merge_recursive_overrule`

         :code:`array_merge`
   :Comments:
         Merging arrays with fixes for "PHP-bugs"

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::array_merge_recursive_overrule()` - Merges two
         arrays recursively and "binary safe" (integer keys are overridden as
         well), overruling similar the values in the first array ($arr0) with
         the values of the second array ($arr1). In case of identical keys,
         i.e. keeping the values of the second.

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::array_merge()` - An array\_merge function where the
         keys are NOT renumbered as they happen to be with the real php-
         array\_merge function. It is "binary safe" in the sense that integer
         keys are overridden as well.


 - :Function:
         :code:`array2xml_cs`

         :code:`xml2array`
   :Comments:
         Serialization of PHP variables into XML.

         These functions are made to serialize and unserialize PHParrays to XML
         files. They are used for the FlexForms content in TYPO3, Data
         Structure definitions etc. The XML output is optimized for readability
         since associative keys are used as tagnames. This also means that only
         alphanumeric characters are allowed in the tag names andonly keys
         *not* starting with numbers (so watch your usage of keys!). However
         there are options you can set to avoid this problem. Numeric keys are
         stored with the default tagname "numIndex" but can be overridden to
         other formats). The function handles input values from the PHP array
         in a binary-safe way; All characters below 32 (except 9,10,13) will
         trigger the content to be converted to a base64-string. The PHP
         variable type of the data is preserved as long as the types are
         strings, arrays, integers and booleans. Strings are the default type
         unless the "type" attribute is set.

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::array2xml_cs()` - Converts a PHP array into an XML
         string::

            \TYPO3\CMS\Core\Utility\GeneralUtility::array2xml_cs($this->FORMCFG['c'],'T3FormWizard');

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::xml2array()` - Converts an XML string to a PHP array.
         This is the reverse function of :code:`array2xml_cs()`::

            if ($this->xmlStorage)    {
                $cfgArr = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($row[$this->P['field']]);
            }


 - :Function:
         :code:`getURL`

         :code:`writeFile`
   :Comments:
         Reading / Writing files

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getURL()` - Reads the full content of a file or URL.
         Used throughout the TYPO3 sources. Transparently takes care of Curl
         configuration, proxy setup, etc. ::

            $templateCode = \TYPO3\CMS\Core\Utility\GeneralUtility::getURL($templateFile);

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::writeFile()` - Writes a string into an absolute
         filename::

            \TYPO3\CMS\Core\Utility\GeneralUtility::writeFile($extDirPath . $theFile, $fileData['content']);


 - :Function:
         :code:`split_fileref`
   :Comments:
         Splits a reference to a file in 5 parts. Alternative to "path\_info"
         and fixes some "PHP-bugs" which makes :code:`page_info()` unattractive at
         times.


 - :Function:
         :code:`get_dirs`

         :code:`getFilesInDir`

         :code:`getAllFilesAndFoldersInPath`

         :code:`removePrefixPathFromList`
   :Comments:
         Read content of file system directories.

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::get_dirs()` - Returns an array with the names of
         folders in a specific path ::

            if (@is_dir($path))    {
                $directories = \TYPO3\CMS\Core\Utility\GeneralUtility::get_dirs($path);
                if (is_array($directories))    {
                    foreach($directories as $dirName)    {
                        ...
                    }
                }
            }

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getFilesInDir()` - Returns an array with the names of
         files in a specific path ::

            $sFiles = \TYPO3\CMS\Core\Utility\GeneralUtility::getFilesInDir(PATH_typo3conf ,'', 1, 1);
            $files = \TYPO3\CMS\Core\Utility\GeneralUtility::getFilesInDir($dir, 'png,jpg,gif');

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getAllFilesAndFoldersInPath()` - Recursively gather all
         files and folders of a path.

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::removePrefixPathFromList()` - Removes the absolute part
         of all files/folders in fileArr (useful for post processing of content
         from :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getAllFilesAndFoldersInPath()`) ::

                // Get all files with absolute paths prefixed:
            $fileList_abs =
                \TYPO3\CMS\Core\Utility\GeneralUtility::getAllFilesAndFoldersInPath(array(), $absPath, 'php,inc');

                // Traverse files and remove abs path from each (becomes relative)
            $fileList_rel =
                \TYPO3\CMS\Core\Utility\GeneralUtility::removePrefixPathFromList($fileList_abs, $absPath);


 - :Function:
         :code:`implodeArrayForUrl`
   :Comments:
         Implodes a multidimensional array into GET-parameters (e.g.
         :code:`&param[key][key2]=value2&param[key][key3]=value3`) ::

            $pString = \TYPO3\CMS\Core\Utility\GeneralUtility::implodeArrayForUrl('', $params);


 - :Function:
         :code:`get_tag_attributes`

         :code:`implodeAttributes`
   :Comments:
         Works on HTML tag attributes

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::get_tag_attributes()` - Returns an array with all
         attributes of the input HTML tag as key/value pairs. Attributes are
         only lowercase a-z ::

            $attribs = \TYPO3\CMS\Core\Utility\GeneralUtility::get_tag_attributes('<' . $subparts[0] . '>');

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::implodeAttributes()` - Implodes attributes in the array
         $arr for an attribute list in e.g. and HTML tag (with quotes) ::

            $tag = '<img ' . \TYPO3\CMS\Core\Utility\GeneralUtility::implodeAttributes($attribs, 1) . ' />';


 - :Function:
         :code:`resolveBackPath`
   :Comments:
         Resolves :file:`../` sections in the input path string. For example
         :file:`fileadmin/directory/../other_directory/` will be resolved to
         :file:`fileadmin/other_directory/`


 - :Function:
         :code:`callUserFunction`

         :code:`getUserObj`
   :Comments:
         General purpose functions for calling user functions (creating hooks).

         See the chapter about :ref:`hooks-creation` in this
         document for detailed description of these functions.

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()` - Calls a user-defined
         function/method in class. Such a function/method should look like
         this: :code:`function proc(&$params, &$ref) {...}` ::

            function procItems($items,$iArray,$config,$table,$row,$field) {
                global $TCA;
                $params=array();
                $params['items'] = &$items;
                $params['config'] = $config;
                $params['TSconfig'] = $iArray;
                $params['table'] = $table;
                $params['row'] = $row;
                $params['field'] = $field;

                \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction(
                    $config['itemsProcFunc'],
                    $params,
                    $this
                );
                return $items;
            }

         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getUserObj()` - Creates and returns reference to a user
         defined object::

            $_procObj = &\TYPO3\CMS\Core\Utility\GeneralUtility::getUserObj($_classRef);
            $_procObj->pObj = &$this;
            $value = $_procObj->transform_rte($value,$this);


 - :Function:
         :code:`linkThisScript`
   :Comments:
         Returns the URL to the current script. You can pass an array with
         associative keys corresponding to the GET-vars you wish to add to the
         URL. If you set them empty, they will remove existing GET-vars from
         the current URL.


.. _useful-math-utility:

\\TYPO3\\CMS\\Core\\Utility\\MathUtility
""""""""""""""""""""""""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1


 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`forceIntegerInRange`
   :Comments:
         Forces the input variable (integer) into the boundaries of $min and
         $max::

            \TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($row['priority'], 1, 5);


 - :Function:
         :code:`canBeInterpretedAsInteger`
   :Comments:
         Tests if the input is an integer.


.. _useful-backend-utility:

\\TYPO3\\CMS\\Backend\\Utility\\BackendUtility
""""""""""""""""""""""""""""""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1


 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`getRecord`

         :code:`getRecordsByField`
   :Comments:
         Functions for selecting records by uid or field value.

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::getRecord()` - Gets record with :code:`uid=$uid` from :code:`$table` ::

              // Getting array with title field from a page:
			\TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('pages', intval($row['shortcut']), 'title');

              // Getting a full record with permission WHERE clause
            $pageinfo = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord(
                    'pages',
                    $id,
                    '*',
                    ($perms_clause ? ' AND ' . $perms_clause : '')
                );

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::getRecordsByField()` - Returns records from table,
         :code:`$theTable`, where a field ($theField) equals the value, $theValue ::

                // Checking if the id-parameter is an alias.
            if (!\TYPO3\CMS\Core\Utility\GeneralUtility::testInt($id))    {
                list($idPartR) =
                    \TYPO3\CMS\Backend\Utility\BackendUtility::getRecordsByField('pages', 'alias', $id);
                $id = intval($idPartR['uid']);
            }


 - :Function:
         :code:`getRecordPath`
   :Comments:
         Returns the path (visually) of a page $uid, fx. "/First page/Second
         page/Another subpage" ::

            $label = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecordPath(
                    intval($row['shortcut']),
                    $perms_clause,
                    20
                );


 - :Function:
         :code:`readPageAccess`
   :Comments:
         Returns a page record (of page with $id) with an extra field
         :code:`_thePath` set to the record path *if* the WHERE clause,
         $perms\_clause, selects the record. Thus is works as an access check
         that returns a page record if access was granted, otherwise not. ::

            $perms_clause = $GLOBALS['BE_USER']->getPagePermsClause(1);
            $pageinfo = \TYPO3\CMS\Backend\Utility\BackendUtility::readPageAccess($id, $perms_clause);


 - :Function:
         :code:`date`

         :code:`datetime`

         :code:`calcAge`
   :Comments:
         Date/Time formatting functions using date/time format from
         :code:`$TYPO3_CONF_VARS`.

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::date()` - Returns $tstamp formatted as "ddmmyy"
         (According to :code:`$TYPO3_CONF_VARS['SYS']['ddmmyy']`) ::

            \TYPO3\CMS\Backend\Utility\BackendUtility::datetime($row['crdate'])

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::datetime()` - Returns $tstamp formatted as "ddmmyy
         hhmm" (According to :code:`$TYPO3_CONF_VARS['SYS']['ddmmyy']` and
         :code:`$TYPO3_CONF_VARS['SYS']['hhmm']`) ::

            \TYPO3\CMS\Backend\Utility\BackendUtility::datetime($row['item_mtime'])

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::calcAge()` - Returns the "age" in minutes / hours /
         days / years of the number of :code:`$seconds` given as input. ::

            $agePrefixes = ' min| hrs| days| yrs';
            \TYPO3\CMS\Backend\Utility\BackendUtility::calcAge(time()-$row['crdate'], $agePrefixes);


 - :Function:
         :code:`titleAttribForPages`
   :Comments:
         Returns title attribute information for a page-record informing about
         id, alias, doktype, hidden, starttime, endtime, fe\_group etc. ::

            $out = \TYPO3\CMS\Backend\Utility\BackendUtility::titleAttribForPages($row, '', 0);
            $out = \TYPO3\CMS\Backend\Utility\BackendUtility::titleAttribForPages($row, '1=1 ' . $this->clause, 0);


 - :Function:
         :code:`thumbCode`

         :code:`getThumbNail`
   :Comments:
         Returns image tags for thumbnails

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::thumbCode()` - Returns a linked image-tag for
         thumbnail(s)/fileicons/truetype-font-previews from a database row with
         a list of image files in a field. Slightly advanced. It's more likely
         you will need :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::getThumbNail()` to do the job.

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::getThumbNail()` - Returns single image tag to
         thumbnail using a thumbnail script (like :file:`thumbs.php`) ::

            \TYPO3\CMS\Backend\Utility\BackendUtility::getThumbNail(
                $this->doc->backPath . 'thumbs.php',
                $filepath,
                'hspace="5" vspace="5" border="1"'
            );


 - :Function:
         :code:`storeHash`

         :code:`getHash`
   :Comments:
         Get/Set cache values.

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::storeHash()` - Stores the string value :code:`$data` in the
         "cache hash" table with the hash key, :code:`$hash`, and visual/symbolic
         identification, :code:`$ident`.

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::getHash()` - Retrieves the string content stored
         with hash key, :code:`$hash`, in "cache hash".

         Example of how both functions are used together; first :code:`getHash()` to
         fetch any possible content and if nothing was found how the content is
         generated and stored in the cache::

                // Parsing the user TS (or getting from cache)
            $userTS = implode($TSdataArray,chr(10) . '[GLOBAL]' . chr(10));
            $hash = md5('pageTS:' . $userTS);
            $cachedContent = \TYPO3\CMS\Backend\Utility\BackendUtility::getHash($hash, 0);
            $TSconfig = array();
            if (isset($cachedContent))    {
                $TSconfig = unserialize($cachedContent);
            } else {
                $parseObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser');
                $parseObj->parse($userTS);
                $TSconfig = $parseObj->setup;
                \TYPO3\CMS\Backend\Utility\BackendUtility::storeHash($hash,serialize($TSconfig), 'IDENT');
            }


 - :Function:
         :code:`getRecordTitle`

         :code:`getProcessedValue`
   :Comments:
         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::getRecordTitle()` - Returns the "title" value from
         the input records field content. ::

            $line.= \TYPO3\CMS\Backend\Utility\BackendUtility::getRecordTitle('tt_content', $row, 1);

         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::getProcessedValue()` - Returns a human readable
         output of a value from a record. For instance a database record
         relation would be looked up to display the title-value of that record.
         A checkbox with a "1" value would be "Yes", etc. ::

            $outputValue = nl2br(
                htmlspecialchars(
                    trim(
                        \TYPO3\CMS\Core\Utility\GeneralUtility::fixed_lgd_cs(
                            \TYPO3\CMS\Backend\Utility\BackendUtility::getProcessedValue(
                                $table,
                                $fieldName,
                                $row[$fieldName]
                            ),
                            250
                        )
                    )
                )
            );


 - :Function:
         :code:`getPagesTSconfig`
   :Comments:
         Returns the Page TSconfig for page with id, $id.

         This example shows how an object path, :code:`mod.web_list` is extracted
         from the Page TSconfig for page $id::

            $modTSconfig = $GLOBALS['BE_USER']->getTSConfig(
                'mod.web_list',
                \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($id)
            );



.. _useful-extension-management-utility:

\\TYPO3\\CMS\\Core\\Utility\\ExtensionManagementUtility
"""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1


 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         :code:`addTCAcolumns`
   :Comments:
         Adding fields to an existing table definition in $TCA

         For usage in :file:`ext_tables.php` or :file:`Configuration/TCA/Overrides` files.

         .. code-block:: php

			// tt_address modified
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
				'tt_address',
				array(
					'module_sys_dmail_category' => array('config' => array('type' => 'passthrough')),
					'module_sys_dmail_html' => array('config' => array('type' => 'passthrough'))
				)
			);


 - :Function:
         :code:`addToAllTCAtypes`
   :Comments:
         Makes fields visible in the TCEforms by adding them to all or selected
         "types"-configurations

         For usage in :file:`ext_tables.php` or :file:`Configuration/TCA/Overrides` files.

         .. code-block:: php

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
				'fe_users',
				'tx_myext_newfield;;;;1-1-1, tx_myext_another_field'
			);


 - :Function:
         :code:`allowTableOnStandardPages`
   :Comments:
         Add table name to default list of allowed tables on pages (in
         $PAGES\_TYPES)

         For usage in :file:`ext_tables.php` files.

         .. code-block:: php

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tt_board');


 - :Function:
         :code:`addModule`
   :Comments:
         Adds a module (main or sub) to the backend interface.

         .. note::

            Extbase-based modules use a different registration API.

         For usage in :file:`ext_tables.php` files.

         .. code-block:: php

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
				'user',
				'setup',
				'after:task',
				\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod/'
			);

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
				'tools',
				'txcoreunittestM1',
				'',
				\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod1/'
			);


 - :Function:
         :code:`insertModuleFunction`
   :Comments:
         Adds a "Function menu module" ("third level module") to an existing
         function menu for some other backend module

         For usage in :file:`ext_tables.php` files.

         .. code-block:: php

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
				'web_func',
				'tx_cmsplaintextimport_webfunc',
				\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) .
					'class.tx_cmsplaintextimport_webfunc.php',
				'LLL:EXT:cms_plaintext_import/locallang.xlf:menu_1'
			);


 - :Function:
         :code:`addPlugin`
   :Comments:
         Adds an entry to the list of plugins in content elements of type
         "Insert plugin"

         .. note::

            Extbase-based plug-ins use a different registration API.

         For usage in :file:`ext_tables.php` files.

         .. code-block:: php

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
				array(
					'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
					$_EXTKEY . '_pi1'
				),
				'list_type'
			);


 - :Function:
         :code:`addPItoST43`
   :Comments:
         Add PlugIn to Static Template #43

         When adding a frontend plugin you will have to add both an entry to
         the TCA definition of :code:`tt_content` table AND to the TypoScript template
         which must initiate the rendering. Since the static template with uid
         43 is the "content.default" and practically always used for rendering
         the content elements it's very useful to have this function
         automatically adding the necessary TypoScript for calling your plugin.
         It will also work for the extension "css\_styled\_content"

         For usage in :file:`ext_localconf.php` files.

         .. code-block:: php

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY);
