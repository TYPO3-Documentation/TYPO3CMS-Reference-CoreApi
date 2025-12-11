..  include:: /Includes.rst.txt
..  index:: DataHandler; Basics
..  _tce-database-basics:
..  _datahandler-basics:

==================
DataHandler basics
==================

..  contents::
    :local:

Introduction
============

When you are using DataHandler from your backend applications you need to
prepare two arrays of information which contain the instructions to
DataHandler (:php:`\TYPO3\CMS\Core\DataHandling\DataHandler`)
of what actions to perform. They fall into two categories:
:ref:`data <datahandler-data>` and :ref:`commands <datahandler-commands>`.

"Data" is when you want to write information to a database table or
create a new record.

"Commands" is when you want to move, copy or delete a record in the
system.

The data and commands are created as multidimensional arrays, and to
understand the API of DataHandler you need to understand the
hierarchy of these two arrays.

..  caution::
    The DataHandler needs a properly configured :ref:`TCA <t3tca:start>`. If
    your field is not configured in the TCA the DataHandler will not be able to
    interact with it. This also is the case if you configured
    `"type"="none"` (which is in fact a valid type) or if an invalid
    type is specified. In that case, the DataHandler is not
    able to determine the correct value of the field.


..  index:: DataHandler; Commands array
..  _tce-commands:
..  _datahandler-commands:

Basic usage
===========

..  literalinclude:: _BasicUsage.php
    :language: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

After this initialization you usually want to perform the actual operations by
calling one (or both) of these two methods:

..  code-block:: php

    $this->dataHandler->process_datamap();
    $this->dataHandler->process_cmdmap();

..  note::
    Any error that might have occurred during your DataHandler operations can be
    accessed via its public property :php:`$this->dataHandler->errorLog`.
    See :ref:`tcemain-error-handling`.

Commands array
==============

Syntax:

..  code-block:: text

    $cmd[ tablename ][ uid ][ command ] = value

Description of keywords in syntax:

..  confval:: tablename
    :name: datahandler-cmd-tablename
    :Data type: string

    Name of the database table. It must be configured in the
    :php:`$GLOBALS['TCA']` array, otherwise it cannot be processed.

..  confval:: uid
    :name: datahandler-cmd-uid
    :Data type: integer

    The UID of the record that is manipulated. This is always an integer.

..  confval:: command
    :name: datahandler-cmd-command
    :Data type: string (command keyword)

    The command type you want to execute.

    ..  note::
        Only *one* command can be executed at a time for each
        record! The first command in the array will be taken.

    See :ref:`command keywords and values <datahandler-command-keywords>`

..  confval:: value
    :name: datahandler-cmd-value
    :Data type: mixed

    The value for the command.

    See :ref:`command keywords and values <datahandler-command-keywords>`


..  index:: DataHandler; Commands keywords
..  _tce-command-keywords:
..  _datahandler-command-keywords:

Command keywords and values
---------------------------

..  confval:: copy
    :name: datahandler-cmd-copy
    :Data type: integer or array

    The significance of the value depends on whether it is positive or
    negative:

    Positive value
        The value points to a page UID. A copy of the record
        (and possibly child elements/tree below) will be inserted inside that
        page as the first element.

    Negative value
        The (absolute) value points to another record from the
        same table as the record being copied. The new record will be inserted
        on the same page as that record and if
        :ref:`$GLOBALS['TCA'][$table]['ctrl']['sortby'] <t3tca:ctrl-reference-sortby>`
        is set, then it will be positioned *after*.

    Zero value
        Record is inserted on tree root level.

    array
        The array has to contain the integer value as in examples above and
        may contain field => value pairs for updates. The array is structured
        like:

        ..  code-block:: php

            [
                'action' => 'paste', // 'paste' is used for both move and copy commands
                'target' => $pUid,   // Defines the page to insert the record, or record uid to copy after
                'update' => $update, // Array with field => value to be updated.
            ]


