.. include:: ../../../Includes.txt



.. _tce-database-basics:

========================================================
Database: DataHandler basics (formerly known as TCEmain)
========================================================

When you are using TCE from your backend applications you need to
prepare two arrays of information which contain the instructions to
DataHandler (:php:`\TYPO3\CMS\Core\DataHandling\DataHandler`)
of what actions to perform. They fall into two categories:
data and commands.

"Data" is when you want to write information to a database table or
create a new record.

"Commands" is when you want to move, copy or delete a record in the
system.

The data and commands are created as multidimensional arrays and to
understand the API of DataHandler you simply need to understand the
hierarchy of these two arrays.

.. caution::

   The DataHandler needs a properly configured TCA. If your field
   is not configured in the TCA the DataHandler will not be able to
   interact with it. This also is the case if you configured
   "type"="none" (which is in fact a valid type) or if an invalid
   type is specified. In that case the DataHandler is not
   able to determine the correct value of the field.

.. _tce-commands:

Commands Array
==============

Syntax::

   $cmd[ tablename ][ uid ][ command ] = value

Description of keywords in syntax:

.. t3-field-list-table::
 :header-rows: 1

 - :Key,20: Key
   :Type,20: Data type
   :Description,60: Description


 - :Key:
         tablename
   :Type:
         string
   :Description:
         Name of the database table. Must be configured in :php:`$GLOBALS['TCA']` array,
         otherwise it cannot be processed.


 - :Key:
         uid
   :Type:
         integer
   :Description:
         The UID of the record that is manipulated. This is always an integer.


 - :Key:
         command
   :Type:
         string (command keyword)
   :Description:
         The command type you want to execute.

         .. note:: Only *one* command can be executed at a time for each
                   record! The first command in the array will be taken.

         See table below for :ref:`command keywords and values <tce-command-keywords>`


 - :Key:
         value
   :Type:
         mixed
   :Description:
         The value for the command

         See table below for :ref:`command keywords and values <tce-command-keywords>`


.. _tce-command-keywords:

Command keywords and values
---------------------------

