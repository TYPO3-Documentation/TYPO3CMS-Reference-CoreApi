.. include:: /Includes.rst.txt

.. index:: backend, acl, permissions, user groups, user management

.. _general-recommendations:

=======================
General recommendations
=======================

Recommendations outlined in this chapter, although not directly focused on
setting permissions in TYPO3, are closely related due to the various security
aspects described. It is advisable to thoroughly review these recommendations
before proceeding to the next chapter, where guidance on establishing top-level
backend groups corresponding to different roles, such as editors, proofreaders,
and others, is explained.

.. _user-specific-accounts:

Create user-specific accounts
=============================

When creating backend users, avoid usage of generic usernames like :samp:`editor`,
:samp:`webmaster`, :samp:`proofreader`, etc. Instead use their real names,
such as :samp:`johndoe`, :samp:`john.doe`, or even their email address, :samp:`john.doe@mail.com`.
This approach guarantees that the identity of the user logging into the TYPO3
backend is always known, as well as who is responsible for specific changes
in content or configuration.

In the context of :abbr:`GDPR (General Data Protection Regulation)`, it is recommended
to use properly named accounts to easily distinguish individuals. Assigning top-level
groups to these accounts makes identifying user roles straightforward.

.. figure:: /Images/ManualScreenshots/PermissionsManagement/PermissionsManagementBadUserNaming.png
   :alt: Bad username setup

   Bad username setup

.. figure:: /Images/ManualScreenshots/PermissionsManagement/PermissionsManagementGoodUserNaming.png
   :alt: Good username setup

   Good username setup

.. note::
    Avoid generic names for a backend username, instead use their real names.

.. _ensure-safety:

How to ensure safety
====================

When configuring TYPO3 permissions, begin by granting users only necessary access,
adding more as needed for security. Avoid giving admin rights unless absolutely
necessary, and use specialized accounts for routine tasks like content management.

For temporary TYPO3 backend access, like for a temp worker or student,
use the feature to set an expiration date on accounts. This prevents security
risks from inactive accounts. Regularly review and remove unnecessary accounts.

Secure each user account with a strong password and follow
:ref:`secure password guidelines<t3coreapi:security-secure-passwords>` for new
or updated accounts. Promote cybersecurity by informing users about security policies.
Additionally, enable Multi-factor authentication (MFA) for an extra security layer.

.. note::
    - Grant users only the access they truly need
    - Instead of using administrative accounts, create groups for specific roles, such as editor, and assign these roles to users
    - Regularly maintain backend user accounts, removing any that are no longer needed
    - Always establish secure passwords for users

.. _permissions-via-groups:

Set permissions via groups, not user records
============================================

Permissions, like module visibility, language options, and database or file access,
can be configured via backend user records. While direct configuration on user
records may seem convenient, especially for small projects, it can lead
to long-term issues, such as difficulty tracking permission origins when spread
across users and groups. Centralizing permissions in backend groups simplifies their
management and maintenance.

.. figure:: /Images/ManualScreenshots/PermissionsManagement/PermissionsManagementDoNotSetPermissionsOnUserRecord.png
   :alt: User record without permissions

   Avoid setting permissions directly through the backend user record

When permissions are assigned to individual users and groups, updating them
requires editing each account. Setting permissions at the group level
simplifies updates, as changes automatically apply to all group members.

.. note::
    Configure permissions only through the backend user groups. Don’t set them on the user record.

.. _file-mounts-and-files-management:

File mounts and files management
================================

When planning for permissions and file access, consider how many separate
entry points (File Mounts) within file storage you will need. At a minimum,
you should create separate folders for each site you manage and then configure
them as distinct file mounts, which equate to separate backend groups.
These groups can later be assigned to users, granting them access to such folders.

There are cases where some folders and the files within them have to be shared
across multiple sites. For this purpose, create separate file mounts
and dedicated groups for them. Then, combine these groups within a role group,
ensuring that each user associated with such a role group will have access
to the specified folders and files in the storage.

..  uml:: _sample_backend_groups_hierarchy.plantuml
    :align: center
    :caption: Sample backend groups hierarchy
    :width: 700

This diagram demonstrates the potential structure of folders within storage.
Create dedicated file mounts for folders, and then use those file mounts within
backend user groups. This arrangement enables two users with editor roles to
access distinct sets of folders: one can access files from Website A
and Shared folders, while the other accesses Website B and Shared folders.

Often more complex configuration will be required, with a more nested folder
structure for each site. However, the setup remains similar - create separate
file mounts where needed and a backend group that will utilize this file mount.
Then, assign such groups to role groups.

.. note::
    For each File Mount create a separate backend user group.
