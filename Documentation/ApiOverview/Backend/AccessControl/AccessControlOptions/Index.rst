:navigation-title: Options


.. include:: /Includes.rst.txt


.. _access-options:

======================
Access Control Options
======================

The permissions of fully initialized backend users are the result of the
rights granted in their own user records and all the user groups they
belong to.

The permissions are divided into the following conceptual categories:

Access lists
   These grant access to backend modules, database tables and fields.

Mounts
   Parts of the page tree and server file system.

Page permissions
   Access to work on individual pages based on the user id and group ids.

User TSconfig
   A flexible and hierarchical configuration structure
   defined by TypoScript syntax. This typically describes "soft"
   permission settings and options for the user or group which can be used to
   customize the backend and individual modules.

   All user TSconfig options are described in the
   :ref:`TSconfig Reference <t3tsref:usertsconfig>`


.. _access-options-access-lists:

Access Lists
============

Access lists are defined at group-level. Usage of access lists for defining
user rights is described in chapter :ref:`setting-up-user-permissions`.
The various access lists are described here for reference, with
additional technical details, where necessary.

.. note::

   Access list don't apply to admin users. As mentioned before, admin
   users have access to every single feature of the TYPO3 CMS backend.

Modules
   This is a list of submodules a user may be given access to. Access to a main
   module is implicit, as soon as a user has access to at least one of its
   submodules.

   Not all submodules appear in this list. It is possible to restrict a
   submodule to admin users only. This is the case, in particular, for all
   :guilabel:`Admin Tools` and :guilabel:`System` modules, as well as the
   :guilabel:`Web > Template` module.

   .. note::

      This is the only access list that is also available for definition
      at user-level.

Dashboard widgets
   A :ref:`list of the available dashboard widgets <ext_dashboard:permission-handling-of-widgets>`
   a user may be allowed to use on the dashboard.

   .. note::

      This section is only available with activated
      :doc:`dashboard <ext_dashboard:Index>` system extension.

Tables for listing
   A list of all tables a user may be allowed to read in the backend.
   Again this in not a list of all tables in the database. Some tables
   are low level and never appear in the backend at all, even for admin
   users. Other tables are restricted to admin users and thus do not show
   up in the access list.

   Restricting a table to admin users only is done using the
   :ref:`TCA property "adminOnly" <t3tca:ctrl-reference-adminonly>`.

   .. note::

      All tables that are allowed for modification (see below) are
      also allowed for read access, so no need to select them in this
      list as well.

Tables for editing
   This is exactly the same list of tables as before, but for granting
   modification rights.

Page types
   TYPO3 CMS defines a number of page types. A user can be restricted
   to access only some of them.

   For a full discussion on page types, please refer to the
   :ref:`page types chapter <page-types>`.

Excludefields
   When defining column tables in TCA, it is possible to set the
   :ref:`"exclude" property <t3tca:columns-properties-exclude>` to "1".
   This ensures that the field is hidden to users by default.
   Access to it must be explicitly granted in this access list.

Explicitly allow/deny field values
   When a field offers a list of options to select from, it is possible
   to tell TYPO3 CMS that access to these options is restricted and should
   be granted explicitly. Such fields and their values appear here.

   The related TCA property is :ref:`"authMode" <t3tca:columns-select-properties-authmode>`.

Limit to languages
   By default users can edit records regardless of what language they are assigned to.
   Using this list it is possible to restrict users to working only in selected
   languages.

When a user is a member of more than one group, the access lists for
the groups are "added" together.


.. _access-options-mounts:

Mounts
======

TYPO3 CMS natively supports two kinds of hierarchical tree structures:
the page tree (typically visible in the :guilabel:`Web` module) and the folder
tree (typically visible in the :guilabel:`File` module). Each tree is
generated based on the *mount points* configured for the current user. So a
page tree is drawn from the *DB Mounts* which are one or more page ids
telling the Core from which "start page" to draw the tree(s). Likewise
is the folder tree drawn based on *filemounts* configured for the user.