..  confval:: move
    :name: datahandler-cmd-move
    :DataType: integer

    Works like :confval:`datahandler-cmd-copy` but moves the record instead of
    making a copy.


..  confval:: delete
    :name: datahandler-cmd-delete
    :Data Type: integer (1)

    Value should always be "1".

    This action will delete the record (or mark the record "deleted", if
    configured in
    :ref:`$GLOBALS['TCA'][$table]['ctrl']['delete'] <t3tca:ctrl-reference-delete>`).


..  confval:: undelete
    :name: datahandler-cmd-undelete
    :Data Type: integer (1)

    Value should always be "1".

    This action will set the "deleted" flag back to 0.


..  confval:: localize
    :name: datahandler-cmd-localize
    :Data type: integer

    The value is the :yaml:`languageId` (defined in the
    :ref:`site configuration <sitehandling-addingLanguages>`) to localize the
    record into. Basically a localization of a record is making a copy of the
    record (possibly excluding certain fields defined with
    :ref:`l10n_mode <t3tca:columns-properties-l10n-mode>`) but
    changing relevant fields to point to the right language ID.

    Requirements for a successful localization is this:

    *   :php:`[ctrl]` options
        :ref:`languageField <t3tca:ctrl-reference-languagefield>` and
        :ref:`transOrigPointerField <t3tca:ctrl-reference-transorigpointerfield>`
        must be defined for the table

    *   A :yaml:`languageId` must be configured in the site configuration.

    *   The record to be localized by currently be set to default language
        and not have any value set for the TCA :php:`transOrigPointerField` either.

    *   There cannot exist another localization to the given language for the
        record (looking in the original record PID).

    Apart from this, ordinary permissions apply as if the user wants to
    make a copy of the record on the same page.

    The :php:`localize` DataHandler command should be used when translating
    records in ":ref:`connected mode <t3translate:localized-connected-content>`"
    (strict translation of records from the default language). This command is
    used when selecting the "Translate" strategy in the content elements
    translation wizard.


..  confval:: copyToLanguage
    :name: datahandler-cmd-copyToLanguage
    :Data type: integer

    It behaves like :confval:`datahandler-cmd-localize` command (both record and
    child records are copied to given language), but does not set
    :ref:`transOrigPointerField <t3tca:ctrl-reference-transorigpointerfield>`
    fields (for example, :php:`l10n_parent`).

    The :php:`copyToLanguage` command should be used when localizing records in
    the ":ref:`free mode <t3translate:localized-content-free-content>`". This
    command is used when localizing content elements using translation wizard's
    "Copy" strategy.


..  confval:: inlineLocalizeSynchronize
    :name: datahandler-cmd-inlineLocalizeSynchronize
    :Data type: array

    Performs localization or synchronization of child records.
    The command structure is like:

    ..  code-block:: php

        $cmd['tt_content'][13]['inlineLocalizeSynchronize'] = [ // 13 is a parent record uid
            'field' => 'tx_myfieldname', // field we want to synchronize
            'language' => 2,             // uid of the target language
            // either the key 'action' or 'ids' must be set
            'action' => 'localize',      // or 'synchronize'
            'ids' =>  [1, 2, 3],         // array of child IDs to be localized
        ];


