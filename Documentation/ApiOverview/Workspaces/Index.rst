.. include:: ../../Includes.txt


.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.


.. _workspaces:

Programming with workspaces in mind
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The concept of workspaces needs attention from extension programmers.
The implementation of workspaces is however made so that no critical
problems can appear with old extensions;

- First of all the "Live workspace" is no different from how TYPO3 has
  been working for years so that will be supported out of the box
  (except placeholder records must be filtered out in the frontend with
  :code:`t3ver_state !=` , see below).

- Secondly, all permission related issues are implemented in TCEmain so
  the worst your users can experience is an error message.

However, you probably want to update your extension so that in the
backend the current workspace is reflected in the records shown and
the preview of content in the frontend works as well. Therefore this
chapter has been written with instructions and insight into the issues
you are facing.


.. _workspaces-frontend:

Frontend challenges in general
""""""""""""""""""""""""""""""

For the frontend the challenges are mostly related to creating correct
previews of content in workspaces. For most extensions this will work
transparently as long as they use the API functions in TYPO3 to
request records from the system.

The most basic form of a preview is when a live record is selected and
you lookup a future version of that record belonging to the current
workspace of the logged in backend user. This is very easy as long as
a record is selected based on its "uid" or "pid" fields which are not
subject to versioning; You simply call :code:`sys_page->versionOL()` after
record selection.

However, when other fields are involved in the where clause it gets
dirty. This happens all the time! For instance, all records displayed
in the frontend must be selected with respect to "enableFields"
configuration! What if the future version is hidden and the live
version is not? Since the live version is selected first (not hidden)
and then overlaid with the content of the future version (hidden) the
effect of the hidden field we wanted to preview is lost unless we also
check the overlaid record for its hidden field (:code:`->versionOL()` actually
does this). But what about the opposite; if the live record was hidden
and the future version not? Since the live version is never selected
the future version will never have a chance to display itself! So we
must first select the live records with no regard to the hidden state,
then overlay the future version and eventually check if it is hidden
and if so exclude it. The same problem applies to all other
"enableFields", future versions with "delete" flags and current
versions which are invisible placeholders for future records. Anyway,
all that is handled by the :code:`t3lib_pageSelect` class which includes
functions for "enableFields" and "deleted" so it will work out of the
box for you. But as soon as you do selection based on other fields
like email, username, alias etc. it will fail.

.. _workspaces-frontend-summary:

Summary
~~~~~~~

**Challenge:** How to preview elements which are disabled by
"enableFields" in the live version but not necessarily in the offline
version. Also, how to filter out new live records with :code:`t3ver_state`
set to 1 (placeholder for new elements) but only when not previewed.

**Solution:** Disable check for :code:`enableFields`/:code:`where_del_hidden` on
live records and check for them in versionOL on input record.


.. _workspaces-frontend-guidelines:

Frontend implementation guidelines
""""""""""""""""""""""""""""""""""

- Any place where enableFields() are not used for selecting in the
  frontend you must at least check that :code:`t3ver_state != 1` so
  placeholders for new records are not displayed.

- Make sure never to select any record with :code:`pid = -1`! (offline records -
  related to versioning).

- If you need to detect preview mode for versioning and workspaces you
  can read these variables:

  - :code:`$GLOBALS['TSFE']->sys_page->versioningPreview`: If true, you are
    allowed to display previews of other record versions.

  - :code:`$GLOBALS['TSFE']->sys_page->versioningWorkspaceId`: Will tell you the
    id of the workspace of the current backend user. Used for preview of
    workspaces.

- Use these API functions for support of version previews in the
  frontend:

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Description,70: Description


 - :Function:
         $GLOBALS['TSFE']->sys\_page->versionOL($table, &$row,
         $unsetMovePointers=FALSE)
   :Description:
         Versioning Preview Overlay.

         Generally ALWAYS used when records are selected based on uid or pid.
         If records are selected on other fields than uid or pid (e.g. "email =
         ....") then usage might produce undesired results and that should be
         evaluated on individual basis.

         Principle: Record online! => Find offline?

         **Example:**

         This is how simple it is to use this record in your frontend plugins
         when you do queries directly (not using API functions already using
         them):

         ::

            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(...);
            while (($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
                    $GLOBALS['TSFE']->sys_page->versionOL($table,$row);

                    if (is_array($row)) {
            ...

         When the live record is selected, call :code:`->versionOL()` and make sure to
         check if the input row (passed by reference) is still an array.

         The third argument, :code:`$unsetMovePointers = FALSE`, can be set to TRUE when
         selecting records for display ordered by their position in the page
         tree. Difficult to explain easily, so only use this option if you
         don't get a correct preview of records that has been moved in a
         workspace (only for "element" type versioning)


 - :Function:
         $GLOBALS['TSFE']->sys\_page->fixVersioningPid()
   :Description:
         Finding online PID for offline version record.

         Will look if the "pid" value of the input record is -1 (it is an
         offline version) and if the table supports versioning; if so, it will
         translate the -1 PID into the PID of the original record

         Used whenever you are tracking something back, like making the root
         line. In fact, it is currently only used by the root line function and
         chances are that you will not need this function often.

         Principle: Record offline! => Find online?


.. _workspaces-frontend-problems:

Frontend scenarios impossible to preview
""""""""""""""""""""""""""""""""""""""""

