.. include:: /Includes.rst.txt

.. index:: backend, acl, permissions, user groups, user management

.. _setting-up-backend-user-groups:

==============================
Setting up backend user groups
==============================

Backend user groups can be categorized into three main types. Those used to
grant permissions to pages and define mounts for databases, categories,
or files we can refer to as **System Groups**. The ones responsible for granting
access to modules, various content elements, record types, and specific fields
within forms can be termed **Access Control List (ACL) Groups**. Finally,
we have **Role Groups**, which aggregate groups from both the System and ACL Groups
to provide a permissions set representing a specific role.

This classification should not be seen as a TYPO3 standard, but rather as a guideline
that will assist in configuring groups later on. Read more to discover the details.

.. _system-groups:

System groups
=============

System groups have the lowest level of permissions without which other groups
like :ref:`Access Control List (ACL) <_acl-groups>` and :ref:`Role <_role_groups>`
groups will not work. They enable access to individual pages based on user
and group IDs, allow definition of accessible sections of pages and categories
tree for users, and determine access to files and folders within storages (via File Mounts).
System groups are likely to be the ones you modify the least often.

.. note::
    System groups are likely to be the ones you modify the least often.

.. _acl-groups:

Access Control List (ACL) groups
================================

Access Control List (ACL) groups are the largest set of groups, used to
set detailed permissions for elements like modules, dashboard widgets, tables
for listing and editing, and specific fields in backend forms.

Ensure ACL groups grant essential permissions for specific elements management.
For example, users managing custom record types (e.g., Article, Product) should list,
create, and access records, possibly via a custom backend module or the :guilabel:`Content > Records` module.
It's crucial to equip such a group with access to:

* Listing and modifying the table of a records
* Editing fields within the record that align with this group's purpose
* Accessing the core :guilabel:`Content > Records` module or custom module for records management
* If there are relations from this record, for example, to files, it should also permit uploading, selecting, and processing these files

Therefore, a group can be seen as an independent unit that provides complete
access to a specific part of the system and can be integrated later with other units (groups).

.. note::
    An Access Control List (ACL) group can be seen as a standalone, complete set of
    permissions tailored to a specific element(s) and designed to fulfill its defined
    scope or purpose (editing/managing Articles or Products).

.. _role-groups:

Role groups as an aggregation of specific role permissions
=======================================================

Backend role groups in TYPO3 are designed to correspond to the specific roles
users fulfill, such as editor, proofreader, etc. These groups accumulate
permissions exclusively through the inheritance from subgroups.
This hierarchical setup ensures that role groups can effectively grant users
the precise set of permissions needed to perform their designated roles, such as editing.

By utilizing this structure, TYPO3 allows for a clear and organized approach
to managing access rights, ensuring users have the permissions they need,
nothing more, nothing less.

.. note::
    Role groups inherit permissions from subgroups and should not have any
    permissions configured directly on themselves.

.. _naming-convention:

Implementing naming conventions for easy group management
================================================================

TYPO3 currently lacks the feature to categorize backend user groups by context
or purpose, sorting them alphabetically instead. While helpful for quick searches,
this becomes cumbersome with many groups, when it is required to identify them
by their purpose or scope.

The situation could worsen with multiple administrators managing group and user
permissions. Without naming conventions for groups that all administrators adhere to,
it may become challenging to identify the responsibilities of each group.

As detailed in the :ref:`Access Control Options in TYPO3 <_available_acl_options>` chapter,
these options can be categorized into types like access lists, mounts, page permissions,
etc. This categorization can also aid in organizing backend user groups.
Let’s explore how implementing prefixes in group names can help streamline their organization.

.. _role-group::

Role Group
----------

**ROLE_** or **R_**
    Examples: *R_editor*, *R_editor_advanced*, *R_proofreader*

    A group representing a specific role, such as editor or proofreader, will
    inherit permissions from multiple other groups (aggregates them) to compile
    the necessary permissions set.

.. _page-group:

Page Group
----------

