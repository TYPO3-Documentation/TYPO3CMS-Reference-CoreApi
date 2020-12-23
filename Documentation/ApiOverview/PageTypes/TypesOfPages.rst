.. include:: /Includes.rst.txt
.. index:: Page types; Doktypes
.. _list-of-page-types:

==============
Types of pages
==============

`TYPO3`:pn: has predefined a number of pages types as constants in
:file:`typo3/sysext/core/Classes/Domain/Repository/PageRepository.php`.

What role each page type plays and when to use it is explained in more
detail in :ref:`t3editors:pages-types`. Some of the page types require
additional fields in pages to be filled out:


.. index:: Page types; DOKTYPE_DEFAULT

`DOKTYPE_DEFAULT` - ID: `1`
   Standard

.. index:: Page types; DOKTYPE_LINK

`DOKTYPE_LINK` - ID: `3`
   Link to External URL

   This type of page creates a redirect to an URL in the frontend.
   The URL is specified in the field `pages.url`.

.. index:: Page types; DOKTYPE_SHORTCUT

`DOKTYPE_SHORTCUT` - ID: `4`
   Shortcut

   This type of page creates a redirect to another page in the frontend.
   The shortcut target is specified in the field `pages.shortcut`,
   shortcut mode is stored in `pages.shortcut_mode`.

.. index:: Page types; DOKTYPE_BE_USER_SECTION

`DOKTYPE_BE_USER_SECTION` - ID: `6`
   Backend user Section

.. index:: Page types; DOKTYPE_MOUNTPOINT

`DOKTYPE_MOUNTPOINT` - ID: `7`
   Mount point

   The mounted page is specified in `pages.mount_pid`,
   while display options can be changed with `pages.mount_pid_ol`.
   See :ref:`MountPoints documentation <MountPoints>`.

.. index:: Page types; DOKTYPE_SPACER

`DOKTYPE_SPACER` - ID: `199`
   Menu separator

.. index:: Page types; DOKTYPE_SYSFOLDER

`DOKTYPE_SYSFOLDER` - ID: `254`
   Folder

.. index:: Page types; DOKTYPE_RECYCLER

`DOKTYPE_RECYCLER` - ID: `255`
   Recycler