These issues are not planned to be supported for preview:

- Lookups and searching for records based on other fields than
  uid, pid or "enableFields" will never reflect workspace content since
  overlays happen to online records *after* they are selected.

  - This problem can largely be avoided for  *versions of new records*
    because versions of a "New"-placeholder can mirror certain fields down
    onto the placeholder record. For the :code:`tt\_content` table this is
    configured as

    ::

       shadowColumnsForNewPlaceholders'=> 'sys\_language\_uid,l18n\_parent,colPos,header'

    so that these fields used for column position, language and header title are also updated
    in the placeholder thus creating a correct preview in the frontend.

  - For *versions of existing records* the problem is in reality reduced
    a lot because normally you don't change the column or language fields
    after the record is first created anyway! But in theory the preview
    can fail.

  - When changing the type of a page (e.g. from "Standard" to "External
    URL") the preview might fail in cases where a look up is done on the
    :code`doktype` field of the live record.

    - Page shortcuts might not work properly in preview.

    - Mount Points might not work properly in preview.

- It is impossible to preview the value of :code:`count(*)` selections since
  we would have to traverse all records and pass them through
  :code:`->versionOL()` before we would have a reliable result!

- In :code:`tslib_fe::getPageShortcut()`, :code:`sys_page->getMenu()` is called with an
  additional WHERE clause which will not respect if those fields are
  changed for a future version. This could be the case other places
  where getmenu() is used (but a search shows it is not a big problem).
  In this case we will for now accept that a wrong shortcut destination
  can be experienced during previews.


.. _workspaces-backend:

Backend challenges
""""""""""""""""""

The main challenge in the backend is to reflect how the system will
look when the workspace gets published. To create a transparent
experience for backend users we have to overlay almost every selected
record with any possible new version it might have. Also when we are
tracking records back to the page tree root point we will have to
correct pid-values. All issues related to selecting on fields other
than pid and uid also relates to the backend as they did for the
frontend.

.. _workspaces-backend-api:

Workspace-related API for backend modules
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. t3-field-list-table::
 :header-rows: 1

 - :Function,30: Function
   :Description,70: Description


 - :Function:
        t3lib\_BEfunc::workspaceOL()
   :Description:
         Overlaying record with workspace version if any. Works like
         :code:`->sys_page->versionOL()` does, but for the backend. Input record must
         have fields only from the table (no pseudo fields) and the record is
         passed by reference.

         **Example:**

         ::

            $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'pages', 'uid=' . intval($id) . $delClause);
            $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result);
            t3lib_BEfunc::workspaceOL('pages', $row);


 - :Function:
         t3lib\_BEfunc::getRecordWSOL()
   :Description:
         Gets record from table and overlays the record with workspace version
         if any.

         **Example:**

         ::

            $row = t3lib_BEfunc::getRecordWSOL($table, $uid);


            // This is the same as:
            $row = t3lib_BEfunc::getRecord($table, $uid);
            t3lib_BEfunc::workspaceOL($table, $row);


 - :Function:
         t3lib\_BEfunc::fixVersioningPid()
   :Description:
         Translating versioning PID -1 to the pid of the live record. Same as
         :code:`sys_page->fixVersioningPid()` but for the backend.


 - :Function:
         t3lib\_BEfunc::isPidInVersionizedBranch()
   :Description:
         Will fetch the rootline for the pid, then check if anywhere in the
         rootline there is a branch point. Returns either "branchpoint" (if
         branch) or "first" (if page) or false if nothing. Alternatively, it
         returns the value of :code:`t3ver_stage` for the branchpoint (if any).


 - :Function:
         t3lib\_BEfunc::getWorkspaceVersionOfRecord()
   :Description:
         Returns offline workspace version of a record, if found.


 - :Function:
         t3lib\_BEfunc::getLiveVersionOfRecord()
   :Description:
         Returns live version of workspace version.


 - :Function:
         t3lib\_BEfunc::versioningPlaceholderClause()
   :Description:
         Returns a WHERE-clause which will deselect placeholder records from
         other workspaces. This should be implemented almost everywhere records
         are selected based on other fields than uid and where
         :code:`t3lib_BEfunc::deleteClause()` is used.

         **Example:**

         ::

            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
               'count(*)',
               $this->table,
               $this->parentField . '=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($uid, $this->table) .
               t3lib_BEfunc::deleteClause($this->table) .
               t3lib_BEfunc::versioningPlaceholderClause($this->table) .
               $this->clause
            );


 - :Function:
         $BE\_USER->workspaceCannotEditRecord()
   :Description:
         Checking if editing of an existing record is allowed in current
         workspace if that is offline.


 - :Function:
         $BE\_USER->workspaceCannotEditOfflineVersion()
   :Description:
         Like :code:`$BE_USER->workspaceCannotEditRecord()` but also requires version
         to be offline.


 - :Function:
         $BE\_USER->workspaceCreateNewRecord()
   :Description:
         Checks if new records can be created in a certain page (according to
         workspace restrictions).


 - :Function:
         $BE\_USER->workspacePublishAccess($wsid)
   :Description:
         Returns true if user has access to publish in workspace.


 - :Function:
         $BE\_USER->workspaceSwapAccess()
   :Description:
         Returns true if user has access to swap versions.


 - :Function:
         $BE\_USER->checkWorkspace()
   :Description:
         Checks how the users access is for a specific workspace.


 - :Function:
         $BE\_USER->checkWorkspaceCurrent()
   :Description:
         Like ->checkWorkspace() but returns status for the current workspace.


 - :Function:
         $BE\_USER->setWorkspace()
   :Description:
         Setting another workspace for backend user.


 - :Function:
         $BE\_USER->setWorkspacePreview()
   :Description:
         Setting frontend preview state.


