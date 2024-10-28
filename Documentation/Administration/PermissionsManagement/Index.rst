:navigation-title: Permissions
.. include:: /Includes.rst.txt

.. index:: backend, acl, permissions, user groups, user management

.. _permissions-management:

======================
Permissions management
======================

.. warning::

   This chapter (and the following) cover modules that will only be available for backend users
   with :ref:`"admin" <admin-user>` access privileges.

Introduction
============

TYPO3 is known for its flexibility and the ability to be expanded. It's packed
with lots of built-in features and can be easily customized to fit your needs.
That's why it is equipped with an advanced way to manage who gets access
to different parts of the system. This solution works well for both small
and large projects, allowing for detailed setting of permissions for various
user roles, each with different levels of access.

The access options in the TYPO3 backend are split into different areas.
They can be configured at the levels of users and groups. Access can be set up
for specific modules and pages, database mounts, file storage, content elements,
and also individual fields within content elements.

A well-thought out initial setup is particularly important for
permissions management. Skipping this step can introduce complex
issues as your project expands. As time passes, managing access levels can turn
into a challenging and time-consuming task. In extreme situations, you might find
yourself needing to overhaul your permissions setup entirely. Moreover, improper
permission setup could lead to a risky workaround: granting administrative
privileges to users who shouldn't have them, even though it may seem like a quick fix at the time.
This approach compromises security and deviates from best practice.

.. note::

    The intention behind the previous text isn't to make you worried about the complexity
    of access management in TYPO3. Actually, it's just the opposite. We want to show you
    that you're working with a great tool. It might seem a bit complicated at first,
    but as you learn more about it, get comfortable using it, and follow some
    well-established practices, you'll find it very effective and easy to use.

We also recognize that each project is unique and may require a distinct setup
for permissions. Therefore, please consider this document as a compilation
of recommended practices and guidelines that could be beneficial in managing
permissions within the TYPO3 backend. However, remember that these recommendations
are adaptable and can be tailored to suit your specific requirements.

.. _available-acl-options:

What access options can be set within TYPO3?
============================================

Access options in TYPO3 are categorized into several distinct groups.
For a more detailed exploration, refer to the :ref:`Access Control Options <t3coreapi:access-options>`
documentation page. However, here's a quick overview to give you an idea
of what to consider when configuring permissions in the backend.

..  rst-class:: dl-parameters

Access lists
    **Modules** - A list of submodules accessible to a user

    **Dashboard widgets** - A selection of dashboard widgets that a user can be permitted to use on the dashboard

    **Tables for listing** - A list of tables that a user is permitted to view in the backend

    **Tables for editing** - A list of tables that a user is permitted to edit in the backend

    **Page types** -A list of page types that a user is allowed to use within the pages tree

    **Excludefields** - A list of default-excluded fields (columns) within tables, requiring explicit access permission

    **Explicitly allow/deny field values** - A list of options within select fields whose access is restricted and must be explicitly granted

    **Languages** - Restricts access to content in selected languages only

Mounts
    **Database Mounts** - Specifies which parts of the pages tree are accessible to the user.

    **File Mounts** - Specify accessible folders within storage for users

    **Category Mounts** - Specify which sections of the system's categories tree are accessible to the user

Page permissions
    Grant access to individual pages based on user and group IDs.

User TSConfig
    A TypoScript-defined, flexible, and hierarchical configuration for "soft" permissions and backend customization for users or groups

Visualizing this overview of Access Control Options will help in developing
the naming convention for backend groups later on.

.. note::
    Different types of Access Control Options can be leveraged to establish
    naming conventions for backend user groups.

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   GeneralRecommendations/Index
   SettingUpBackendGroups/Index
   ExampleConfiguration/Index
   PermissionsSynchronization/Index
   GroupsInheritance/Index
