

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


Database: t3lib\_TCEmain basics
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

When you are using TCE from your backend applications you need to
prepare two arrays of information which contain the instructions to
TCEmain of what actions to perform. They fall into two categories:
Data and Commands.

"Data" is when you want to write information to a database table or
create a new record.

"Commands" is when you want to move, copy or delete a record in the
system.

The data and commands are created as multidimensional arrays and to
understand the API of TCEmain you simply need to understand the
hierarchy of these two arrays.


Commands Array ($cmd):
""""""""""""""""""""""

Syntax:

::

   $cmd[ tablename ][ uid ][ command ] = value

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
         tablename
   
   Data type
         string
   
   Description
         Name of the database table. Must be configured in $TCA array,
         otherwise it cannot be processed.


.. container:: table-row

   Key
         uid
   
   Data type
         integer
   
   Description
         The UID of the record that is manipulated. This is always an integer.


.. container:: table-row

   Key
         command
   
   Data type
         string (command keyword)
   
   Description
         The command type you want to execute.
         
         **Notice:** Only  *one* command can be executed at a time for each
         record! The first command in the array will be taken.
         
         *See table below for command keywords and values*


.. container:: table-row

   Key
         value
   
   Data type
         mixed
   
   Description
         The value for the command
         
         *See table below for command keywords and values*


.. ###### END~OF~TABLE ######

Command keywords and values:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Command
         Command
   
   Data type
         Data type
   
   Value
         Value


.. container:: table-row

   Command
         copy
   
   Data type
         integer
   
   Value
         The significance of the value depends on whether it is positive or
         negative:
         
         - Positive value: The value points to a page UID. A copy of the record
           (and possibly child elements/tree below) will be inserted inside that
           page as the first element.
         
         - Negative value: The (absolute) value points to another record from the
           same table as the record being copied. The new record will be inserted
           on the same page as that record and if $TCA[...]['ctrl']['sortby'] is
           set, then it will be positioned  *after* .
         
         - Zero value: Record is inserted on tree root level


.. container:: table-row

   Command
         move
   
   Data type
         integer
   
   Value
         Works like "copy" but moves the record instead of making a copy.


.. container:: table-row

   Command
         delete
   
   Data type
         "1"
   
   Value
         Value should always be "1"
         
         This action will delete the record (or mark the record "deleted" if
         configured in $TCA)


.. container:: table-row

   Command
         undelete
   
   Data type
         “1”
   
   Value
         Value should always be "1".
         
         This action will set the deleted-flag back to 0.


.. container:: table-row

   Command
         localize
   
   Data type
         integer
   
   Value
         Pointer to a “sys\_language” uid to localize the record into.
         Basically a localization of a record is making a copy of the record
         (possibly excluding certain fields defined with “l10n\_mode”) but
         changing relevant fields to point to the right sys language / original
         language record.
         
         Requirements for a successful localization is this:
         
         - [ctrl] options “languageField” and “transOrigPointerField” must be
           defined for the table
         
         - A “sys\_language” record with the given “sys\_language\_uid” must
           exist.
         
         - The record to be localized by currently be set to “Default” language
           and not have any value set for the “transOrigPointerField” either.
         
         - There cannot exist another localization to the given language for the
           record (looking in the original record PID).
         
         Apart from this ordinary permissions apply as if the user wants to
         make a copy of the record on the same page.


.. container:: table-row

   Command
         version
   
   Data type
         array
   
   Value
         Versioning action.
         
         **Keys:**
         
         - [action] : Keyword determining the versioning action. Options are:
           
           - “new” : Indicates that a new version of the record should be
             created.Additional keys, specific for “new” action:
             
             - [treeLevels] :  *(Only pages)* Integer, -1 to 4, indicating the number
               of levels of the page tree to version together with a page. This is
               also referred to as the versioning type:-1 (“element”) means only the
               page record gets versioned (default)0 (“page”) means the page +
               content tables (defined by ctrl-flag “versioning\_followPages”)>0
               (“branch”) means the the whole branch is versioned ( *full copy* of
               all tables), down to the level indicated by the value (1= 1 level
               down, 2= 2 levels down, etc.)The treeLevel is recorded in the field
               “t3ver\_swapmode” and will be observed when the record is swapped
               during publishing.
             
             - [label] : Indicates the version label to apply. If not given, a
               standard label including version number and date is added.
           
           - “swap” : Indicates that the current online version should be swapped
             with another.Additional keys, specific for “swap” action:
             
             - [swapWith] : Indicates the uid of the record to swap current version
               with!
             
             - [swapIntoWS]: Boolean, indicates that when a version is published it
               should be swapped into the workspace of the offline record.
           
           - “clearWSID” : Indicates that the workspace of the record should be set
             to zero (0). This removes versions out of workspaces without
             publishing them.
           
           - “flush” : Completely deletes a version without publishing it.
           
           - “setStage” : Sets the stage of an element. *Special feature: The id-
             key in the array can be a comma list of ids in order to perform the
             stageChange over a number of records. Also, the internal variable
             ->generalComment (also available through tce\_db.php as
             "&generalComment") can be used to set a default comment for all stage
             changes of an instance of tcemain.* Additional keys for this action
             is:
             
             - [stageId] : Values are: -1 (rejected), 0 (editing, default), 1
               (review), 10 (publish)
             
             - [comment] : Comment string that goes into the log.


.. ###### END~OF~TABLE ######


Examples of commands:
~~~~~~~~~~~~~~~~~~~~~

::

   $cmd['tt_content'][54]['delete'] = 1;    // Deletes tt_content record with uid=54
   $cmd['pages'][1203]['copy'] = -303;   //Copies page id=1203 to the position after page 303
   $cmd['pages'][1203]['move'] = 303;  // Moves page id=1203 to the first position in page 303


Data Array ($data):
"""""""""""""""""""

Syntax:

::

   $data[ tablename ][ uid ][ fieldname ] = value

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
         tablename
   
   Data type
         string
   
   Description
         Name of the database table. Must be configured in $TCA array,
         otherwise it cannot be processed.


.. container:: table-row

   Key
         uid
   
   Data type
         mixed
   
   Description
         The UID of the record that is modified. If the record already exists,
         this is an integer. If you're creating new records, use a random
         string prefixed with "NEW", e.g. "NEW7342abc5e6d".


.. container:: table-row

   Key
         fieldname
   
   Data type
         string
   
   Description
         Name of the database field you want to set a value for. Must be
         configure in $TCA[  *tablename* ]['columns']


.. container:: table-row

   Key
         value
   
   Data type
         string
   
   Description
         Value for "fieldname".
         
         (Always make sure $this->stripslashes\_values is false before using
         TCEmain.)


.. ###### END~OF~TABLE ######

**Notice:** For FlexForms the data array of the FlexForm field is
deeper than three levels. The number of possible levels for FlexForms
is infinite and defined by the data structure of the FlexForm. But
FlexForm fields always end with a "regular value" of course.


Examples of Data submission:
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This creates a new page titled "The page title" as the first page
inside page id 45:

::

   $data['pages']['NEW9823be87'] = array(
       'title' => 'The page title',
       'subtitle' => 'Other title stuff',
       'pid' => '45'
   );

This creates a new page titled "The page title" right after page id 45
in the tree:

::

   $data['pages']['NEW9823be87'] = array(
       'title' => 'The page title',
       'subtitle' => 'Other title stuff',
       'pid' => '-45'
   );

This creates two new pages right after each other, located right after
the page id 45:

::

   $data['pages']['NEW9823be87'] = array(
       'title' => 'Page 1',
       'pid' => '-45'
   );
   $data['pages']['NEWbe68s587'] = array(
       'title' => 'Page 2',
       'pid' => '-NEW9823be87'
   );

Notice how the second "pid" value points to the "NEW..." id
placeholder of the first record. This works because the new id of the
first record can be accessed by the second record. However it works
only when the order in the array is as above since the processing
happens in that order!

This updates the page with uid=9834 to a new title, "New title for
this page", and no\_cache checked:

::

   $data['pages'][9834] = array(
       'title' => 'New title for this page',
       'no_cache' => '1'
   );


Clear cache
"""""""""""

