.. include:: /Includes.rst.txt


.. _access-other-options:

=============
Other Options
=============

This chapter presents a few more, miscellaneous options for
backend users and groups.


.. _access-other-options-users:

Backend users
=============

Default language
   This is the language in which the backend will be localized for the
   user. The users can change the language themselves in the
   :ref:`User Settings <backendlanguages>`
   module.

   .. note::

      Language packs must be downloaded using the :guilabel:`System > Maintenance > Manage Language Packs`
      module. As long as the language packs are not available, the backend
      will still display in English.

Fileoperation permissions
   This is a complement to the File Mounts and defines exactly which operations
   the user is allowed to perform on both files and folders.

Access options
   A backend user can be disabled (first flag in the "General" tab). A disabled
   user cannot log into the backend anymore. Furthermore, in the "Access" tab
   a start and end time can be given, defining a time interval during which the
   user will be allowed to log into the backend. Authentication before the start
   time and after the end time will automatically fail.

Lock to domain
   This setting constrains the user to use a specific domain for logging
   into the TYPO3 backend. This is very useful in setups with multiple
   sites.


.. _access-other-options-groups:

Backend Groups
==============

Disable
  Setting this flag will immediately disable the group for
  all members

Lock to domain
  This restricts a group to a given domain. If a user logs in from another
  domain, that group membership will be ignored.

Hide in lists
  This flag will prevent the group from appearing in various
  listings in TYPO3. This includes modules like :guilabel:`Administration > Permissions`.

Inherit settings from groups (Sub Groups)
  Assigns sub-groups to this group. Sub-groups are
  evaluated before the group including them. If a user is a member of
  a group which includes one or more sub-groups, the user will also be
  a member of the sub-groups.
