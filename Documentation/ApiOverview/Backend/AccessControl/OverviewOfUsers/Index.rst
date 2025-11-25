.. include:: /Includes.rst.txt
.. index::
   Backend; Backend users module
   Module; Backend users
.. _access-backend-users-module:

====================
Backend users module
====================

The :guilabel:`Administration > Users` module offers a convenient way
of working with backend users and groups. It provides a list of both
users and groups. The users list can be searched and filtered.

..  versionchanged:: 14.0
    Until TYPO3 V14 this module was called :guilabel:`System > Backend Users`.
    See also: `Feature: #107628 - Improved backend module naming and structure <https://docs.typo3.org/permalink/changelog:feature-107628-1729026000>`_.

Comparing Users or Groups
=========================

The :guilabel:`Backend users` module offers the possibility to compare users.
Just add users using the
"+ Compare" button and then hit the "Compare user list" button.
For example, this is the comparison of the three different editors
provided by the Introduction Package:

.. include:: /Images/AutomaticScreenshots/AccessControl/CompareUsers.rst.txt

The same functionality is available for user groups, including a comparison
of their inherited permissions.

Impersonating Users ("Switch to")
=================================

We can impersonate (switch) to a user by clicking the :guilabel:`Switch to user`
action icon:

.. include:: /Images/AutomaticScreenshots/AccessControl/SimulateUserButton.rst.txt

You will then be logged in as that user (note how the user name
is prefixed with "SU" for "Simulated User"). To "switch back",
use the "Exit" button (which replaces the usual "Logout"
button).

.. include:: /Images/AutomaticScreenshots/AccessControl/SimulatedUser.rst.txt