.. t3-field-list-table::
 :header-rows: 1

 - :Command,20: Command
   :Type,20: Data type
   :Value,60: Value


 - :Command:
         copy
   :Type:
         integer
   :Value:
         The significance of the value depends on whether it is positive or
         negative:

         - Positive value: The value points to a page UID. A copy of the record
           (and possibly child elements/tree below) will be inserted inside that
           page as the first element.

         - Negative value: The (absolute) value points to another record from the
           same table as the record being copied. The new record will be inserted
           on the same page as that record and if :php:`$GLOBALS['TCA'][...]['ctrl']['sortby']` is
           set, then it will be positioned *after*.

         - Zero value: Record is inserted on tree root level.

         - array: The array has to contain the integer value as in examples above and
           may contain field => value pairs for updates. The array is structured
           like::

              [
                 'action' => 'copy', // Defines where this is a move or copy command
                 'target' => $pUid, // Defines the page to insert the record.
                 'update' => $update, // Array with field => value to be updated.
              ]


 - :Command:
         move
   :Type:
         integer
   :Value:
         Works like "copy" but moves the record instead of making a copy.


 - :Command:
         delete
   :Type:
         1
   :Value:
         Value should always be "1"

         This action will delete the record (or mark the record "deleted" if
         configured in :php:`$GLOBALS['TCA']`).


 - :Command:
         undelete
   :Type:
         1
   :Value:
         Value should always be "1".

         This action will set the deleted-flag back to 0.


 - :Command:
         localize
   :Type:
         integer
   :Value:
         Value is an uid of the :php:`sys_language` to localize the record into.
         Basically a localization of a record is making a copy of the record
         (possibly excluding certain fields defined with :php:`l10n_mode`) but
         changing relevant fields to point to the right :php:`sys_language` / original
         language record.

         Requirements for a successful localization is this:

         - :code:`[ctrl]` options "languageField" and "transOrigPointerField" must be
           defined for the table

         - A :sql:`sys_language` record with the given :sql:`sys_language_uid` must
           exist.

         - The record to be localized by currently be set to "Default" language
           and not have any value set for the TCA :php:`transOrigPointerField` either.

         - There cannot exist another localization to the given language for the
           record (looking in the original record PID).

         Apart from this, ordinary permissions apply as if the user wants to
         make a copy of the record on the same page.

         The :php:`localize` DataHandler command should be used when translating records in "Connected Mode"
         (strict translation of records from the default language).
         This command is used when selecting the "Translate" strategy in the content elements translation wizard.


 - :Command:
         copyToLanguage
   :Type:
         integer
   :Value:
         It behaves like :php:`localize` command (both record and child records are copied to given language),
         but does not set :php:`transOrigPointerField` fields (e.g. :sql:`l10n_parent`).

         The :php:`copyToLanguage` command should be used when localizing records in the "Free Mode".
         This command is used when localizing content elements using translation wizard's "Copy" strategy.


 - :Command:
         inlineLocalizeSynchronize
   :Type:
         array
   :Value:
         Performs localization or synchronization of child records.
         The command structure is like::

             $cmd['tt_content'][13]['inlineLocalizeSynchronize'] = [ // 13 is a parent record uid
               'field' => 'tx_myfieldname', // field we want to synchronize
               'language' => 2, // uid of the target language
               // either the key 'action' or 'ids' must be set
               'action' => 'localize' // or 'synchronize'
               'ids' =>  [1, 2, 3] // array of child-ids to be localized
             ]

 - :Command:
         version
   :Type:
         array
   :Value:
         Versioning action.

         **Keys:**

         - [action] : Keyword determining the versioning action. Options are:

           - "new": Indicates that a new version of the record should be
             created.Additional keys, specific for "new" action:

             - [treeLevels]: *(Only pages)* Integer, -1 to 4, indicating the number
               of levels of the page tree to version together with a page. This is
               also referred to as the versioning type:-1 ("element") means only the
               page record gets versioned (default)0 ("page") means the page +
               content tables (defined by ctrl-flag :code:`versioning_followPages` )>0
               ("branch") means the the whole branch is versioned ( *full copy* of
               all tables), down to the level indicated by the value (1= 1 level
               down, 2= 2 levels down, etc.). The treeLevel is recorded in the field
               :code:`t3ver_swapmode` and will be observed when the record is swapped
               during publishing.

             - [label]: Indicates the version label to apply. If not given, a
               standard label including version number and date is added.

           - "swap": Indicates that the current online version should be swapped
             with another.Additional keys, specific for "swap" action:

             - [swapWith]: Indicates the uid of the record to swap current version
               with!

             - [swapIntoWS]: Boolean, indicates that when a version is published it
               should be swapped into the workspace of the offline record.

           - "clearWSID": Indicates that the workspace of the record should be set
             to zero (0). This removes versions out of workspaces without
             publishing them.

           - "flush": Completely deletes a version without publishing it.

           - "setStage": Sets the stage of an element. *Special feature: The id-
             key in the array can be a comma list of ids in order to perform the
             stageChange over a number of records. Also, the internal variable
             ->generalComment (also available through :file:`tce_db.php` as
             "&generalComment") can be used to set a default comment for all stage
             changes of an instance of tcemain.* Additional keys for this action
             is:

             - [stageId]: Values are: -1 (rejected), 0 (editing, default), 1
               (review), 10 (publish)

             - [comment]: Comment string that goes into the log.


.. _tce-command-examples:

Examples of commands:
---------------------

::

   $cmd['tt_content'][54]['delete'] = 1;    // Deletes tt_content record with uid=54
   $cmd['tt_content'][1203]['copy'] = -303; // Copies tt_content uid=1203 to the position after tt_content uid=303 (new record will have the same pid as tt_content uid=1203)
   $cmd['tt_content'][1203]['copy'] = 400;  // Copies tt_content uid=1203 to first position in page uid=400
   $cmd['tt_content'][1203]['move'] = 400;  // Moves tt_content uid=1203 to the first position in page uid=400


.. _tce-data:

Data Array
==========

Syntax::

   $data[tablename][uid][fieldname] = value

Description of keywords in syntax:

.. t3-field-list-table::
 :header-rows: 1

 - :Key,20: Key
   :Type,20: Data type
   :Description,60: Description


 - :Key:
         tablename
   :Type:
         string
   :Description:
         Name of the database table. Must be configured in :php:`$GLOBALS['TCA']` array,
         otherwise it cannot be processed.


 - :Key:
         uid
   :Type:
         mixed
   :Description:
         The UID of the record that is modified. If the record already exists,
         this is an integer. If you're creating new records, use a random
         string prefixed with "NEW", e.g. "NEW7342abc5e6d".


 - :Key:
         fieldname
   :Type:
         string
   :Description:
         Name of the database field you want to set a value for. Must be
         configured in :php:`$GLOBALS['TCA'][*tablename*]['columns']`.


 - :Key:
         value
   :Type:
         string
   :Description:
         Value for "fieldname".

         .. important::
            Always make sure :php:`$this->stripslashes_values` is false before using
            DataHandler.)


