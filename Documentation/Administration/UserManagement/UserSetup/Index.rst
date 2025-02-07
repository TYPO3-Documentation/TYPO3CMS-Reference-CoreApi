..  include:: /Includes.rst.txt

..  _setup-user:
..  _creating-a-new-user-for-the-introduction-site:

=================
Setting up a User
=================

To explore the last details of setting up a backend user
- and as an exercise - this chapter will guide you
through the process of creating a new user. To make it more
interesting, we will also create a new user group.

..  contents:: Table of contents

..  _step-create-a-new-group:

Step 1: Create a New Group
==========================

If you have access to the console there is a quick console command which
creates basic user groups for you. You can adjust them to your needs:

..  tabs::

    ..  group-tab:: DDEV

        ..  code-block:: bash

            ddev typo3 setup:begroups:default -g Both

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 setup:begroups:default -g Both

    ..  group-tab:: Classic

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 setup:begroups:default -g Both

If you did not auto-create the user groups, create one in the backend module
:guilabel:`System > Backend Users`. Use the dropdown in the module header
to switch to the "Backend User Groups" submodule.

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserGroupsModule.png
    :alt: Screenshot of the Module "Backend Users", submodule "Backend User Groups" in the TYPO3 Backend

    Click the button "+ Create a new backend user group" if you want to create a new group. Or edit one of those created by the command.

Start by entering the name for the new group, optionally inherit from group
"Editors".

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserGroupsTabGeneral.png
    :alt: Tab General with the backend user group title and Group inheritance

    Enter a name for the group

Let us keep things simple for the further permissions.

Go to tab **Module Permissions**:

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserGroupsTabModule.png
    :alt: Tab "Module Permissions" with the list of allowed modules

    For **Allowed Modules** choose "Web > Page" and "Web > View"

Then to tab **Record Permissions**:

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserGroupsTablePermission.png
    :alt: Tab "Record Permissions", field "Table Permissions" with option Read & Write chosen for tables Page and Page Content

    Choose **Table Permissions** choose "Read & Write" for tables Page and Page content

On the same tab in field "Allowed page types" Choose "Standard".

Move to the "Mounts and workspaces" tab.

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserGroupsTabMounts.png
    :alt: Tab "Mounts and workspaces" in the backend user group edit form.

    Select the "Startpage" page as DB mount (starting point for the page tree).

Then save the user group by clicking the "Save" button in the module header.

..  _step-create-the-user:

Step 2: Create the User
=======================

You can quickly create a backend user using a TYPO3 console command and following
the prompt:

..  tabs::

    ..  group-tab:: DDEV

        ..  code-block:: bash

            ddev typo3 typo3 backend:user:create

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 typo3 backend:user:create

    ..  group-tab:: Classic

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 typo3 backend:user:create

If you prefere to use the TYPO3 backend, in the backend module
:guilabel:`System > Backend Users` use the drop down in
module header to switch back to the "Backend Users" submodule. You have a
button to create a new backend user there.

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserCreate.png
    :alt: The main submodule Backend users of the backend user module

    Click the button "Create new backend user"


Enter the username, password, group membership:

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserCreateTabGeneral.png
   :alt: Setting the base information for the new user


..  note::
    If we were creating a new administrator, we would just need
    to check the "Admin (!)" box. Admin users don't need to belong
    to any group, although this can still be useful to share
    special settings among administrators.

Save and close the record. We will check the result of our work
by using the simulate user feature we saw earlier.

..  figure:: /Images/ManualScreenshots/UserManagement/SimulateEditor.png
   :alt: A backend user in the backend user module with their action buttons.

    Click the switch to user button

If you used the default "Editors" group you should see this:

..  figure:: /Images/ManualScreenshots/UserManagement/SwitchUserMode.png
    :alt: The TYPO3 backend viewed by a standard editor

    Use the User menu on the top right to find the "Exit switch user mode" button and switch back to your admin world.
