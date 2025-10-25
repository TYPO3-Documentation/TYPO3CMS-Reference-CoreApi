:navigation-title: Permission details

..  include:: /Includes.rst.txt
..  _permissions:
..  _setting-up-user-permissions:

=================================
Setting up user group permissions
=================================

We will look into managing user permissions by editing the
"Advanced editors" user group.

..  figure:: /Images/ManualScreenshots/UserManagement/Module/BackendUserGroupsModule.png
    :alt: Screenshot of the Module "Backend Users", submodule "Backend User Groups" in the TYPO3 Backend

..  contents:: Table of contents

..  _general:

"General" tab - backend user groups
===================================

On the "General" tab you can edit the group's title and write a
short description. As mentioned before, permissions from sub-groups
will be inherited by the current group.

..  figure:: /Images/ManualScreenshots/UserManagement/Groups/TabGeneral.png
    :alt: Tab General with the backend user group title and Group inheritance

    Content of the "General" tab when editing a backend user group

..  note::
    Setting permissions is not just about access rights.

    It can also help to declutter the backend, ensuring that
    backend users only see and have access to the modules they require.

..  _backend-group-inheritance:

Inherit settings from groups" section of tab "General" in backend user groups
-----------------------------------------------------------------------------

If you chose groups in the "Inherit settings from groups" section of tab
"General", the current group inherits all the permissions of the parent group and
can add additional permissions. It is not possible to revoke permissions granted
by the parent group.

User TSconfig of the parent group gets overridden by TSconfig of the child group
and then, in turn, by the specific TSconfig of the backend user.
See also `Setting user TSconfig <https://docs.typo3.org/permalink/t3tsref:setting-user-tsconfig>`_.

..  _access-lists:
..  _include-access-lists:

"Record Permissions" tab - backend user groups
==============================================

..  _access-lists-page-types:

"Allowed page types" section in Record permissions of user group
----------------------------------------------------------------

You should allow at least the "Standard" page type if you want your
editors to be able to create new pages.

See also :ref:`Editors Guide, page types <t3editors:pages-types>`.

..  _access-lists-tables:

"Table permissions" section in Record permissions of user group
---------------------------------------------------------------

This section allows you to grant "read" or "read and write" permissions for
different database tables.

If your user should be able to upload and reference images, for example
use the content element "Text & Images", it is important that they also be able to
read and write the tables "File Reference" and "File" beside also having
permissions to actually write saved files.

..  figure:: /Images/ManualScreenshots/UserManagement/Groups/TablePermission.png
    :alt: Screenshot of Tab "Record Permissions", field "Table Permissions" in a user group record

..  _access-lists-allowed-excludefields:

"Allowed fields" section in Record permissions of user group
------------------------------------------------------------

When defining table fields in TYPO3, you can mark them as
:ref:`excluded <t3tca:confval-columns-exclude>` in TCA. Such fields are hidden
from backend users (except administrators) unless they are explicitly granted
access. This field manages that access by displaying a list of all tables and
their excluded fields.

..  figure:: /Images/ManualScreenshots/UserManagement/Groups/AllowedFields.png
    :alt: Section "Allowed fields" in tab "Record permissions" of the user group record

    Click on a table name and select allowed fields

..  tip::
    You can hide fields from a backend group by setting page TSconfig option
    :ref:`disabled <t3tsref:confval-tceform-disabled>`.

..  _access-lists-explicitly-allow-deny-field-values:

"Explicitly allow field values" section in Record permissions of user group
---------------------------------------------------------------------------

By default you can choose which content element types are allowed for a backend
group in this section. Some extensions might add additional tables and their values
here.

A content element type not checked in this section cannot be added or edited by
a user of this group.

..  figure:: /Images/ManualScreenshots/UserManagement/Groups/AllowedFields.png
    :alt: Section "Explicitly allow field values" in tab "Record permissions" of the user group record

..  tip::
    You can remove options from select fields with page TSconfig option
    :ref:`removeItems <t3tsref:confval-tceform-removeitems>` (blacklist) or
    :ref:`keepItems <t3tsref:confval-tceform-keepitems>` (whitelist).

..  _access-lists-language-limit:

