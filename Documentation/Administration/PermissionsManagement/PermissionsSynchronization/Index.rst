.. include:: /Includes.rst.txt

.. index:: backend, acl, permissions, user groups, user management

.. _permissions-synchronization:

===========================
Permissions synchronization
===========================

When administrators create backend users and groups in TYPO3, assigning permissions
that are stored in the database, they can easily edit these settings via the backend module.
However, managing these settings across different environments — testing, staging,
and production — can be challenging.

Ensuring ACL configurations are consistent and synchronized can be time-consuming,
often leading to issues. For example, developers might forget to update permissions
across environments during deployments, causing inconsistencies. There are strategies
to mitigate these synchronization challenges.

.. _permissions-import-export:

Managing database configurations: importing and exporting
=========================================================

A solution for synchronizing permissions across environments in TYPO3 is using
the import/export feature (more details: :ref:`TYPO3 Import / Export <ext_impexp:_usage>`). This feature
allows exporting and importing records, including relational data, across different
instances.

However, you might prefer not to export/import backend user accounts directly.
After importing groups and permissions, reassign these groups to existing users
as needed. Keep in mind though, that managing environment-specific groups while
updating others can be a complex task.

.. _deployable-permissions:

Deployable permissions
======================

A highly desired feature not yet in TYPO3 core is `Deployable permissions` for ACLs,
allowing permission sets to be stored in files for version control and easy deployment
across environments. This ensures consistent permission application and simple
updates or rollbacks via version control systems (VCS).

In the meantime, the community extension `Permission Sets <https://github.com/b13/permission-sets>`__
offers a workaround, linking permission sets to TYPO3 backend user groups
via yaml files, filling this functionality gap. However, it's currently in the
testing phase, as noted by its author.
