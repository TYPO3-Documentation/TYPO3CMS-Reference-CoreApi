

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


Checking user access for $BE\_USER from PHP
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The backend user of a session is always available to the backend
scripts as the global variable $BE\_USER. The object is created in
init.php and is an instance of the class "t3lib\_beUserAuth" (which
extends "t3lib\_userAuthGroup" which extends "t3lib\_userAuth").

In addition to $BE\_USER two other global variables are of interest -
$WEBMOUNTS and $FILEMOUNTS, each holding an array with the DB mounts
and File mounts of the $BE\_USER.

In order to introduce how the $BE\_USER object can be helpful to your
backend scripts/modules, this is a few examples:


((generated))
"""""""""""""

Checking access to current backend module
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

$MCONF is module configuration and the key $MCONF["access"] determines
the access scope for the module. This function call will check if the
$BE\_USER is allowed to access the module and if not, the function
will exit with an error message.

::

      $BE_USER->modAccess($MCONF, 1);


Checking access to any backend module
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you know the module key you can check if the module is included in
the access list by this function call:

::

      $BE_USER->check('modules', 'web_list');

Here access to the module "Web>List" is checked.


Access to tables and fields?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The same function ->check() can actually check all the ->groupLists
inside $BE\_USER. For instance:

Checking modify access to the table "pages":

::

      $BE_USER->check('tables_modify', 'pages');

Checking selecting access to the table "tt\_content":

::

      $BE_USER->check('tables_select', 'tt_content');

Checking if a table/field pair is allowed explicitly through the
"Allowed Excludefields":

::

      $BE_USER->check('non_exclude_fields', $table . ':' . $field);


Is "admin"?
~~~~~~~~~~~

If you want to know if a user is an "admin" user (has complete
access), just call this method:

::

      $BE_USER->isAdmin();


Read access to a page?
~~~~~~~~~~~~~~~~~~~~~~

This function call will return true if the user has read access to a
page (represented by its database record, $pageRec):

::

      $BE_USER->doesUserHaveAccess($pageRec, 1);

Changing the "1" for other values will check other permissions. For
example "2" will check id the user may edit the page and "4" will
check if the page can be deleted.


Is a page inside a DB mount?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Access to a page should not be checked only based on page permissions
but also if a page is found within a DB mount for ther user. This can
be checked by this function call ($id is the page uid):

::

      $BE_USER->isInWebMount($id)


Selecting readable pages from database?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you wish to make a SQL statement which selects pages from the
database and you want it to be only pages that the user has read
access to, you can have a proper WHERE clause returned by this
function call:

::

      $BE_USER->getPagePermsClause(1);

Again the number "1" represents the "read" permission; "2" would
represent "edit" permission and "4" would be delete permission and so
on. The result from the above query could be this string:

::

   ((pages.perms_everybody & 1 = 1)OR(pages.perms_userid = 2 AND pages.perms_user & 1 = 1)OR(pages.perms_groupid in (1) AND pages.perms_group & 1 = 1))


Saving module data
~~~~~~~~~~~~~~~~~~

This stores the input variable $compareFlags (an array!) with the key
"tools\_beuser/index.php/compare"

::

       $compareFlags = t3lib_div::GPvar('compareFlags');
       $BE_USER->pushModuleData('tools_beuser/index.php/compare', $compareFlags);


Getting module data
~~~~~~~~~~~~~~~~~~~

This gets the module data with the key
"tools\_beuser/index.php/compare" (lasting only for the session)

::

       $compareFlags = $BE_USER->getModuleData('tools_beuser/index.php/compare', 'ses');


Returning object script from TSconfig
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This function can return a value from the "User TSconfig" structure of
the user. In this case the value for "options.clipboardNumberPads":

::

      $BE_USER->getTSConfigVal('options.clipboardNumberPads');


Getting the username
~~~~~~~~~~~~~~~~~~~~

The full "be\_users" record of a authenticated user is available in
$BE\_USER->user as an array. This will return the "username":

::

      $BE_USER->user['username']


Get User Configuration value
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The internal ->uc array contains options which are managed by the
User>Setup module (extensions "setup"). These values are accessible in
the $BE\_USER->uc array. This will return the current state of
"Condensed mode" for the user:

::

      $BE_USER->uc['condensedMode']

