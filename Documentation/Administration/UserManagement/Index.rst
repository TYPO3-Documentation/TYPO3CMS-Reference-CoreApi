:navigation-title: Backend users
..  include:: /Includes.rst.txt


..  _user-management:

=======================
Backend user management
=======================

..  important::

    This chapter (and the following) cover modules that will only be available for backend users
    with :ref:`"admin" <admin-user>` access privileges.

We saw earlier that TYPO3 CMS enforces a strict separation of
so-called "frontend" and "backend". The same is true for users:
there are "frontend users", who are web site visitors, and
"backend users", who are editors and administrators.

Working with frontend users is discussed in the :ref:`Editors Guide <t3editors:frontend-login>`.
We will now look at backend users and how to set up groups and
permissions.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Adding Backend Users <backendusers>`

        Create additional backend users that will have access to TYPO3's
        backend interface.

    ..  card:: :ref:`Changing The Backend Language <backendlanguages>`

        Setup additional backend languages in TYPO3 allowing users to select
        an alternative language to use in the backend.

..  toctree::
    :maxdepth: 5
    :titlesonly:
    :glob:

    BackendUsers
    BackendLanguages
    BackendPrivileges/Index
    BackendUsers/Index
    Groups/Index
    GroupPermissions/Index
    PagePermissions/Index
    UserSetup/Index