.. note::
   For FlexForms the data array of the FlexForm field is
   deeper than three levels. The number of possible levels for FlexForms
   is infinite and defined by the data structure of the FlexForm. But
   FlexForm fields always end with a "regular value" of course.


.. _tce-data-examples:

Examples of Data submission
---------------------------

This creates a new page titled "The page title" as the first page
inside page id 45::

   $data['pages']['NEW9823be87'] = array(
      'title' => 'The page title',
      'subtitle' => 'Other title stuff',
      'pid' => '45'
   );

This creates a new page titled "The page title" right after page id 45
in the tree::

   $data['pages']['NEW9823be87'] = array(
      'title' => 'The page title',
      'subtitle' => 'Other title stuff',
      'pid' => '-45'
   );

This creates two new pages right after each other, located right after
the page id 45::

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

This creates a new content record with references to existing and
one new system category::

   $data['sys_category']['NEW9823be87'] = array(
       'title' => 'New category',
       'pid' => 1,
   );
   $data['tt_content']['NEWbe68s587'] = array(
       'header' => 'Look ma, categories!',
       'pid' => 45,
       'categories' => array(
           1,
           2,
           'NEW9823be87', // You can also use placeholders here
       ),
   );

This updates the page with uid=9834 to a new title, "New title for
this page", and no\_cache checked::

   $data['pages'][9834] = array(
       'title' => 'New title for this page',
       'no_cache' => '1'
   );


.. _tce-clear-cache:

Clear cache
===========

TCE also has an API for clearing the cache tables of TYPO3:

Syntax::

   $tce->clear_cacheCmd($cacheCmd);

.. t3-field-list-table::
 :header-rows: 1

 - :Value,30: $cacheCmd values
   :Description,70: Description


 - :Value:
         [integer]
   :Description:
         Clear the cache for the page id given.


 - :Value:
         "all"
   :Description:
         Clears all cache tables (:code:`cache_pages`, :code:`cache_pagesection`,
         :code:`cache_hash`).

         Only available for admin-users unless explicitly allowed by User
         TSconfig "options.clearCache.all".


 - :Value:
         "pages"
   :Description:
         Clears all pages from :code:`cache_pages`.

         Only available for admin-users unless explicitly allowed by User
         TSconfig "options.clearCache.pages".

 - :Value:
         "temp_cached" or "system"
   :Description:
         Clears all cache entries cache group  :code:`system`.

         Only available for admin-users unless explicitly allowed by User
         TSconfig "options.clearCache.system".


.. _tce-cache-hook:

Hook for cache post-processing
------------------------------

You can configure cache post-processing with a user defined PHP
function. Configuration of the hook can be done from
:file:`ext_localconf.php`. An example might look like::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = 'myext_cacheProc->proc';
   require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('myext') . 'class.myext_cacheProc.php');


.. _tce-flags:

Flags in DataHandler
====================

There are a few internal variables you can set prior to executing
commands or data submission. These are the most significant:

.. t3-field-list-table::
 :header-rows: 1

 - :Variable,30: Internal variable
   :Type,20: Data type
   :Description,50: Description


 - :Variable:
         ->deleteTree
   :Type:
         Boolean
   :Description:
         Sets whether a page tree branch can be recursively deleted.

         If this is set, then a page is deleted by deleting the whole branch
         under it (user must have delete permissions to it all). If not set,
         then the page is deleted *only* if it has no branch.

         Default is false.


 - :Variable:
         ->copyTree
   :Type:
         Integer
   :Description:
         Sets the number of branches on a page tree to copy.

         If :code:`0` then branch is *not* copied. If :code:`1` then pages on the 1st level is
         copied. If :code:`2` then pages on the second level is copied, and so on.

         Default is zero.


 - :Variable:
         ->reverseOrder
   :Type:
         Boolean
   :Description:
         If set, the data array is reversed in the order, which is a nice thing
         if you're creating a whole bunch of new records.

         Default is zero.


 - :Variable:
         ->copyWhichTables
   :Type:
         list of strings (tables)
   :Description:
         This list of tables decides which tables will be copied. If empty then
         none will. If "\*" then all will (that the user has permission to of
         course).

         Default is "\*".
