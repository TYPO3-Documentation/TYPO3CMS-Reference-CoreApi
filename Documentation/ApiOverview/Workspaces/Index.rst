.. include:: /Includes.rst.txt
.. index::
   Versioning
   Workspaces
.. _workspaces:

=========================
Versioning and Workspaces
=========================

TYPO3 provides a feature called "workspaces", whereby changes
can be made to the content of the web site without affecting the
currently visible (live) version. Changes can be previewed and
go through an approval process before publishing.

The technical background and a practical user guide to this feature
are provided in the :doc:`"workspaces" system extension manual <ext_workspaces:Index>`.

All the information necessary for making any database table
compatible with workspaces is described in the
TCA reference (in the :ref:`description of the "ctrl" section <t3tca:ctrl>`
and in the :ref:`description of the "versioningWS" property <t3tca:ctrl-reference-versioningws>`).

You might want to turn the workspace off for certain tables.
The only way to do so is with a :file:`Configuration/TCA/Overrides/example_table.php`:

.. code-block:: php
   :caption: EXT:some_extension/Configuration/TCA/Overrides/example_table.php

   $GLOBALS['TCA']['example_table']['ctrl']['versioningWS'] = false;

See :ref:`t3sitepackage:start` and :ref:`storing-changes-extension-overrides` .

.. note::

   This will lead to all t3ver_* fields of the example table to be marked as obsolete,
   if they have not be defined explicitly in an extension. A subsequent DB schema update will then drop these fields.

The concept of workspaces needs attention from extension programmers.
The implementation of workspaces is however made, so that no critical
problems can appear with old extensions;

-  First of all the "Live workspace" is no different from how TYPO3 has
   been working for years so that will be supported out of the box
   (except placeholder records must be filtered out in the frontend with
   :code:`t3ver_state !=` , see below).

-  Secondly, all permission related issues are implemented in DataHandler so
   the worst your users can experience is an error message.

However, you probably want to update your extension so that in the
backend the current workspace is reflected in the records shown and
the preview of content in the frontend works as well. Therefore this
chapter has been written with instructions and insight into the issues
you are facing.


.. _workspaces-frontend:

Frontend challenges in general
==============================

For the frontend the challenges are mostly related to creating correct
previews of content in workspaces. For most extensions this will work
transparently as long as they use the API functions in TYPO3 to
request records from the system.

The most basic form of a preview is when a live record is selected and
you lookup a future version of that record belonging to the current
workspace of the logged in backend user. This is very easy as long as
a record is selected based on its "uid" or "pid" fields which are not
subject to versioning: call :code:`sys_page->versionOL()` after
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
all that is handled by the
:code:`\TYPO3\CMS\Core\Domain\Repository\PageRepository` class which includes
functions for "enableFields" and "deleted" so it will work out of the
box for you. But as soon as you do selection based on other fields
like email, username, alias etc. it will fail.

.. _workspaces-frontend-summary:

Summary
-------

**Challenge:** How to preview elements which are disabled by
"enableFields" in the live version but not necessarily in the offline
version. Also, how to filter out new live records with :code:`t3ver_state`
set to 1 (placeholder for new elements) but only when not previewed.

**Solution:** Disable check for :code:`enableFields`/:code:`where_del_hidden` on
live records and check for them in versionOL on input record.


.. _workspaces-frontend-guidelines:

Frontend implementation guidelines
==================================

Any place where enableFields() are not used for selecting in the
frontend you must at least check that :code:`t3ver_state != 1` so
placeholders for new records are not displayed.

If you need to detect preview mode for versioning and workspaces you
can use the Context object.
:code:`GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('workspace', 'id', 0);`
gives you the id of the workspace of the current backend user. Used
for preview of workspaces.

Use the following API function for support of version previews in the
frontend:


.. rst-class:: dl-parameters

