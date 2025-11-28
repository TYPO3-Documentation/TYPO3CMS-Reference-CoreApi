.. include:: /Includes.rst.txt
.. index::
   Backend user
   $GLOBALS; BE_USER
.. _be-user:

===================
Backend user object
===================

The backend user of a session is always available in extensions
as the global variable :php:`$GLOBALS['BE_USER']`. The object is created in
:php:`\TYPO3\CMS\Backend\Middleware\BackendUserAuthenticator` middleware for a standard web request
and is an instance of the class :php:`\TYPO3\CMS\Core\Authentication\BackendUserAuthentication`
(which extends :php:`\TYPO3\CMS\Core\Authentication\AbstractUserAuthentication`).

When working with CLI and commands you might initialize the backend user object with :php:`\TYPO3\CMS\Core\Core\Bootstrap::initializeBackendUser()`. In addition, you can call :php:`\TYPO3\CMS\Core\Core\Bootstrap::initializeBackendAuthentication()` to load the language of the CLI user set in the backend so that view helpers (like :php:`f:translate()`) used in the CLI resolve to the correct language.

.. index:: Backend user; Access
.. _be-user-check:

Checking user access
====================

The :php:`$GLOBALS['BE_USER']` object is mostly used to check user access right,
but contains other helpful information. This is presented here by a few examples:


.. _be-user-access-any:

Checking access to any backend module
=====================================

If you know the module key you can check if the module is included in
the access list by this function call:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $GLOBALS['BE_USER']->check('modules', 'web_list');

Here access to the module :guilabel:`Content > Records` is checked.


.. index::
   Backend user; Table access
   Backend user; check
.. _be-user-access-tables:

Access to tables and fields?
============================

The same function :php:`->check()` can actually check all the group-based permissions
inside :php:`$GLOBALS['BE_USER']`. For instance:

Checking modify access to the table "pages":

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $GLOBALS['BE_USER']->check('tables_modify', 'pages');

Checking read access to the table "tt\_content":

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $GLOBALS['BE_USER']->check('tables_select', 'tt_content');

Checking if a table/field pair is allowed explicitly through the
"Allowed Excludefields":

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   $GLOBALS['BE_USER']->check('non_exclude_fields', $table . ':' . $field);

.. index:: Backend user; isAdmin
.. _be-user-admin:

Is "admin"?
===========

If you want to know if a user is an "admin" user (has complete
access), just call this method:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $GLOBALS['BE_USER']->isAdmin();


.. index::
   Backend user; Page access
   Backend user; doesUserHaveAccess
.. _be-user-page:

Read access to a page?
======================

This function call will return true if the user has read access to a
page (represented by its database record, :php:`$pageRec`):

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $GLOBALS['BE_USER']->doesUserHaveAccess($pageRec, 1);

Changing the "1" for other values will check other permissions:

- use "2" for checking if the user may edit the page
- use "4" for checking if the user may delete the page.


.. index::
   Backend user; DB mount
   Backend user; isInWebMount
.. _be-user-mount:

Is a page inside a DB mount?
============================

Access to a page should not be checked only based on page permissions
but also if a page is found within a DB mount for ther user. This can
be checked by this function call (:php:`$id` is the page uid):

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $GLOBALS['BE_USER']->isInWebMount($id)


.. index::
   Backend user; getPagePermsClause
.. _be-user-pageperms:

Selecting readable pages from database?
=======================================

If you wish to make a SQL statement which selects pages from the
database and you want it to be only pages that the user has read
access to, you can have a proper WHERE clause returned by this
function call:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $GLOBALS['BE_USER']->getPagePermsClause(1);

Again the number "1" represents the "read" permission; "2" is "edit"
and "4" is "delete" permission. The result from the above query could be this string:

.. code-block:: none
   :caption: Result of the above query

   ((pages.perms_everybody & 1 = 1)OR(pages.perms_userid = 2 AND pages.perms_user & 1 = 1)OR(pages.perms_groupid in (1) AND pages.perms_group & 1 = 1))


.. index:: Backend user; getModuleData
.. _be-user-module-save:

Saving module data
==================

This stores the input variable :php:`$compareFlags` (an array!, retrieved from
the :ref:`request object <typo3-request>`) with the key
"tools\_beuser/index.php/compare":

..  code-block:: php
    :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

    $compareFlags = $request->getParsedBody()['compareFlags'])
        ?? $request->getQueryParams()['compareFlags'])
        ?? null;
    $GLOBALS['BE_USER']->pushModuleData('tools_beuser/index.php/compare', $compareFlags);


.. index:: Backend user; pushModuleData
.. _be-user-module-get:

Getting module data
===================

This gets the module data with the key
"tools\_beuser/index.php/compare" (lasting only for the session) :

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $compareFlags = $GLOBALS['BE_USER']->getModuleData('tools_beuser/index.php/compare', 'ses');


.. index::
   Backend user; getTSConfig
   Backend user; TSConfig
.. _be-user-tsconfig:

Getting TSconfig
================

This function can return a value from the "user TSconfig" structure of
the user. In this case the value for "options.clipboardNumberPads":

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $tsconfig = $GLOBALS['BE_USER']->getTSConfig();
   $clipboardNumberPads = $tsconfig['options.']['clipboardNumberPads'] ?? '';


.. index:: Backend user; User record
.. _be-user-name:

Getting the Username
====================

The full "be\_users" record of a authenticated user is available in
:php:`$GLOBALS['BE_USER']`->user as an array. This will return the "username":

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $GLOBALS['BE_USER']->user['username']


.. _be-user-configuration:

Get User Configuration Value
============================

The internal :php:`->uc` array contains options which are managed by the
User Tools > :guilabel:`User Settings` module (extension "setup"). These values are accessible in
the :php:`$GLOBALS['BE_USER']->uc` array. This will return the current state of
"Notify me by email, when somebody logs in from my account" for the user:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeModuleController.php

   $GLOBALS['BE_USER']->uc['emailMeAtLogin']
