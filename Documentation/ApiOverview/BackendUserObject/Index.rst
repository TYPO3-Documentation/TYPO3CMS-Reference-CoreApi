.. include:: ../../Includes.txt

.. _be-user:

===================
Backend User Object
===================

The backend user of a session is always available in extensions
as the global variable :php:`$GLOBALS['BE_USER']`. The object is created in
:php:`\TYPO3\CMS\Core\Core\Bootstrap::initializeBackendUser()`
and is an instance of the class :code:`\TYPO3\CMS\Core\Authentication\BackendUserAuthentication`
(which extends :php:`\TYPO3\CMS\Core\Authentication\AbstractUserAuthentication`).

.. _be-user-check:

Checking User Access
====================

The :php:`$GLOBALS['BE_USER']` object is mostly used to check user access right,
but contains other helpful information. This is presented here by a few examples:


.. _be-user-access-current:

Checking Access to Current Backend Module
=========================================

:php:`$MCONF` is module configuration and the key :php:`$MCONF['access']` determines
the access scope for the module. This function call will check if the
:php:`$GLOBALS['BE_USER']` is allowed to access the module and if not, the function
will exit with an error message. ::

      $GLOBALS['BE_USER']->modAccess($MCONF);


.. _be-user-access-any:

Checking Access to any Backend Module
=====================================

If you know the module key you can check if the module is included in
the access list by this function call::

      $GLOBALS['BE_USER']->check('modules', 'web_list');

Here access to the module **WEB > List** is checked.


.. _be-user-access-tables:

Access to Tables and Fields?
============================

The same function :php:`->check()` can actually check all the :php:`->groupLists`
inside :php:`$GLOBALS['BE_USER']`. For instance:

Checking modify access to the table "pages"::

      $GLOBALS['BE_USER']->check('tables_modify', 'pages');

Checking read access to the table "tt\_content"::

      $GLOBALS['BE_USER']->check('tables_select', 'tt_content');

Checking if a table/field pair is allowed explicitly through the
"Allowed Excludefields"::

      $GLOBALS['BE_USER']->check('non_exclude_fields', $table . ':' . $field);


.. _be-user-admin:

Is "admin"?
===========

If you want to know if a user is an "admin" user (has complete
access), just call this method::

      $GLOBALS['BE_USER']->isAdmin();


.. _be-user-page:

Read Access to a Page?
======================

This function call will return true if the user has read access to a
page (represented by its database record, :php:`$pageRec`)::

      $GLOBALS['BE_USER']->doesUserHaveAccess($pageRec, 1);

Changing the "1" for other values will check other permissions:

- use "2" for checking if the user may edit the page
- use "4" for checking if the user may delete the page.


.. _be-user-mount:

Is a Page Inside a DB Mount?
============================

Access to a page should not be checked only based on page permissions
but also if a page is found within a DB mount for ther user. This can
be checked by this function call (:php:`$id` is the page uid)::

      $GLOBALS['BE_USER']->isInWebMount($id)


.. _be-user-pageperms:

Selecting Readable Pages From Database?
=======================================

If you wish to make a SQL statement which selects pages from the
database and you want it to be only pages that the user has read
access to, you can have a proper WHERE clause returned by this
function call::

      $GLOBALS['BE_USER']->getPagePermsClause(1);

Again the number "1" represents the "read" permission; "2" is "edit"
and "4" is "delete" permission. The result from the above query could be this string::

   ((pages.perms_everybody & 1 = 1)OR(pages.perms_userid = 2 AND pages.perms_user & 1 = 1)OR(pages.perms_groupid in (1) AND pages.perms_group & 1 = 1))


.. _be-user-module-save:

Saving Module Data
==================

This stores the input variable :php:`$compareFlags` (an array!) with the key
"tools\_beuser/index.php/compare" ::

       $compareFlags = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('compareFlags');
       $GLOBALS['BE_USER']->pushModuleData('tools_beuser/index.php/compare', $compareFlags);


.. _be-user-module-get:

Getting Module Data
===================

This gets the module data with the key
"tools\_beuser/index.php/compare" (lasting only for the session) ::

       $compareFlags = $GLOBALS['BE_USER']->getModuleData('tools_beuser/index.php/compare', 'ses');


.. _be-user-tsconfig:

Getting TSconfig
================

This function can return a value from the "User TSconfig" structure of
the user. In this case the value for "options.clipboardNumberPads"::

   $tsconfig = $GLOBALS['BE_USER']->getTSConfig();
   $clipboardNumberPads = $tsconfig['options.']['clipboardNumberPads'] ?? '';


.. _be-user-name:

Getting the Username
====================

The full "be\_users" record of a authenticated user is available in
:php:`$GLOBALS['BE_USER']`->user as an array. This will return the "username"::

      $GLOBALS['BE_USER']->user['username']


.. _be-user-configuration:

Get User Configuration Value
============================

The internal :php:`->uc` array contains options which are managed by the
User Tools > User Settings module (extension "setup"). These values are accessible in
the :php:`$GLOBALS['BE_USER']->uc` array. This will return the current state of
"Notify me by email, when somebody logs in from my account" for the user::

      $GLOBALS['BE_USER']->uc['emailMeAtLogin']
