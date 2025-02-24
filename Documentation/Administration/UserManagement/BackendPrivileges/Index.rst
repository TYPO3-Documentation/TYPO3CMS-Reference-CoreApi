:navigation-title: Administrators

.. include:: /Includes.rst.txt

.. _privileges:

=========================================================
Backend privileges: Administrators and System Maintainers
=========================================================

The following chapters cover modules that will only be available for backend
users with specific access privileges.

In addition to configuring access
rights for backend users or groups as described in :ref:`permissions`, there
are "superuser" rights which can be activated for each user.

If a backend user has been created for editing in the backend, he or she should
usually not get access to admin or system modules.

You should only give a backend user
as much access as is needed. This makes the job easier by automatically deactivating
modules and GUI elements that the user does not have access to. It also makes it
impossible for a user to damage the system by accidentally doing things he or she
should not have been able to do in the first place.

.. _admin-user:

Administrators
==============

..  figure:: /Images/ManualScreenshots/UserManagement/Administrator.png
    :alt: Screenshot of the TYPO3 backend as seen by an Administrator. The Backend user module menu is opened.

    Administrators have access to the System modules, including Permissions, Backend User, Log etc.)

..  seealso::
    *   `Using the backend module "Backend Users" to create admins (Getting Started Tutorial) <https://docs.typo3.org/permalink/t3start:backend-users-admin-backend-module>`_
    *   `Create an administrator / System Maintainer using a console command (Getting Started Tutorial) <https://docs.typo3.org/permalink/t3start:backend-users-admin-cli>`_

.. _user-management-system-maintainers:
.. _system-maintainer:

System Maintainers
==================

The first backend admin created during installation will automatically be a system
maintainer as well. To give other users system privileges, you
can add them in the :guilabel:`ADMIN TOOLS > Settings > Manage System Maintainers`
configuration.
Alternatively, the website can be set to "Development" mode in the Install
Tool. This will give all admin users system maintainer access.

..  figure:: /Images/ManualScreenshots/UserManagement/SystemMaintainer.png
    :alt: Screenshot of the TYPO3 backend as seen by a System Maintainer. The Admin Tools module menu is opened.

    System Maintainers are the only users who are able to see and access
    :guilabel:`Admin Tools`, including the :guilabel:`Extension Manager`.

..  seealso::
    *   `Granting System Maintainer rights (Getting Started Tutorial) <https://docs.typo3.org/permalink/t3start:backend-users-system-maintainer>`_
    *   `Create an administrator / System Maintainer using a console command (Getting Started Tutorial) <https://docs.typo3.org/permalink/t3start:backend-users-admin-cli>`_

System Maintainers are
persisted within the :file:`config/system/settings.php` as
:php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['systemMaintainers']`.
