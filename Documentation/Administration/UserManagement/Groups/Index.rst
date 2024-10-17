:navigation-title: Groups

..  include:: /Includes.rst.txt

..  _groups:

===================
Backend user groups
===================

While it is possible to change permissions on a per user basis,
it is strongly recommended you use Groups instead. Just as for users,
there are "Backend user groups" and "Frontend user groups".

This chapter provides a quick overview of backend user groups.
In the next chapter we will look at changing user permissions using
groups.

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

Using the "Backend Users" module
================================

Backend groups can also be viewed using :guilabel:`SYSTEM > Backend users`
module:

..  figure:: /Images/ManualScreenshots/UserManagement/BackendBackendUserGroups.png
    :alt: Viewing groups in the Backend Users module

We can see two groups that correspond to our users
("simple" and "advanced").

To find out what group each user is a member of, select the
"information" action icon. A pop-up will open with detailed
information about the group. Scroll down until you find the
"References to this item:" section. This shows the list of backend
users who are part of this group.

..  figure:: /Images/ManualScreenshots/UserManagement/BackendBackendUserGroupDetail.png
    :alt: Checking out which users are part of the group