**PAGE_GROUP_** or **PG_**
    Examples: *PG_website_a*, *PG_website_a_blog*, *PG_website_b*, *PG_website_b_gallery*

    Grants permissions to all pages in the pages tree for a given site or only
    selected branches of pages in the tree.

    Those groups will be assigned directly to the pages (see Page Permissions
    for more details) following the TSConfig or the :guilabel:`Permissions` module configuration.

.. _database-mount:

Database Mount
--------------

**DATABASE_MOUNT_** or **DBM_**
    Examples: *DBM_website_a*, *DBM_website_a_blog*, *DBM_website_b*, *DBM_website_b_gallery*

    Specifies which portion (either the entirety or a segment) of the pages tree
    will be displayed to the user.

    This setting is closely linked to page access permissions — without sufficient
    permissions to list the pages, a user will not be able to view the mounted page tree.

.. _file-mount:

File Mount
----------

**FILE_MOUNT_** or **FM_**
    Examples: *FM_website_a*, *FM_website_a_blog*, *FM_website_b*, *FM_website_b_gallery*, *FM_shared*

   Grants access to the selected folders (File Mounts) within file storage.

.. _category-mount:

Category Mount
--------------

**CATEGORY_MOUNT_** or **CM_**
    Examples: *CM_website_a*, *CM_website_b*

    Provides access to system categories, or more precisely, to the entire categories tree or a portion of it.

.. _access-control-lists:

Access Control Lists
--------------------

**ACCESS_CONTROL** or **ACL_**
    Examples: *ACL_content_elements*, *ACL_news*, *ACL_news_extended*, *ACL_module_reports*

    These groups are the largest, defining granular
    access to content elements, plugins, modules, fields and more.

.. _file-operations:

File Operations
---------------

**FILE_OPERATION_** or **FO_**
    Examples: *FO_all*, *FO_read_write*

    Defines the range of allowed operations for files and folders, such as read, write, delete, etc.

.. _limit-to-languages:

Limit to languages
------------------

**LANGUAGE_** or **L_**
    Examples: *L_all*, *L_english_german*, *L_en_pl_de*

    Specifies the languages available for managing content. Keep in mind
    that you would have to have access to the source language when creating the translation.

This method guarantees dedicated group prefixes for Pages access, Database Mounts,
File Mounts, File Operations, Category Mounts, and module, table, widget,
and language access. These examples are customizable to fit specific needs.
Ensure each group name is straightforward and indicative of its permissions.

.. figure:: /Images/ManualScreenshots/PermissionsManagement/PermissionsManagementPrefixedGroupName.png
   :alt: Prefixed group names

   Prefixing group names makes them more organized and easier to search within forms

.. note::
    Use prefixes or another naming convention to easily
    distinguish backend user groups by their purpose.

.. _describe-naming-conventions-in-tca:

Describe the naming conventions in the TCA
==========================================

For those managing backend groups, if you've adopted naming conventions, consider
adding a field description in the TCA for be_groups, be_users, and related tables,
detailing these conventions instead of referencing separate documentation.
This ensures immediate visibility of the naming rules for anyone modifying group
inheritance or assignments.

.. code-block:: php
   :caption: Add description to a form field through TCA

   $GLOBALS['TCA']['be_users']['columns']['usergroup']['description'] =
    'Prefixes: R_ - Role, PG_ - Page Group, DBM_ - Database Mount, FM_ - File Mount,' .
    'FO_ - File Operations, CM_ - Category Mount, ACL_ - Access Control';

This code demonstrates the assignment of a static description for the usergroup
field in the backend user form. However, you should place it in a translation
file and retrieve it from there for better flexibility and localization support.

Use the Notes field to describe the purpose of the group
========================================================

Another good practice for managing backend groups is to clearly describe
the purpose or scope of each group. This can be done using the Description
field located within the Notes tab of the backend group form.

.. figure:: /Images/ManualScreenshots/PermissionsManagement/PermissionsManagementTCAFieldDescription.png
   :alt: TCA field description

   Describe the scope or purpose of the group