TCE also has an API for clearing the cache tables of TYPO3:

Syntax:

::

   $tce->clear_cacheCmd($cacheCmd);

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   $cacheCmd values
         $cacheCmd values
   
   Description
         Description


.. container:: table-row

   $cacheCmd values
         [integer]
   
   Description
         Clear the cache for the page id given.


.. container:: table-row

   $cacheCmd values
         "all"
   
   Description
         Clears all cache tables (cache\_pages, cache\_pagesection,
         cache\_hash).
         
         Only available for admin-users unless explicitly allowed by User
         TSconfig "options.clearCache.all"


.. container:: table-row

   $cacheCmd values
         "pages"
   
   Description
         Clears all pages from cache\_pages.
         
         Only available for admin-users unless explicitly allowed by User
         TSconfig "options.clearCache.pages"


.. container:: table-row

   $cacheCmd values
         "temp\_CACHED"
   
   Description
         Clears the temp\_CACHED files in typo3conf/


.. ###### END~OF~TABLE ######


Hook for cache post-processing
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can configure cache post-processing with a user defined PHP
function. Configuration of the hook can be done from
(ext\_)localconf.php. An example might look like:

::

   $TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = 'myext_cacheProc->proc';
   require_once(t3lib_extMgm::extPath('myext') . 'class.myext_cacheProc.php');


