..  include:: /Includes.rst.txt

..  _backendusers:
..  _creating-a-new-user-for-the-introduction-site:

====================
Adding backend users
====================

If you do not yet have backend user groups set up, go to chapter
`Backend user groups <https://docs.typo3.org/permalink/t3coreapi:groups>`_.

If you need to create an administrator or system maintainer, go to chapter
`Backend Privileges <https://docs.typo3.org/permalink/t3coreapi:privileges>`_.

..  contents:: Table of contents

..  _user-management-create-default-editors:
..  _setup-user:

Create a new backend user via console command
=============================================

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

..  _step-create-the-user:

Create a backend user in the TYPO3 backend
==========================================

If you prefere to use the TYPO3 backend, in the backend module
:guilabel:`System > Backend Users` use the drop down in
module header to switch back to the "Backend Users" submodule. You have a
button to create a new backend user there.

..  figure:: /Images/ManualScreenshots/UserManagement/BackendUserCreate.png
    :alt: The main submodule Backend users of the backend user module

    Click the button "Create new backend user"

Enter the username, password, group membership:

..  figure:: /Images/ManualScreenshots/UserManagement/Users/TabGeneral.png
    :alt: Setting the base information for the new user

..  note::
    If we were creating a new administrator, we would just need
    to check the "Admin (!)" box. Admin users don't need to belong
    to any group, although this can still be useful to share
    special settings among administrators.

.. _user-management-advanced-editor:
.. _user-management-simple-editor:
.. _simulate-user:

Simulate User
=============

Save and close the record. We will check the result of our work
by using the simulate user feature we saw earlier.

..  figure:: /Images/ManualScreenshots/UserManagement/SimulateEditor.png
    :alt: A backend user in the backend user module with their action buttons.

    Click the switch to user button

If you used the default "Editors" group you should see this:

..  figure:: /Images/ManualScreenshots/UserManagement/SwitchUserMode.png
    :alt: The TYPO3 backend viewed by a standard editor

    Use the User menu on the top right to find the "Exit switch user mode" button and switch back to your admin world.