**DB mounts** (page mounts) are set by pointing out the
page that should be mounted for the user (at user or group-level):

.. include:: /Images/AutomaticScreenshots/AccessControl/DbMounts.rst.txt

This is what the user will see:

.. figure:: /Images/ManualScreenshots/AccessControl/AccessUserPageTree.png
   :alt: Only selected pages are accessible to the user


.. warning::

   A DB mount will appear only if the :ref:`page permissions <access-options-page-permissions>`
   allow the user at least read access to the mounted page (and subpages).
   Otherwise nothing will appear at all!

**File Mounts** are a little more difficult to set up, as they
involve several steps. First of all, you need to have at least
one :ref:`File Storage <fal-concepts-storages-drivers>`. By
default, you will always have one, pointing
to the :file:`fileadmin` directory. It is created by TYPO3 CMS
upon installation.

.. note::

   The :file:`fileadmin` directory is the default place where
   TYPO3 CMS expects media resources to be located. It can be
   changed using the global configuration option
   :code:`$GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir']`.

.. include:: /Images/AutomaticScreenshots/AccessControl/FileStorage.rst.txt


A *File Storage* is essentially defined by a *File Driver*
and the path to which it points.

Next we can create a *File Mount* record (on the root page),
which refers to a File Storage:

.. include:: /Images/AutomaticScreenshots/AccessControl/CreateFilemount.rst.txt


When defining a File Mount, you can point to a specific folder
within the chosen File Storage. Finally the mount is assigned
to a user or group:

.. include:: /Images/AutomaticScreenshots/AccessControl/AssignFilemount.rst.txt


After a successful configuration, the file mount will appear to
the user:

.. figure:: /Images/ManualScreenshots/AccessControl/AccessUserFileTree.png
   :alt: The file tree as visible by the user


DB and File Mounts can be set for both the user and group records.
Having more than one DB or File Mount will just result in more than
one mount point appearing in the trees. However the backend users
records have two flags which determine whether the DB/File Mounts of
*the groups* the user belongs to will be mounted as well! This is
the default behaviour. So make sure to unset these flags if users
should see only their "private" mount points and not those from their
groups:

.. include:: /Images/AutomaticScreenshots/AccessControl/MountFromGroups.rst.txt


"Admin" users do not need mount points. As always, they have access
to every part of the installation.


.. _access-options-page-permissions:

Page Permissions
----------------

Page permissions are designed to work like file permissions on UNIX
systems. Each page record has an owner user and group and
permission settings for the owner, the group and "everybody". This is
summarized here:

- Every page has an owner, group and everybody-permission

- The owner and group of a page can be empty. Nothing matches with an
  empty user/group (except "admin" users).

- Every page has permissions for owner, group and everybody in these
  five categories (next to the label is the corresponding value):

  Show (1)
    See/Copy page and the page content.

  Edit page content (16)
    Change/Add/Delete/Move page content.

  Edit page (2)
    Change/Move the page, eg. change title, startdate, hidden flag.

  Delete page (4)
    Delete the page and page content.

  New pages (8)
    Create new pages under the page.

.. note::

   Here "Page content" means all records related to that page,
   except other pages.

Page permissions are set and viewed with the module :guilabel:`System > Access`
module:

.. include:: /Images/AutomaticScreenshots/AccessControl/AccessModule.rst.txt


Editing permissions is described in details in chapter
:ref:`page-permissions`.

A user must be "admin" *or* the owner of a page in order to edit its
permissions.

When a user creates new pages in TYPO3 CMS they will by default get the
creating user as owner. The owner group will be set to the *first
listed user group* configured for the users record (if any). These defaults
can be changed through :ref:`page TSconfig <t3tsref:pagetcemain-permissions-user-group>`.


.. _access-options-user-tsconfig:

User TSconfig
=============

User TSconfig is a hierarchical configuration structure entered in
plain text TypoScript. It can be used by all kinds of applications
inside of TYPO3 CMS to retrieve customized settings for users which
relates to a certain module or part. The options available are
described in the :ref:`document TSconfig <t3tsref:usertsconfig>` .
