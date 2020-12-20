.. include:: /Includes.rst.txt
.. index:: Events; AfterGroupsResolvedEvent
.. _AfterGroupsResolvedEvent:

========================
AfterGroupsResolvedEvent
========================

When user groups are loaded, for example when a backend editors' groups and permissions
are calculated, a new PSR-14 event `AfterGroupsResolvedEvent` is fired.

This event contains a list of retrieved groups from the database, which can
be modified (e.g. adding more groups when a particular user or a user from a
given location is logged in) via Event listeners.


.. note::

   This event acts as a substitution for the removed TYPO3 Hook
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauthgroup.php']['fetchGroups_postProcessing']`.


API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getSourceDatabaseTable()
   :sep:`|` :aspect:`ReturnType:` string
   :sep:`|`

   :sql:`be_groups` or :sql:`fe_groups` depending on the context.


getGroups()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   List of group records including sub groups as resolved by core.

   .. note::

      Order is important: A user with main groups "1,2", where 1 has sub group 3,
      results in "3,1,2" as record list array - sub groups are listed before the group
      that includes the sub group.

setGroups(array $groups)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   Set (overwrite) the list of groups.

getOriginalGroupIds()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   List of group uids directly attached to the user.

getUserData()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   Returns the full user record with all fields.