.. _workspaces-backend-acess:

Backend module access
"""""""""""""""""""""

You can restrict access to backend modules by using
:code:`$MCONF['workspaces']` in the :file:`conf.php` files. The variable is a list of
keywords defining where the module is available:

::

   $MCONF['workspaces'] = online,offline,custom

You can also restrict function menu items to certain workspaces if you
like. This is done by an argument sent to the function
:code:`t3lib_extMgm::insertModuleFunction()`. See that file for more details.


.. _workspaces-detection:

Detecting current workspace
"""""""""""""""""""""""""""

You can always check what the current workspace of the backend user is
by reading :code:`$GLOBALS['BE_USER']->workspace`. If the workspace is a
custom workspace you will find its record loaded in
:code:`$GLOBALS['BE_USER']->workspaceRec`.

The values for workspaces is either 0 (online/live) or the uid of the
corresponding entry in the :code:`sys_workspace` table.


.. _workspaces-tcemain:

Using TCEmain with workspaces
"""""""""""""""""""""""""""""

Since admin users are also restricted by the workspace it is not
possible to save any live records when in a workspace. However for
very special occasions you might need to bypass this and to do so, you
can set the instance variable
:code:`t3lib_tcemain::bypassWorkspaceRestrictions` to TRUE. An example of
this is when users are updating their user profile using the "User Tool >
User Settings" module; that actually allows them to save to a live record
(their user record) while in a draft workspace.


.. _workspaces-moving:

Moving in workspaces
""""""""""""""""""""

TYPO3 4.2 and beyond supports moving for "Element" type versions in
workspaces. Technically this works by creating a new online
placeholder record (like for new elements in a workspace) in the
target location with :code:`t3ver_state = 3` (move-to placeholder) and a
field, :code:`t3ver_move_id`, holding the uid of the record to move
(source record) upon publishing. In addition, a new version of the
source record is made and has :code:`t3ver_state = 4` (move-to pointer).
This version is simply necessary in order for the versioning system to
have something to publish for the move operation.

So in summary, two records are created for a move operation in a
workspace: The placeholder (online, with :code:`t3ver_state = 3` and :code:`t3ver_move_id`
set) and a new version (:code:`t3ver_state = 4`) of the online source record (the one
being moved).

When the version of the source is published a look up will be made to
see if a placeholder exists for a move operation and if so the record
will take over the pid / "sortby" value upon publishing.

Preview of move operations is almost fully functional through the
:code:`t3lib_page::versionOL()` and :code:`t3lib_BEfunc::workspaceOL()` functions.
When the online placeholder is selected it simply looks up the source
record, overlays any version on top and displays it. When the source
record is selected it should simply be discarded in case shown in
context where ordering or position matters (like in menus or column
based page content). This is done in the appropriate places.
