..  include:: /Includes.rst.txt

..  _user-management-backend-users:

====================
Backend Users module
====================

You can manage backend users using the :guilabel:`System > Backend users`
module.

..  figure:: /Images/ManualScreenshots/UserManagement/Module/ModuleBackendUsers.png
    :alt: Screenshots of the TYPO3 backend module Backend Users

    This module makes it possible to search and filter users. They
    can also be edited, deleted and disabled.

..  seealso::

    See section :ref:`privileges` for more information on
    special backend user roles "admin" and "system maintainers".

The backend module has the following submodules:

..  contents::

..  _user-management-backend-users-main:

Backend Users submodule
=======================

Will be shown by default unless you have chosen a different submodule from the
dropdown in the module header. You can
`Create new backend users <https://docs.typo3.org/permalink/t3coreapi:creating-a-new-user-for-the-introduction-site>`_
or `Administrators <https://docs.typo3.org/permalink/t3coreapi:admin-user>`_
here, enable and disable access for your users, reset password of non-admins, etc.

..  figure:: /Images/ManualScreenshots/UserManagement/Module/BackendUserActions.png
    Overview of buttons in the entry of a non-admin backend user

1.  Edit user settings.
2.  Disable or enable user.
3.  Delete user.
4.  Reset password - only available if the user has an email address in
    their settings. Will send an email to the user asking them to enter a new
    password.
5.  View user details, including a combined view of their permissions incorporating
    all their groups and settings in the user record. Overview of
    `User TSconfig reference <https://docs.typo3.org/permalink/t3tsref:usertoplevelobjects>`_
    that apply to this user.
6.  The general info module for the record of the backend user including
    references from other database records.
7.  Compare the permissions of two or more backend users by adding them to the
    compare list. You can then click the "Compare selected backend users"
    button.
8.  `Simulate the backend user <https://docs.typo3.org/permalink/t3coreapi:simulate-user>`_
    to try out the permissions.

..  _user-management-backend-user-groups:

Backend user groups submodule
=============================

..  figure:: /Images/ManualScreenshots/UserManagement/Module/BackendUserGroupsModule.png
    :alt: Screenshot of the Module "Backend Users", submodule "Backend User Groups" in the TYPO3 Backend

Gives you an overview of all backend user groups and allows you to edit, disable,
delete and compare permissions of groups.

..  _user-management-backend-users-online:

Online users submodule
======================

Shows you a list of all currently online users, including those who logged in
during the last two hours but never logged out.

..  _user-management-backend-users-file-mounts:

File mounts submodule
=====================

..  figure:: /Images/ManualScreenshots/UserManagement/Module/FileMounts.png
    :alt: Screenshot of the Module "Backend Users", submodule "File mounts" in the TYPO3 Backend

Allows you to view, edit, disable or delete file mounts.
