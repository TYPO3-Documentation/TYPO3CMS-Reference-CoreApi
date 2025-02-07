..  include:: /Includes.rst.txt

..  _page-permissions:

================
Page permissions
================

..  versionchanged:: 13.2
    The module to handle page permissions has been renamed from
    :guilabel:`Access` to :guilabel:`Permissions`.

:ref:`DB mounts <db-mounts>` are not the whole story about access to pages.
Users and groups also need to have rights to perform operations on the
pages like viewing, editing or deleting.

This is managed using the :guilabel:`System > Permissions` module:

..  figure:: /Images/ManualScreenshots/UserManagement/PermissionsModule.png
    :alt: TYPO3 Backend module called Permissions showing an overview of page owners and permissions

    The "Permissions" module with ownerships and permissions

Every page has an owner, who is a user, and also a group
membership. Rights can be assigned to the owner, to the group
or to everyone. This will be familiar to Unix users.

To change the permissions, click on the edit button.

..  figure:: /Images/ManualScreenshots/UserManagement/PermissionsModuleChangeGroup.png
    :alt: Changing a pages user group

It is also possible to change owner, group and permissions
recursively, even for the whole page tree. Use the dropdown to select the depth.

..  figure:: /Images/ManualScreenshots/UserManagement/PermissionsModuleChangeGroupDepth.png
    :alt: Preparing for recursively changing the group on the whole page tree

By choosing group "Editors" as group and then "Set recursively 2 levels"
in the "Depth" dropdown, we will assign **all** the pages in the
page tree to the "Editors" group.
