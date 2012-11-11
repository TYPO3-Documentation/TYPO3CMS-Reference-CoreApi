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


.. _useful-t3lib-div:

t3lib\_div
""""""""""

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         t3lib\_div::inList
   :Comments:
         Check if an item exists in a comma-separated list of items. ::

            if (t3lib_div::inList('gif,jpg,png', $ext)) {//...}


 - :Function:
         t3lib\_div::intInRange

         t3lib\_utility\_Math::forceIntegerInRange (as of TYPO3 4.6)
   :Comments:
         Forces the input variable (integer) into the boundaries of $min and
         $max. ::

            t3lib_utility_Math::forceIntegerInRange($row['priority'], 1, 5);


 - :Function:
         t3lib\_div::isFirstPartOfStr
   :Comments:
         Returns true if the first part of input string matches the second
         argument. ::

            t3lib_div::isFirstPartOfStr($path, PATH_site);


 - :Function:
         t3lib\_div::testInt

         t3lib\_utility\_Math::canBeInterpretedAsInteger (as of TYPO3 4.6)
   :Comments:
         Tests if the input is an integer.


 - :Function:
         t3lib\_div::shortMD5

         t3lib\_div::md5int
   :Comments:
         Creates partial/truncated MD5 hashes. Useful when a 32 byte hash is
         too long or you rather work with an integer than a string.

         **t3lib\_div::shortMD5()** - Creates a 10 byte short MD5 hash of input
         string ::

            $addQueryParams.= '&myHash=' . t3lib_div::shortMD5(serialize($myArguments));

         **t3lib\_div::md5int()** - Creates an integer from the first 7 hex
         chars of the MD5 hash string ::

            'mpvar_hash' => t3lib_div::md5int($GLOBALS['TSFE']->MP),


 - :Function:
         t3lib\_div::deHSCentities

         t3lib\_div::htmlspecialchars\_decode
   :Comments:
         Reverse conversions of htmlspecialchars()

         **t3lib\_div::deHSCentities()** - Re-converts HTML entities if they
         have been converted by htmlspecialchars(). For instance "&amp;amp;"
         which should stay "&amp;". Or "&amp;#1234;" to "&#1234;". Or
         "&amp;#x1b;" to "&#x1b;" ::

            $value = t3lib_div::deHSCentities(htmlspecialchars($value));

         **t3lib\_div::htmlspecialchars\_decode()** - Inverse version of
         htmlspecialchars()


 - :Function:
         t3lib\_div::formatSize
   :Comments:
         Formats a number of bytes as Kb/Mb/Gb for visual output. ::

            $size = ' (' . t3lib_div::formatSize(filesize($v)) . 'bytes)';


 - :Function:
         t3lib\_div::validEmail
   :Comments:
         Evaluates a string as an email address. ::

            if ($email && t3lib_div::validEmail($email)) {


 - :Function:
         t3lib\_div::trimExplode

         t3lib\_div::intExplode

         t3lib\_div::revExplode
   :Comments:
         Various flavors of exploding a string by a token.

         **t3lib\_div::trimExplode()** - Explodes a string by a token and trims
         the whitespace away around each item. Optionally any zero-length
         elements are removed. Very often used to explode strings from
         configuration, user input etc. where whitespace can be expected
         between values but is insignificant. ::

            array_unique(t3lib_div::trimExplode(',', $rawExtList, 1));
            t3lib_div::trimExplode(chr(10), $content);

         **t3lib\_div::intExplode()** - Explodes a by a token and converts each
         item to an integer value. Very useful to force integer values out of a
         value list, for instance for an SQL query. ::

            // Make integer list
            implode(t3lib_div::intExplode(',', $row['subgroup']), ',');

         **t3lib\_div::revExplode()** - Reverse explode() which allows you to
         explode a string into X parts but from the back of the string instead. ::

            $p = t3lib_div::revExplode('/', $path, 2);


 - :Function:
         t3lib\_div::array\_merge\_recursive\_overrule

         t3lib\_div::array\_merge
   :Comments:
         Merging arrays with fixes for "PHP-bugs"

         **t3lib\_div::array\_merge\_recursive\_overrule()** - Merges two
         arrays recursively and "binary safe" (integer keys are overridden as
         well), overruling similar the values in the first array ($arr0) with
         the values of the second array ($arr1). In case of identical keys,
         i.e. keeping the values of the second.

         **t3lib\_div::array\_merge()** - An array\_merge function where the
         keys are NOT renumbered as they happen to be with the real php-
         array\_merge function. It is "binary safe" in the sense that integer
         keys are overridden as well.


 - :Function:
         t3lib\_div::array2xml\_cs

         t3lib\_div::xml2array
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

         **t3lib\_div::array2xml\_cs()** - Converts a PHP array into an XML
         string. ::

            t3lib_div::array2xml_cs($this->FORMCFG['c'],'T3FormWizard');

         **t3lib\_div::xml2array()** - Converts an XML string to a PHP array.
         This is the reverse function of array2xml() ::

            if ($this->xmlStorage)    {
                $cfgArr = t3lib_div::xml2array($row[$this->P['field']]);
            }


 - :Function:
         t3lib\_div::getURL

         t3lib\_div::writeFile
   :Comments:
         Reading / Writing files

         **t3lib\_div::getURL()** - Reads the full content of a file or URL.
         Used throughout the TYPO3 sources. Transparently takes care of Curl
         configuration, proxy setup, etc. ::

            $templateCode = t3lib_div::getURL($templateFile);

         **t3lib\_div::writeFile()** - Writes a string into an absolute
         filename. ::

            t3lib_div::writeFile($extDirPath . $theFile, $fileData['content']);


 - :Function:
         t3lib\_div::split\_fileref
   :Comments:
         Splits a reference to a file in 5 parts. Alternative to "path\_info"
         and fixes some "PHP-bugs" which makes page\_info() unattractive at
         times.


 - :Function:
         t3lib\_div::get\_dirs

         t3lib\_div::getFilesInDir

         t3lib\_div::getAllFilesAndFoldersInPath

         t3lib\_div::removePrefixPathFromList
   :Comments:
         Read content of file system directories.

         **t3lib\_div::get\_dirs()** - Returns an array with the names of
         folders in a specific path ::

            if (@is_dir($path))    {
                $directories = t3lib_div::get_dirs($path);
                if (is_array($directories))    {
                    foreach($directories as $dirName)    {
                        ...
                    }
                }
            }

         **t3lib\_div::getFilesInDir()** - Returns an array with the names of
         files in a specific path ::

            $sFiles = t3lib_div::getFilesInDir(PATH_typo3conf ,'', 1, 1);
            $files = t3lib_div::getFilesInDir($dir, 'png,jpg,gif');

         **t3lib\_div::getAllFilesAndFoldersInPath()** - Recursively gather all
         files and folders of a path.

         **t3lib\_div::removePrefixPathFromList()** - Removes the absolute part
         of all files/folders in fileArr (useful for post processing of content
         from t3lib\_div::getAllFilesAndFoldersInPath()) ::

                // Get all files with absolute paths prefixed:
            $fileList_abs =
                t3lib_div::getAllFilesAndFoldersInPath(array(), $absPath, 'php,inc');

                // Traverse files and remove abs path from each (becomes relative)
            $fileList_rel =
                t3lib_div::removePrefixPathFromList($fileList_abs, $absPath);


 - :Function:
         t3lib\_div::implodeArrayForUrl
   :Comments:
         Implodes a multidimensional array into GET-parameters (e.g.
         :code:`&param[key][key2]=value2&param[key][key3]=value3`) ::

            $pString = t3lib_div::implodeArrayForUrl('', $params);


 - :Function:
         t3lib\_div::get\_tag\_attributes

         t3lib\_div::implodeAttributes
   :Comments:
         Works on HTML tag attributes

         **t3lib\_div::get\_tag\_attributes()** - Returns an array with all
         attributes of the input HTML tag as key/value pairs. Attributes are
         only lowercase a-z ::

            $attribs = t3lib_div::get_tag_attributes('<' . $subparts[0] . '>');

         **t3lib\_div::implodeAttributes()** - Implodes attributes in the array
         $arr for an attribute list in e.g. and HTML tag (with quotes) ::

            $tag = '<img ' . t3lib_div::implodeAttributes($attribs, 1) . ' />';


 - :Function:
         t3lib\_div::resolveBackPath
   :Comments:
         Resolves :file:`../` sections in the input path string. For example
         :file:`fileadmin/directory/../other_directory/` will be resolved to
         :file:`fileadmin/other_directory/`


 - :Function:
         t3lib\_div::callUserFunction

         t3lib\_div::getUserObj
   :Comments:
         General purpose functions for calling user functions (creating hooks).

         See the chapter about :ref:`hooks-creation` in this
         document for detailed description of these functions.

         **t3lib\_div::callUserFunction()** - Calls a user-defined
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

                t3lib_div::callUserFunction(
                    $config['itemsProcFunc'],
                    $params,
                    $this
                );
                return $items;
            }

         **t3lib\_div::getUserObj()** - Creates and returns reference to a user
         defined object. ::

            $_procObj = &t3lib_div::getUserObj($_classRef);
            $_procObj->pObj = &$this;
            $value = $_procObj->transform_rte($value,$this);


 - :Function:
         t3lib\_div::linkThisScript
   :Comments:
         Returns the URL to the current script. You can pass an array with
         associative keys corresponding to the GET-vars you wish to add to the
         URL. If you set them empty, they will remove existing GET-vars from
         the current URL.


 - :Function:
         t3lib\_div::plainMailEncoded
   :Comments:
         Mail sending functions

         **t3lib\_div::plainMailEncoded()** - Simple substitute for the PHP
         function mail() which allows you to specify encoding and character
         set.


.. _useful-t3lib-befunc:

t3lib\_BEfunc
"""""""""""""

.. t3-field-list-table::
 :header-rows: 1


 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         t3lib\_BEfunc::getRecord

         t3lib\_BEfunc::getRecordsByField
   :Comments:
         Functions for selecting records by uid or field value.

         **t3lib\_BEfunc::getRecord()** - Gets record with :code:`uid=$uid` from :code:`$table` ::

              // Getting array with title field from a page:
            t3lib_BEfunc::getRecord('pages', intval($row['shortcut']), 'title');

              // Getting a full record with permission WHERE clause
            $pageinfo = t3lib_BEfunc::getRecord(
                    'pages',
                    $id,
                    '*',
                    ($perms_clause ? ' AND ' . $perms_clause : '')
                );

         **t3lib\_BEfunc::getRecordsByField()** - Returns records from table,
         :code:`$theTable`, where a field ($theField) equals the value, $theValue ::

                // Checking if the id-parameter is an alias.
            if (!t3lib_div::testInt($id))    {
                list($idPartR) =
                    t3lib_BEfunc::getRecordsByField('pages', 'alias', $id);
                $id = intval($idPartR['uid']);
            }


 - :Function:
         t3lib\_BEfunc::getRecordPath
   :Comments:
         Returns the path (visually) of a page $uid, fx. "/First page/Second
         page/Another subpage" ::

            $label = t3lib_BEfunc::getRecordPath(
                    intval($row['shortcut']),
                    $perms_clause,
                    20
                );


 - :Function:
         t3lib\_BEfunc::readPageAccess
   :Comments:
         Returns a page record (of page with $id) with an extra field
         :code:`_thePath` set to the record path *if* the WHERE clause,
         $perms\_clause, selects the record. Thus is works as an access check
         that returns a page record if access was granted, otherwise not. ::

            $perms_clause = $GLOBALS['BE_USER']->getPagePermsClause(1);
            $pageinfo = t3lib_BEfunc::readPageAccess($id, $perms_clause);


 - :Function:
         t3lib\_BEfunc::date

         t3lib\_BEfunc::datetime

         t3lib\_BEfunc::calcAge
   :Comments:
         Date/Time formatting functions using date/time format from
         :code:`$TYPO3_CONF_VARS`.

         **t3lib\_BEfunc::date()** - Returns $tstamp formatted as "ddmmyy"
         (According to :code:`$TYPO3_CONF_VARS['SYS']['ddmmyy']`) ::

            t3lib_BEfunc::datetime($row['crdate'])

         **t3lib\_BEfunc::datetime()** - Returns $tstamp formatted as "ddmmyy
         hhmm" (According to :code:`$TYPO3_CONF_VARS['SYS']['ddmmyy']` and
         :code:`$TYPO3_CONF_VARS['SYS']['hhmm']`) ::

            t3lib_BEfunc::datetime($row['item_mtime'])

         **t3lib\_BEfunc::calcAge()** - Returns the "age" in minutes / hours /
         days / years of the number of :code:`$seconds` given as input. ::

            $agePrefixes = ' min| hrs| days| yrs';
            t3lib_BEfunc::calcAge(time()-$row['crdate'], $agePrefixes);


 - :Function:
         t3lib\_BEfunc::titleAttribForPages
   :Comments:
         Returns title attribute information for a page-record informing about
         id, alias, doktype, hidden, starttime, endtime, fe\_group etc. ::

            $out = t3lib_BEfunc::titleAttribForPages($row, '', 0);
            $out = t3lib_BEfunc::titleAttribForPages($row, '1=1 ' . $this->clause, 0);


 - :Function:
         t3lib\_BEfunc::thumbCode

         t3lib\_BEfunc::getThumbNail
   :Comments:
         Returns image tags for thumbnails

         **t3lib\_BEfunc::thumbCode()** - Returns a linked image-tag for
         thumbnail(s)/fileicons/truetype-font-previews from a database row with
         a list of image files in a field. Slightly advanced. It's more likely
         you will need :code:`t3lib_BEfunc::getThumbNail()` to do the job.

         **t3lib\_BEfunc::getThumbNail()** - Returns single image tag to
         thumbnail using a thumbnail script (like :file:`thumbs.php`) ::

            t3lib_BEfunc::getThumbNail(
                $this->doc->backPath . 'thumbs.php',
                $filepath,
                'hspace="5" vspace="5" border="1"'
            );


 - :Function:
         t3lib\_BEfunc::storeHash

         t3lib\_BEfunc::getHash
   :Comments:
         Get/Set cache values.

         **t3lib\_BEfunc::storeHash()** - Stores the string value :code:`$data` in the
         "cache hash" table with the hash key, :code:`$hash`, and visual/symbolic
         identification, :code:`$ident`.

         **t3lib\_BEfunc::getHash()** - Retrieves the string content stored
         with hash key, :code:`$hash`, in "cache hash".

         Example of how both functions are used together; first :code:`getHash()` to
         fetch any possible content and if nothing was found how the content is
         generated and stored in the cache::

                // Parsing the user TS (or getting from cache)
            $userTS = implode($TSdataArray,chr(10) . '[GLOBAL]' . chr(10));
            $hash = md5('pageTS:' . $userTS);
            $cachedContent = t3lib_BEfunc::getHash($hash, 0);
            $TSconfig = array();
            if (isset($cachedContent))    {
                $TSconfig = unserialize($cachedContent);
            } else {
                $parseObj = t3lib_div::makeInstance('t3lib_TSparser');
                $parseObj->parse($userTS);
                $TSconfig = $parseObj->setup;
                t3lib_BEfunc::storeHash($hash,serialize($TSconfig), 'IDENT');
            }


 - :Function:
         t3lib\_BEfunc::getRecordTitle

         t3lib\_BEfunc::getProcessedValue
   :Comments:
         **t3lib\_BEfunc::getRecordTitle()** - Returns the "title" value from
         the input records field content. ::

            $line.= t3lib_BEfunc::getRecordTitle('tt_content', $row, 1);

         **t3lib\_BEfunc::getProcessedValue()** - Returns a human readable
         output of a value from a record. For instance a database record
         relation would be looked up to display the title-value of that record.
         A checkbox with a "1" value would be "Yes", etc. ::

            $outputValue = nl2br(
                htmlspecialchars(
                    trim(
                        t3lib_div::fixed_lgd_cs(
                            t3lib_BEfunc::getProcessedValue(
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
         t3lib\_BEfunc::getPagesTSconfig
   :Comments:
         Returns the Page TSconfig for page with id, $id.

         This example shows how an object path, :code:`mod.web_list` is extracted
         from the Page TSconfig for page $id::

            $modTSconfig = $GLOBALS['BE_USER']->getTSConfig(
                'mod.web_list',
                t3lib_BEfunc::getPagesTSconfig($id)
            );



.. _useful-t3lib-extmgm:

t3lib\_extMgm
"""""""""""""

.. t3-field-list-table::
 :header-rows: 1


 - :Function,30: Function
   :Comments,70: Comments


 - :Function:
         t3lib\_extMgm::addTCAcolumns
   :Comments:
         Adding fields to an existing table definition in $TCA

         For usage in :file:`ext_tables.php` files ::

                // tt_address modified
            t3lib_div::loadTCA('tt_address');
            t3lib_extMgm::addTCAcolumns('tt_address', array(
                     'module_sys_dmail_category' =>
                        array('config' => array('type' => 'passthrough')),
                    'module_sys_dmail_html' =>
                        array('config' => array('type' => 'passthrough'))
            ));


 - :Function:
         t3lib\_extMgm::addToAllTCAtypes
   :Comments:
         Makes fields visible in the TCEforms by adding them to all or selected
         "types"-configurations

         For usage in :file:`ext_tables.php` files ::

            t3lib_extMgm::addToAllTCAtypes(
                'fe_users',
                'tx_myext_newfield;;;;1-1-1, tx_myext_another_field'
            );


 - :Function:
         t3lib\_extMgm::allowTableOnStandardPages
   :Comments:
         Add table name to default list of allowed tables on pages (in
         $PAGES\_TYPES)

         For usage in :file:`ext_tables.php` files ::

            t3lib_extMgm::allowTableOnStandardPages('tt_board');


 - :Function:
         t3lib\_extMgm::addModule
   :Comments:
         Adds a module (main or sub) to the backend interface.

         .. note::
            Extbase-based modules use a different registration API.

         For usage in :file:`ext_tables.php` files ::

            t3lib_extMgm::addModule(
                'user',
                'setup',
                'after:task',
                t3lib_extMgm::extPath($_EXTKEY) . 'mod/'
            );

            t3lib_extMgm::addModule(
                'tools',
                'txcoreunittestM1',
                '',
                t3lib_extMgm::extPath($_EXTKEY) . 'mod1/'
            );


 - :Function:
         t3lib\_extMgm::insertModuleFunction
   :Comments:
         Adds a "Function menu module" ("third level module") to an existing
         function menu for some other backend module

         For usage in :file:`ext_tables.php` files ::

            t3lib_extMgm::insertModuleFunction(
                'web_func',
                'tx_cmsplaintextimport_webfunc',
                t3lib_extMgm::extPath($_EXTKEY) .
                    'class.tx_cmsplaintextimport_webfunc.php',
                'LLL:EXT:cms_plaintext_import/locallang.php:menu_1'
            );


 - :Function:
         t3lib\_extMgm::addPlugin
   :Comments:
         Adds an entry to the list of plugins in content elements of type
         "Insert plugin"

         .. note::
            Extbase-based plug-ins use a different registration API.

         For usage in :file:`ext_tables.php` files ::

            t3lib_extMgm::addPlugin(
                array(
                    'LLL:EXT:newloginbox/locallang_db.php:tt_content.list_type1',
                    $_EXTKEY . '_pi1'
                ),
                'list_type'
            );


 - :Function:
         t3lib\_extMgm::addPItoST43
   :Comments:
         Add PlugIn to Static Template #43

         When adding a frontend plugin you will have to add both an entry to
         the TCA definition of :code:`tt_content` table AND to the TypoScript template
         which must initiate the rendering. Since the static template with uid
         43 is the "content.default" and practically always used for rendering
         the content elements it's very useful to have this function
         automatically adding the necessary TypoScript for calling your plugin.
         It will also work for the extension "css\_styled\_content"

         For usage in :file:`ext_localconf.php` files ::

            t3lib_extMgm::addPItoST43($_EXTKEY);