\\TYPO3\\CMS\\Core\\Domain\\Repository\\PageRepository->versionOL($table, &$row, $unsetMovePointers=FALSE)
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

   .. code-block:: php
      :caption: EXT:some_extension/Classes/SomeClass.php

      // use TYPO3\CMS\Core\Domain\Repository\PageRepository;
      // use TYPO3\CMS\Core\Utility\GeneralUtility;

      $pageRepository = GeneralUtility::makeInstance(PageRepository);
      $result = $queryBuilder->executeQuery();
      while ($row = $result->fetchAssociative()) {
          $pageRepository->versionOL($table, $row);
          if (is_array($row)) {
              // ...
          }
          // ...
      }

   When the live record is selected, call :code:`->versionOL()` and make
   sure to check if the input row (passed by reference) is still an array.

   The third argument, :code:`$unsetMovePointers = FALSE`, can be set to
   TRUE when selecting records for display ordered by their position in
   the page tree. Difficult to explain easily, so only use this option if you
   don't get a correct preview of records that has been moved in a
   workspace (only for "element" type versioning)


.. _workspaces-frontend-problems:

Frontend scenarios impossible to preview
========================================

These issues are not planned to be supported for preview:

-  Lookups and searching for records based on other fields than
   uid, pid or "enableFields" will never reflect workspace content since
   overlays happen to online records *after* they are selected.

   -  This problem can largely be avoided for  *versions of new records*
      because versions of a "New"-placeholder can mirror certain fields down
      onto the placeholder record. For the :code:`tt_content` table this is
      configured as:

      :php:`shadowColumnsForNewPlaceholders'=> 'sys_language_uid,l18n_parent,colPos,header'`

      so that these fields used for column position, language and header title are also updated
      in the placeholder thus creating a correct preview in the frontend.

   -  For *versions of existing records* the problem is in reality reduced
      a lot because normally you don't change the column or language fields
      after the record is first created anyway! But in theory the preview
      can fail.

   -  When changing the type of a page (e.g. from "Standard" to "External
      URL") the preview might fail in cases where a look up is done on the
      :code:`doktype` field of the live record.

      -  Page shortcuts might not work properly in preview.

      -  Mount Points might not work properly in preview.

-  It is impossible to preview the value of :code:`count(*)` selections since
   we would have to traverse all records and pass them through
   :code:`->versionOL()` before we would have a reliable result!

-  In :code:`\TYPO3\CMS\Core\Domain\Repository\PageRepository::getPageShortcut()`,
   :code:`PageRepository->getMenu()` is called with an
   additional :sql:`WHERE` clause which will ignore changes made in workspaces.
   This could also be the case in other places where :code:`PageRepository->getMenu()`
   is used (but a search shows it is not a big problem).
   In this case we will for now accept that a wrong shortcut destination
   can be experienced during previews.


.. _workspaces-backend:

Backend challenges
==================

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
-----------------------------------------

.. rst-class:: dl-parameters

:php:`BackendUtility::workspaceOL()`
   Overlaying record with workspace version if any. Works like
   :code:`->sys_page->versionOL()` does, but for the backend. Input record must
   have fields only from the table (no pseudo fields) and the record is
   passed by reference.

   .. todo: Find a better example
            If looped (while), resultset is retrieved and looped completely, as there is
            no "break" which could leave unretrieved results. So the single retrieve
            statement after the loop do not make any sense, as resultset is at the end,
            and would return false instead of a row ....
            Next point is, that queryBuilder createNamedParameter does not make any
            sense either, as it not assigned anywhere or used?

   **Example:**

   .. code-block:: php
      :caption: EXT:some_extension/Classes/SomeClass.php

      // use TYPO3\CMS\Backend\Utility\BackendUtility
      // use TYPO3\CMS\Core\Database\Connection;

      $result = $queryBuilder
         ->select('*')
         ->from('pages')
         ->where(
            $queryBuilder->expr()->eq('uid',
               $queryBuilder->createNamedParameter($id, Connection::PARAM_INT)
            )
         )
         ->executeQuery();
      $row = $result->fetchAssociative();
      BackendUtility::workspaceOL('pages', $row);

:php:`BackendUtility::getRecordWSOL()`
   Gets record from table and overlays the record with workspace version
   if any.

   **Example:**

   .. code-block:: php
      :caption: EXT:some_extension/Classes/SomeClass.php

      // use \TYPO3\CMS\Backend\Utility\BackendUtility
      $row = BackendUtility::getRecordWSOL($table, $uid);
      // This is the same as:
      $row = BackendUtility::getRecord($table, $uid);
      BackendUtility::workspaceOL($table, $row);

:php:`BackendUtility::isPidInVersionizedBranch()`
   Will fetch the rootline for the pid, then check if anywhere in the
   rootline there is a branch point. Returns either "branchpoint" (if
   branch) or "first" (if page) or false if nothing. Alternatively, it
   returns the value of :code:`t3ver_stage` for the branchpoint (if any).


:php:`BackendUtility::getWorkspaceVersionOfRecord()`
   Returns offline workspace version of a record, if found.


:php:`BackendUtility::getLiveVersionOfRecord()`
   Returns live version of workspace version.

:php:`WorkspaceRestriction`
   It limits an SQL query to only select records which are "online" (pid != -1)
   and in live or current workspace:

   .. code-block:: php

      // use TYPO3\CMS\Core\Database\Query\Restriction\WorkspaceRestriction


:php:`$BE_USER->workspaceCannotEditRecord()`
   Checking if editing of an existing record is allowed in current
   workspace if that is offline.

:php:`$BE_USER->workspaceCreateNewRecord()`
   Checks if new records can be created in a certain page (according to
   workspace restrictions).

:php:`$BE_USER->checkWorkspace()`
   Checks how the users access is for a specific workspace.

:php:`$BE_USER->checkWorkspaceCurrent()`
   Like ->checkWorkspace() but returns status for the current workspace.

:php:`$BE_USER->setWorkspace()`
   Setting another workspace for backend user.

:php:`$BE_USER->setWorkspacePreview()`
   Setting frontend preview state.


.. _workspaces-backend-acess:

Backend module access
=====================

You can restrict access to backend modules by setting the value of the
:php:`workspaces` key in the
:ref:`backend module configuration <backend-modules-configuration>`:

..  code-block:: php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php

    return [
        'web_examples' => [
            'parent' => 'web',
            // Only available in live workspace
            'workspaces' => 'live',
            // ... other configuration
        ],
    ];

The value can be one of:

*   :php:`*` (always)
*   :php:`live`
*   :php:`offline`


.. _workspaces-detection:

Detecting current workspace
===========================

You can always check what the current workspace of the backend user is
by reading :code:`WorkspaceAspect->getWorkspaceId()`. If the workspace is a
custom workspace you will find its record loaded in
:code:`$GLOBALS['BE_USER']->workspaceRec`.

The values for workspaces is either 0 (online/live) or the uid of the
corresponding entry in the :code:`sys_workspace` table.


.. _workspaces-tcemain:

Using DataHandler with workspaces
=================================

Since admin users are also restricted by the workspace it is not
possible to save any live records when in a workspace. However for
very special occasions you might need to bypass this and to do so, you
can set the instance variable
:code:`\TYPO3\CMS\Core\DataHandling\DataHandler::bypassWorkspaceRestrictions` to TRUE. An example of
this is when users are updating their user profile using the "User Tool >
User Settings" module; that actually allows them to save to a live record
(their user record) while in a draft workspace.


.. _workspaces-moving:

Moving in workspaces
====================

TYPO3 v4.2 and beyond supports moving for "Element" type versions in
workspaces. A new version of the
source record is made and has :code:`t3ver_state = 4` (move-to pointer).
This version is necessary in order for the versioning system to
have something to publish for the move operation.

When the version of the source is published a look up will be made to
see if a placeholder exists for a move operation and if so the record
will take over the pid / "sortby" value upon publishing.

Preview of move operations is almost fully functional through the
:code:`\TYPO3\CMS\Core\Domain\Repository\PageRepository::versionOL()` and
:code:`\TYPO3\CMS\Backend\Utility\BackendUtility::workspaceOL()` functions.
When the online placeholder is selected it looks up the source
record, overlays any version on top and displays it. When the source
record is selected it should be discarded in case shown in
context where ordering or position matters (like in menus or column
based page content). This is done in the appropriate places.

Persistence in-depth scenarios
==============================

The following section represents how database records are actually persisted in a database
table for different scenarios and previously performed actions.

Placeholders
------------

Workspace placeholders are stored in field :code:`t3ver_state` which can have the following values:

`-1`
   * **new placeholder version**
   * the workspace pendant for a new placeholder (see value `1`)

`0`
   * **default state**
   * representing a workspace modification of an existing record (when :code:`t3ver_wsid > 0`)

`1`
   * **new placeholder**
   * live pendant for a record that is new, used as insertion point concerning sorting

`2`
   * **delete placeholder**
   * representing a record that is deleted in workspace

`4`
   * **move pointer**
   * workspace pendant of a record that shall be moved

Overview
--------

.. csv-table:: Overview of `pages` records (not all possible scenarios are shown)
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   10,0,0,128,0,0,0,0,0,example.org website
   20,10,0,128,0,0,0,0,0,Current issues
   21,10,0,256,0,0,0,20,1,Actualité
   22,10,0,384,0,0,0,20,2,Neuigkeiten
   30,10,0,512,0,0,0,0,0,Other topics
   ...,...,...,...,...,...,...,...,...,...,...
   41,30,0,128,1,0,1,0,0,Topic #1 new
   42,-1,0,128,1,41,-1,0,0,Topic #2 new

.. csv-table:: Overview of regular records (e.g. `tx_record`, `tt_content`, ... but not `pages`)
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   11,20,0,128,0,0,0,0,0,Article #1
   12,20,0,256,0,0,0,0,0,Article #2
   13,20,0,384,0,0,0,0,0,Article #3
   ...,...,...,...,...,...,...,...,...,...,...
   21,-1,0,128,1,11,0,0,0,Article #1 modified
   22,-1,0,256,1,12,2,0,0,Article #2 deleted
   23,-1,0,384,1,13,4,0,0,Article #3 moved
   25,20,0,512,1,0,1,0,0,Article #4 new
   26,-1,0,512,1,25,-1,0,0,Article #4 new
   27,20,1,640,0,0,1,0,0,Article #5 discarded
   28,-1,1,640,0,27,-1,0,0,Article #5 discarded
   29,41,0,128,1,0,1,0,0,Topic #1 Article new
   30,-1,0,128,1,29,-1,0,0,Topic #1 Article new
   ...,...,...,...,...,...,...,...,...,...,...
   31,20,0,192,1,0,1,11,1,Entrefilet #1 (fr)
   32,-1,0,192,1,31,-1,11,1,Entrefilet #1 (fr)
   33,20,0,224,1,0,1,11,2,Beitrag #1 (de)
   34,-1,0,224,1,33,-1,11,2,Beitrag #1 (de)

Scenario: Create new page
-------------------------

.. csv-table:: Page "Topic #1 new" is created with their according placeholders
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   10,0,0,128,0,0,0,0,0,example.org website
   ...,...,...,...,...,...,...,...,...,...,...
   30,10,0,512,0,0,0,0,0,Other topics
   ...,...,...,...,...,...,...,...,...,...,...
   41,**30**,0,128,1,0,**1**,0,0,Topic #1 new
   42,-1,0,128,1,**41**,**-1**,0,0,Topic #2 new

* record :code:`uid = 41` defines :code:`sorting` insertion point page :code:`pid = 30` in live workspace, :code:`t3ver_state = 1`
* record :code:`uid = 42` contains actual version information, pointing back to new placeholder, :code:`t3ver_oid = 41`,
  indicating new version state :code:`t3ver_state = -1`

Scenario: Modify record
-----------------------

.. csv-table:: Record "Article #1" is modified in workspace
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   11,20,0,128,0,0,0,0,0,Article #1
   ...,...,...,...,...,...,...,...,...,...,...
   21,-1,0,128,1,**11**,0,0,0,Article #1 modified

* record :code:`uid = 21` contains actual version information, pointing back to live pendant, :code:`t3ver_oid = 11`,
  using default version state :code:`t3ver_state = 0`

Scenario: Delete record
-----------------------

.. csv-table:: Record "Article #2" is deleted in workspace
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   12,20,0,256,0,0,0,0,0,Article #2
   ...,...,...,...,...,...,...,...,...,...,...
   22,-1,0,256,1,**12**,**2**,0,0,Article #2 deleted

* record :code:`uid = 22` represents delete placeholder :code:`t3ver_state = 2`, pointing back to live pendant, :code:`t3ver_oid = 12`


.. _scenario-create-new-record-on-existing-page:

Scenario: Create new record on existing page
--------------------------------------------

.. csv-table:: Record "Article #4" is created on existing page
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   ...,...,...,...,...,...,...,...,...,...,...
   25,**20**,0,512,1,0,**1**,0,0,Article #4 new
   26,-1,0,512,1,**25**,**-1**,0,0,Article #4 new

* record :code:`uid = 25` defines :code:`sorting` insertion point on page :code:`pid = 20` in live workspace, :code:`t3ver_state = 1`
* record :code:`uid = 26` contains actual version information, pointing back to new placeholder, :code:`t3ver_oid = 25`,
  indicating new version state :code:`t3ver_state = -1`

Scenario: Create new record on page that is new in workspace
------------------------------------------------------------

.. csv-table:: Record "Topic #1 Article" is created on page that is new in workspace
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   ...,...,...,...,...,...,...,...,...,...,...
   29,**41**,0,128,1,0,**1**,0,0,Topic #1 Article new
   30,-1,0,128,1,**29**,**-1**,0,0,Topic #1 Article new

* record :code:`uid = 29` defines :code:`sorting` insertion point on page :code:`pid = 41` in live workspace, :code:`t3ver_state = 1`
* record :code:`uid = 30` contains actual version information, pointing back to new placeholder, :code:`t3ver_oid = 29`,
  indicating new version state :code:`t3ver_state = -1`
* side-note: :code:`pid = 41` points to new placeholder of a page that has been created in workspace

.. _scenario-discard-record-workspace-modifications:

Scenario: Discard record workspace modifications
------------------------------------------------

.. csv-table:: Previously created record "Article #5" is discarded
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   ...,...,...,...,...,...,...,...,...,...,...
   27,20,**1**,640,**0**,0,1,0,0,Article #5 discarded
   28,-1,**1**,640,**0**,27,-1,0,0,Article #5 discarded

* previously records :code:`uid = 27` and :code:`uid = 28` have been created in workspace
  (similar to :ref:`scenario-create-new-record-on-existing-page`)
* both records represent the discarded state by having assigned :code:`deleted = 1` and :code:`t3ver_wsid = 0`

Scenario: Create new record localization
----------------------------------------

.. csv-table:: Record "Article #1" is localized to French and German
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   11,20,0,128,0,0,0,0,0,Article #1
   ...,...,...,...,...,...,...,...,...,...,...
   31,20,0,192,1,1,0,**11**,**1**,Entrefilet #1 (fr)
   32,-1,0,192,1,31,-1,**11**,**1**,Entrefilet #1 (fr)
   33,20,0,224,1,0,1,**11**,**2**,Beitrag #1 (de)
   34,-1,0,224,1,33,-1,**11**,**2**,Beitrag #1 (de)

* *principles of creating new records with according placeholders applies in this scenario*
* records :code:`uid = 31` and :code:`uid = 32` represent localization to French :code:`sys_language_uid = 1`,
  pointing back to their localization origin :code:`l10n_parent = 11`
* records :code:`uid = 33` and :code:`uid = 34` represent localization to German :code:`sys_language_uid = 2`,
  pointing back to their localization origin :code:`l10n_parent = 11`

Scenario: Create new record, then move to different page
--------------------------------------------------------

.. csv-table:: Record "Article #4" is created on existing page, then moved to different page
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   ...,...,...,...,...,...,...,...,...,...,...
   25,**30**,0,512,1,0,1,0,0,Article #4 new & moved
   26,-1,0,512,1,25,-1,0,0,Article #4 new & moved

* previously records :code:`uid = 25` and :code:`uid = 26` have been created in workspace
  (exactly like in :ref:`scenario-create-new-record-on-existing-page`), then record :code:`uid = 25`
  has been moved to target target page :code:`pid = 30`
* record :code:`uid = 25` directly uses target page :code:`pid = 30`

Scenario: Create new record, then delete
----------------------------------------

.. csv-table:: Record "Article #4" is created on existing page, then deleted
   :header-rows: 1
   :widths: 3, 3, 6, 6, 9, 8, 9, 11, 9, 13, 21

   uid,pid,deleted,sorting,t3ver_wsid,t3ver_oid,t3ver_state,l10n_parent,sys_language_uid,title
   ...,...,...,...,...,...,...,...,...,...,...
   25,20,**1**,512,**0**,0,1,0,0,Article #4 new & deleted
   26,-1,**1**,512,**0**,25,-1,0,0,Article #4 new & deleted

* previously records :code:`uid = 25` and :code:`uid = 26` have been created in workspace
  (exactly like in :ref:`scenario-create-new-record-on-existing-page`), then record :code:`uid = 25`
  has been deleted
* records :code:`uid = 25` and :code:`uid = 26` are directly discarded in workspace
  (similar to :ref:`scenario-discard-record-workspace-modifications`)