"Limit to languages" section in Record permissions of user group
----------------------------------------------------------------

In a multilingual web site, it is also possible to restrict users
to a specific language or set of languages.

..  figure:: /Images/ManualScreenshots/UserManagement/Groups/LimitLanguages.png
    :alt: Section "Limit to languages" in tab "Record permissions" of the user group record

..  _access-lists-modules:

"Module Permissions" tab - backend user groups
==============================================

The section "Allowed modules" grants access to different backend modules.

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserGroupsTabModule.png
    :alt: Tab "Module Permissions" with the list of allowed modules

If you allow the module "Dashboard" you should also explicitly choose
"Allowed dashboard widgets" in the next section.

:abbr:`MFA (Multi-factor authentication)` is only possible if you allow at least
one provider in section "Allowed multi-factor authentication providers".

..  _access-lists-mounts:

"Mounts and Workspaces" tab - backend user groups
=================================================

The next tab contains very important fields which define
which parts of the page tree and the file system the members of
the group may have rights over.

We will cover only mounts here. Detailed information about
workspaces can be found in chapter
`Users and groups for workspaces <https://docs.typo3.org/permalink/typo3/cms-workspaces:custom-workspace-users>`_

..  _db-mounts:
..  _access-lists-db-mounts:

"DB Mounts" in tab "Mounts and Workspaces"
------------------------------------------

Unless at least one :abbr:`DB mount (database mounts)` is chosen your user
does not have rights to any page record and will not be able to do anything in
the backend.

Each mount corresponds to a page in the tree. The user will have access only
to those pages and their sub-pages.

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserGroupsTabMounts.png
    :alt: Tab "Mounts and workspaces" in the backend user group edit form.

..  warning::
    A user is only able to make changes to a page if they have rights to the db mount of that
    page and at least "Show page" permissions for that page:
    `See chapter page permissions <https://docs.typo3.org/permalink/t3coreapi:page-permissions>`_

You can grant additional entry pages in the database record of the backend user.
If option "Mount from groups" is not set for "DB Mounts" you can even override
all db mounts.

..  _access-lists-file-mounts:

"File Mounts" in tab "Mounts and Workspaces"
--------------------------------------------

File mounts are similar to DB mounts but instead are used to manage access to
files.

File mounts need to be created first, for example using the context menu on the
file tree in module :guilabel:`Media > Filelist`, or in the
`File mounts submodule of the Backend Users module <https://docs.typo3.org/permalink/t3coreapi:user-management-backend-users-file-mounts>`_

They can then be selected when editing a backend user group:

..  figure:: /Images/ManualScreenshots/UserManagement/Groups/FileMounts.png
    :alt: Section "File Mounts" in tab "Mounts and Workspaces" in the backend user group edit form.

    Select the File mount by clicking on the right and adding them to the left.

..  warning::
    Adding a file mount is not sufficient for your editors to upload and
    use files. Due to the :ref:`File Abstraction Layer <t3coreapi:fal>` users
    also need permissions to read and write tables "Files" and "File references".
    Set those in the
    `"Table permissions" section in Record permissions of user group <https://docs.typo3.org/permalink/t3coreapi:access-lists-tables>`_.

    It is also necessary to grant Directory and File operation permissions in
    section `File operation Permissions <https://docs.typo3.org/permalink/t3coreapi:access-lists-file-permissions>`_.

Just like DB mounts, you can grant additional file mounts in the database record
of the backend user. If option "Mount from groups" is not set for "File Mounts"
you can even override all file mounts.

..  _access-lists-file-permissions:

"File operation permissions" in tab "Mounts and Workspaces"
----------------------------------------------------------

Specific operations on files and directories must be allowed.
Choose either "Directory" or "Files" and start checking boxes.

..  _access-lists-category-permissions:

Category mounts
---------------

It is possible to limit the categories that a user can attach to a database
record by choosing the allowed categories in the field
"Category mount". If no category is selected in the category mount,
all categories are available.

..  tip::
    If you want to disallow categories, remove the read and write
    permissions for table categories in the
    `"Table permissions" section in tab "Record permissions" <https://docs.typo3.org/permalink/t3coreapi:access-lists-tables>`_.