..  confval:: version
    :name: datahandler-cmd-version
    :Data type: array

    Versioning action.

    ..  todo:
        - "versioning_followPages" was deprecated in v8: https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/8.5/Deprecation-78524-TCAOptionVersioning_followPagesRemoved.html
        - "t3ver_swapmode" has been removed in v11: https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/11.0/Breaking-92206-RemoveWorkspaceSwappingOfElements.html

    ..  note::
        This section is currently outdated.

    **Keys:**

    [action]
        Keyword determining the versioning action. Options are:

        "new"
            Indicates that a new version of the record should be
            created. Additional keys, specific for "new" action:

            [treeLevels]
                *(Only pages)* Integer, -1 to 4, indicating the number of levels
                of the page tree to version together with a page. This is also
                referred to as the versioning type:

                *   -1 ("element") means only the page record gets versioned
                    (default)

                *   0 ("page") means the page + content tables (defined by ctrl
                    flag :code:`versioning_followPages` )

                *   >0 ("branch") means the the whole branch is versioned
                    (*full copy* of all tables), down to the level indicated by
                    the value (1 = 1 level down, 2 = 2 levels down, etc.). The
                    treeLevel is recorded in the field :code:`t3ver_swapmode`
                    and will be observed when the record is swapped during
                    publishing.

            [label]
                Indicates the version label to apply. If not given, a standard
                label including version number and date is added.

        "swap"
            Indicates that the current online version should be swapped
            with another. Additional keys, specific for "swap" action:

            [swapWith]
                Indicates the uid of the record to swap current version with!

            [swapIntoWS]
                Boolean, indicates that when a version is published it should be
                swapped into the workspace of the offline record.

        "clearWSID"
            Indicates that the workspace of the record should be set to zero
            (0). This removes versions out of workspaces without publishing
            them.

        "flush"
            Completely deletes a version without publishing it.

        "setStage"
            Sets the stage of an element. *Special feature: The id key in the
            array can be a comma-separated list of ids in order to perform the
            stageChange over a number of records. Also, the internal variable
            ->generalComment (also available through `/record/commit` route as
            `&generalComment`) can be used to set a default comment for all
            stage changes of an instance of the data handler.* Additional keys
            for this action are:

            [stageId]
                Values are:

                *   -1 (rejected)
                *   0 (editing, default)
                *   1 (review),
                *   10 (publish)

            [comment]
                Comment string that goes into the log.


..  index:: DataHandler; Commands examples
..  _tce-command-examples:

Examples of commands
--------------------

..  code-block:: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

    $cmd['tt_content'][54]['delete'] = 1;    // Deletes tt_content record with uid=54
    $cmd['tt_content'][1203]['copy'] = -303; // Copies tt_content uid=1203 to the position after tt_content uid=303 (new record will have the same pid as tt_content uid=1203)
    $cmd['tt_content'][1203]['copy'] = 400;  // Copies tt_content uid=1203 to first position in page uid=400
    $cmd['tt_content'][1203]['move'] = 400;  // Moves tt_content uid=1203 to the first position in page uid=400

Accessing the uid of copied records
-----------------------------------

The :php:`DataHandler` keeps track of records created by :code:`copy`
operations in its :php:`$copyMappingArray_merged` property. This
property is public but marked as :php:`@internal`. So it is subject to change
in future TYPO3 versions without notice.

The :php:`$copyMappingArray_merged` property can be used to determine the UID
of a record copy based on the UID of the copied record.

..  caution::
    The :php:`$copyMappingArray_merged` property should not be mixed up with
    the :php:`$copyMappingArray` property which contains only information
    about the last copy operation and is cleared between each operation.

The structure of the :php:`$copyMappingArray_merged` property looks like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

    $copyMappingArray_merged = [
       <table> => [
          <original-record-uid> => <record-copy-uid>,
       ],
    ];

The property contains the names of the manipulated tables as keys and a map
of original record UIDs and UIDs of record copies as values.


..  code-block:: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

    $cmd['tt_content'][1203]['copy'] = 400;  // Copies tt_content uid=1203 to first position in page uid=400
    $this->dataHandler->start([], $cmd);
    $this->dataHandler->process_cmdmap();

    $uid = $this->dataHandler->copyMappingArray_merged['tt_content'][1203];


..  index:: DataHandler; Data array
..  _tce-data:
..  _datahandler-data:

Data array
==========

Syntax: :php:`$data['<tablename>'][<uid>]['<fieldname>'] = 'value'`

Description of keywords in syntax:

..  confval:: tablename
    :name: datahandler-data-tablename
    :Data type: string

    Name of the database table. There must be a configuration for the table in
    :php:`$GLOBALS['TCA']` array, otherwise it cannot be processed.


