.. include:: ../../Includes.txt


.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.


.. _be-user:

Backend User Object
-------------------

The backend user of a session is always available to the backend
scripts as the global variable :code:`$BE_USER`. The object is created in
init.php and is an instance of the class "t3lib\_beUserAuth" (which
extends "t3lib\_userAuthGroup" which extends "t3lib\_userAuth").

In addition to :code:`$BE_USER` two other global variables are of interest -
$WEBMOUNTS and $FILEMOUNTS, each holding an array with the DB mounts
and File mounts of the :code:`$BE_USER`.


.. _be-user-check:

Checking user access
^^^^^^^^^^^^^^^^^^^^

The :code:`$BE_USER` object is mostly used to check user access right,
but contains other helpful information. This is presented here by
way of a few examples:


.. _be-user-access-current:

Checking access to current backend module
"""""""""""""""""""""""""""""""""""""""""

:code:`$MCONF` is module configuration and the key :code:`$MCONF['access']` determines
the access scope for the module. This function call will check if the
:code:`$BE_USER` is allowed to access the module and if not, the function
will exit with an error message.

::

      $BE_USER->modAccess($MCONF, 1);


.. _be-user-access-any:

Checking access to any backend module
"""""""""""""""""""""""""""""""""""""

If you know the module key you can check if the module is included in
the access list by this function call:

::

      $BE_USER->check('modules', 'web_list');

Here access to the module "Web > List" is checked.


.. _be-user-access-tables:

Access to tables and fields?
""""""""""""""""""""""""""""

The same function :code:`->check()` can actually check all the :code:`->groupLists`
inside :code:`$BE_USER`. For instance:

Checking modify access to the table "pages":

::

      $BE_USER->check('tables_modify', 'pages');

Checking read access to the table "tt\_content":

::

      $BE_USER->check('tables_select', 'tt_content');

Checking if a table/field pair is allowed explicitly through the
"Allowed Excludefields":

::

      $BE_USER->check('non_exclude_fields', $table . ':' . $field);


.. _be-user-admin:

Is "admin"?
"""""""""""

If you want to know if a user is an "admin" user (has complete
access), just call this method:

::

      $BE_USER->isAdmin();


.. _be-user-page:

Read access to a page?
""""""""""""""""""""""

This function call will return true if the user has read access to a
page (represented by its database record, :code:`$pageRec`):

::

      $BE_USER->doesUserHaveAccess($pageRec, 1);

Changing the "1" for other values will check other permissions:

- use "2" for checking if the user may edit the page
- use "4" for checking if the user may delete the page.


.. _be-user-mount:

Is a page inside a DB mount?
""""""""""""""""""""""""""""

Access to a page should not be checked only based on page permissions
but also if a page is found within a DB mount for ther user. This can
be checked by this function call (:code:`$id` is the page uid):

::

      $BE_USER->isInWebMount($id)


.. _be-user-pageperms:

Selecting readable pages from database?
"""""""""""""""""""""""""""""""""""""""

If you wish to make a SQL statement which selects pages from the
database and you want it to be only pages that the user has read
access to, you can have a proper WHERE clause returned by this
function call:

::

      $BE_USER->getPagePermsClause(1);

Again the number "1" represents the "read" permission; "2" is "edit"
and "4" is delete permission. The result from the above query could be this string:

::

   ((pages.perms_everybody & 1 = 1)OR(pages.perms_userid = 2 AND pages.perms_user & 1 = 1)OR(pages.perms_groupid in (1) AND pages.perms_group & 1 = 1))


.. _be-user-module-save:

Saving module data
""""""""""""""""""

This stores the input variable :code:`$compareFlags` (an array!) with the key
"tools\_beuser/index.php/compare"

::

       $compareFlags = t3lib_div::GPvar('compareFlags');
       $BE_USER->pushModuleData('tools_beuser/index.php/compare', $compareFlags);


.. _be-user-module-get:

Getting module data
"""""""""""""""""""

This gets the module data with the key
"tools\_beuser/index.php/compare" (lasting only for the session)

::

       $compareFlags = $BE_USER->getModuleData('tools_beuser/index.php/compare', 'ses');


.. _be-user-tsconfig:

Getting TSconfig
""""""""""""""""

This function can return a value from the "User TSconfig" structure of
the user. In this case the value for "options.clipboardNumberPads":

::

      $BE_USER->getTSConfigVal('options.clipboardNumberPads');


.. _be-user-name:

Getting the username
""""""""""""""""""""

The full "be\_users" record of a authenticated user is available in
:code:`$BE_USER`->user as an array. This will return the "username":

::

      $BE_USER->user['username']


.. _be-user-configuration:

Get User Configuration value
""""""""""""""""""""""""""""

The internal :code:`->uc` array contains options which are managed by the
User Tools > User Settings module (extensions "setup"). These values are accessible in
the :code:`$BE_USER->uc` array. This will return the current state of
"Condensed mode" for the user:

::

      $BE_USER->uc['condensedMode']