Flags in TCEmain
""""""""""""""""

There are a few internal variables you can set prior to executing
commands or data submission. These are the most significant:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Internal variable
         Internal variable
   
   Data type
         Data type
   
   Description
         Description


.. container:: table-row

   Internal variable
         ->deleteTree
   
   Data type
         Boolean
   
   Description
         Sets whether a page tree branch can be recursively deleted.
         
         If this is set, then a page is deleted by deleting the whole branch
         under it (user must have delete permissions to it all). If not set,
         then the page is deleted  *only* if it has no branch.
         
         Default is false.


.. container:: table-row

   Internal variable
         ->copyTree
   
   Data type
         Integer
   
   Description
         Sets the number of branches on a page tree to copy.
         
         If 0 then branch is  *not* copied. If 1 then pages on the 1st level is
         copied. If 2 then pages on the second level is copied ... and so on.
         
         Default is zero.


.. container:: table-row

   Internal variable
         ->reverseOrder
   
   Data type
         Boolean
   
   Description
         If set, the data array is reversed in the order, which is a nice thing
         if you're creating a whole bunch of new records.
         
         Default is zero.


.. container:: table-row

   Internal variable
         ->copyWhichTables
   
   Data type
         list of strings (tables)
   
   Description
         This list of tables decides which tables will be copied. If empty then
         none will. If "\*" then all will (that the user has permission to of
         course).
         
         Default is "\*"


.. container:: table-row

   Internal variable
         ->stripslashes\_values
   
   Data type
         boolean
   
   Description
         If set, then all values will be passed through stripslashes(). This
         has been the default since the birth of TYPO3 in times when input from
         POST forms were always escaped an needed to be unescaped. Today this
         is deprecated and values should be passed around without escaped
         characters.
         
         **It is highly recommended to set this value to zero every time the
         class is used!**
         
         If you set this value to false you can pass values as-is to the class
         and it is most like that this is what you want. Otherwise you would
         have to pass all values through addslashes() first.
         
         Default is (currently) "1" (true) but  *might be changed in the
         future!*


.. ###### END~OF~TABLE ######