..  confval:: uid
    :name: datahandler-data-uid
    :Data type: string|int

    The UID of the record that is modified. If the record already exists,
    this is an integer.

    If you are creating new records, use a random string prefixed with `NEW`,
    for example, `NEW7342abc5e6d`. You can use static strings (`NEW1`, `NEW2`,
    ...) or generate them using
    :php:`\TYPO3\CMS\Core\Utility\StringUtility::getUniqueId('NEW')`.

..  caution::

    If you supply your own string `NEW` must not be followed by an underscore.
    The occurance of an underscore implies a reference to a record in a table.


..  confval:: fieldname
    :name: datahandler-data-fieldname
    :Data type: string

    Name of the database field you want to set a value for. The columns of the
    table must be configured in
    :ref:`$GLOBALS['TCA'][$table]['columns'] <t3tca:columns>`.


..  confval:: value
    :name: datahandler-data-value
    :Data type: string

    Value for "fieldname".

    For fields of type :ref:`inline <t3tca:columns-inline>` this is a
    comma-separated list of UIDs of referenced records.


..  note::
    For :ref:`FlexForms <flexforms>` the data array of the FlexForm field is
    deeper than three levels. The number of possible levels for FlexForms
    is infinite and defined by the data structure of the FlexForm. But
    FlexForm fields always end with a "regular value" of course.


..  caution::
    .. versionchanged:: 13.0.1/12.4.11/11.5.35

    Modifying the :sql:`sys_file` table using DataHandler is blocked since TYPO3
    version 11.5.35, 12.4.11, and 13.0.1. The table
    should not be extended and additional fields should be added to
    :sql:`sys_file_metadata`. See `security advisory TYPO3-CORE-SA-2024-006 <https://typo3.org/security/advisory/typo3-core-sa-2024-006>`__
    for more information.


..  index:: DataHandler; Data submission
..  _tce-data-examples:

Examples of data submission
---------------------------

This creates a new page titled "The page title" as the first page
inside page id 45:

..  code-block:: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

    $data['pages']['NEW9823be87'] = [
        'title' => 'The page title',
        'subtitle' => 'Other title stuff',
        'pid' => '45'
    ];

This creates a new page titled "The page title" right after page id 45
in the tree:

..  code-block:: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

    $data['pages']['NEW9823be87'] = [
        'title' => 'The page title',
        'subtitle' => 'Other title stuff',
        'pid' => '-45'
    ];

This creates two new pages right after each other, located right after
the page id 45:

..  code-block:: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

    $data['pages']['NEW9823be87'] = [
        'title' => 'Page 1',
        'pid' => '-45'
    ];
    $data['pages']['NEWbe68s587'] = [
        'title' => 'Page 2',
        'pid' => '-NEW9823be87'
    ];

Notice how the second "pid" value points to the "NEW..." id
placeholder of the first record. This works because the new id of the
first record can be accessed by the second record. However it works
only when the order in the array is as above since the processing
happens in that order!

This creates a new content record with references to existing and
one new system category:

..  code-block:: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

    $data['sys_category']['NEW9823be87'] = [
        'title' => 'New category',
        'pid' => 1,
    ];
    $data['tt_content']['NEWbe68s587'] = [
        'header' => 'Look ma, categories!',
        'pid' => 45,
        'categories' => [
            1,
            2,
            'NEW9823be87', // You can also use placeholders here
        ],
    ];

..  note::
    To get real uid of the record you have just created use DataHandler's
    `substNEWwithIDs` property like:
    :php:`$uid = $this->dataHandler->substNEWwithIDs['NEW9823be87'];`

This updates the page with uid=9834 to a new title, "New title for
this page", and no\_cache checked:

.. code-block:: php
   :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

    $data['pages'][9834] = [
        'title' => 'New title for this page',
        'no_cache' => '1'
    ];


..  index:: DataHandler; Clear cache
..  _tce-clear-cache:

Clear cache
===========

DataHandler also has an API for clearing the cache tables of TYPO3:

..  code-block:: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php

    $this->dataHandler->clear_cacheCmd($cacheCmd);

Values for the :php:`$cacheCmd` argument:

