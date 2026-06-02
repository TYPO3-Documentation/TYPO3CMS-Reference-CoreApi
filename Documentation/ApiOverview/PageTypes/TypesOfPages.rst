..  include:: /Includes.rst.txt
..  index:: Page types; Doktypes
..  _list-of-page-types:

==============
Types of pages
==============

TYPO3 has predefined a number of pages types as constants in
:file:`typo3/sysext/core/Classes/Domain/Repository/PageRepository.php`.

What role each page type plays and when to use it is explained in more
detail in :ref:`t3editors:pages-types`. Some of the page types require
additional fields in pages to be filled out:

..  index:: Page types; DOKTYPE_DEFAULT
..  _list-of-page-types-default:

`DOKTYPE_DEFAULT` - ID: `1`
   Standard

..  index:: Page types; DOKTYPE_LINK
..  _list-of-page-types-link:

`DOKTYPE_LINK` - ID: `3`
   Link to External URL

   This type of page creates a redirect to an URL in the frontend.
   The URL is specified in the field `pages.url`.

..  index:: Page types; DOKTYPE_SHORTCUT
..  _list-of-page-types-shortcut:

`DOKTYPE_SHORTCUT` - ID: `4`
   Shortcut

   This type of page creates a redirect to another page in the frontend.
   The shortcut target is specified in the field `pages.shortcut`,
   shortcut mode is stored in `pages.shortcut_mode`.

..  index:: Page types; DOKTYPE_BE_USER_SECTION
..  _list-of-page-types-be-user-section:

`DOKTYPE_BE_USER_SECTION` - ID: `6`
   Backend user Section

..  index:: Page types; DOKTYPE_MOUNTPOINT
..  _list-of-page-types-mountpoint:

`DOKTYPE_MOUNTPOINT` - ID: `7`
   Mount point

   The mounted page is specified in `pages.mount_pid`,
   while display options can be changed with `pages.mount_pid_ol`.
   See :ref:`MountPoints documentation <MountPoints>`.

..  index:: Page types; DOKTYPE_SPACER
..  _list-of-page-types-spacer:

`DOKTYPE_SPACER` - ID: `199`
   Menu separator

..  index:: Page types; DOKTYPE_SYSFOLDER
..  _list-of-page-types-sysfolder:

`DOKTYPE_SYSFOLDER` - ID: `254`
   Folder

   A folder is a place where records from various database tables can be stored.
   Some records may only be created in folders and are not available on standard pages.

   It can also be used to group standard pages so they can be displayed in a custom menu.

.. versionchanged:: 13.0

   The recycler doktype (`DOKTYPE_RECYCLER` - ID: `255`) is removed and cannot be selected or used anymore. Any
   existing recycler pages are migrated to a page of type "Backend User Section"
   which is also not accessible if there is no valid backend user with permission
   to see this page.
