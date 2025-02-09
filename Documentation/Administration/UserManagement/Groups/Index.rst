:navigation-title: Groups

..  include:: /Includes.rst.txt

..  _groups:

===================
Backend user groups
===================

While it is possible to change permissions on a user basis,
it is strongly recommended you use Groups instead. Just like users,
there are "Backend user groups" and "Frontend user groups".

See chapter `Setting up User Permissions <https://docs.typo3.org/permalink/t3coreapi:setting-up-user-permissions>`_
for fine tuning of user group permissions.

..  contents:: Table of contents

..  toctree::
    :caption: Subpages
    :glob:
    :titlesonly:

    *

..  _groups-console:

Console command to create backend user groups from presets
==========================================================

..  versionadded:: 13.2
    With the introduction of backend user presets it is now possible to
    create basic user groups via command.

You can use the :bash:`vendor/bin/typo3 setup:begroups:default` to create
pre-configured backend user groups without touching the TYPO3 backend.

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 setup:begroups:default

    ..   group-tab:: Legacy installation

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 setup:begroups:default

An interactive dialog will then ask which groups should be created. It is also
possible to specify the groups:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/typo3 setup:begroups:default --groups Both
            vendor/typo3 setup:begroups:default --groups Editor
            vendor/typo3 setup:begroups:default --groups "Advanced Editor"

    ..  group-tab:: Legacy installation

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 setup:begroups:default --groups Both
            typo3/sysext/core/bin/typo3 setup:begroups:default --groups Editor
            typo3/sysext/core/bin/typo3 setup:begroups:default --groups "Advanced Editor"

..  note::

    The command does not support the creation of backend user
    groups with custom names or permissions (they can be modified later through
    the backend module). It is limited to creating two pre-configured backend
    user groups with permission presets applied.

..  _groups-module:
..  _step-create-a-new-group:

Using the "Backend Users" module
================================

If you have not auto-created the user groups, create one in the backend module
:guilabel:`System > Backend Users`. Use the dropdown in the module header
to switch to the "Backend User Groups" submodule.

..  figure:: /Images/ManualScreenshots/UserManagement/Module/BackendUserGroupsModule.png
    :alt: Screenshot of the Module "Backend Users", submodule "Backend User Groups" in the TYPO3 Backend

    Click the button "+ Create a new backend user group" if you want to create a new group. Or edit one of those created by the command.

Start by entering the name for the new group. Optionally, inherit from group
"Editors".

..  figure:: /Images/ManualScreenshots/UserManagement/Groups/TabGeneral.png
    :alt: Tab General with the backend user group title and Group inheritance

    Enter a name for the group

Let us keep things simple for the further permissions.

Go to tab **Module Permissions**:

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserGroupsTabModule.png
    :alt: Tab "Module Permissions" with the list of allowed modules

    For **Allowed Modules** choose "Web > Page" and "Web > View"

Then move to tab **Record Permissions**:

..  figure:: /Images/ManualScreenshots/UserManagement/Groups/TablePermission.png
    :alt: Tab "Record Permissions", field "Table Permissions" with option Read & Write chosen for tables Page and Page Content

    Choose **Table Permissions** choose "Read & Write" for tables Page and Page content

On the same tab in field "Allowed page types" choose "Standard".

Move to the "Mounts and workspaces" tab.

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserGroupsTabMounts.png
    :alt: Tab "Mounts and workspaces" in the backend user group edit form.

    Select the "Startpage" page as DB mount (starting point for the page tree).

Then save the user group by clicking the "Save" button in the module header.