..  confval:: [integer]
    :name: datahandler-clear-cachecmd-integer

    Clear the cache for the page ID given.


..  confval:: "all"
    :name: datahandler-clear-cachecmd-all

    Clears all cache tables (:code:`cache_pages`, :code:`cache_pagesection`,
    :code:`cache_hash`).

    Only available for admin-users unless explicitly allowed by User
    TSconfig "options.clearCache.all".


..  confval:: "pages"
    :name: datahandler-clear-cachecmd-pages

    Clears all pages from :code:`cache_pages`.

    Only available for admin-users unless explicitly allowed by User
    TSconfig "options.clearCache.pages".


..  index:: Hook; Clear cache
..  _tce-cache-hook:

Clear cache using cache tags
----------------------------

Every processing of data or commands is finalized with flushing a few caches in
the :php:`pages` group. Cache tags are used to specifically flush the
relevant cache entries instead of the cache as whole.

By default the following cache tags are flushed:

*   The table name of the updated record, for example, :php:`pages` when
    updating a page or :php:`tx_myextension_mytable` when updating a record of
    this table.
*   A combination of table name and record UID, for example, :php:`pages_10`
    when updating the page with UID 10 or :php:`tx_myextension_mytable_20` when
    updating the record with UID 20 of this table.
*   A page UID prefixed with :php:`pageID_` (:php:`pageId_<page-uid>`), for
    example, :php:`pageId_10` when updating a page with UID 10 (additionally all
    related pages, see
    :ref:`clearcache-pagegrandparent <t3tsref:pagetcemain-clearcache-pagegrandparent>`
    and
    :ref:`clearcache-pagesiblingchildren <t3tsref:pagetcemain-clearcache-pagesiblingchildren>`)
    and :php:`pageId_10` when updating a record if a record of any table placed
    on the page with UID 10 (:php:`<table>.pid = 10`) is updated.

Notice that you can also use the :php:method:`\TYPO3\CMS\Core\Cache\CacheDataCollector::addCacheTags`
method to register additional tags for the cache entry of the current page while
it is rendered. This way you can implement an elaborate caching behavior which
ensures that every record update in the TYPO3 backend (which is processed by the
:php:`DataHandler`) automatically flushes the cache of all pages where that
record is displayed.

Following the rules mentioned above you could register :ref:`cache tags <caching>`
from within your :ref:`Extbase <extbase>` plugin (for example, controller or a
custom ViewHelper):

..  literalinclude:: _SomeController.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/SomeController.php

..  versionadded:: 13.3
    The :ref:`frontend.cache.collector <typo3-request-attribute-frontend-cache-collector>`
    request attribut has been introduced as a successor of the now deprecated
    :php:`TypoScriptFrontendController->addCacheTags()` method. Switch to
    another version of this page for an example in an older TYPO3 version. For
    compatibility with TYPO3 v12 and v13 use
    :php:`TypoScriptFrontendController->addCacheTags()`.

Hook for cache post-processing
------------------------------

You can configure cache post-processing with a user defined PHP
function. Configuration of the hook can be done from
:file:`ext_localconf.php`. An example might look like:

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php


..  index:: DataHandler; Flags
..  _tce-flags:

Flags in the DataHandler
=======================

..  versionchanged:: 14.0
    The following public properties of the PHP class `TYPO3\CMS\Core\DataHandling\DataHandler` have been removed:

    *   `copyWhichTables`
    *   `neverHideAtCopy`
    *   `copyTree`

    See `Breaking: #107856 - DataHandler: Remove internal property
    copyWhichTables and properties neverHideAtCopy and
    copyTree <https://docs.typo3.org/permalink/changelog:breaking-107856-1763715381>`_


There are a few internal variables you can set prior to executing
commands or data submission.

..  confval:: ->reverseOrder
    :name: datahandler-flags-reverseOrder
    :Data type: boolean
    :Default: false

    If set, the data array is reversed in the order, which is a nice thing
    if you are creating a whole bunch of new records.
