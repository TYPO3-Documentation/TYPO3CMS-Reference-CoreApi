.. include:: /Includes.rst.txt
.. index:: Events; ModifyRecordListHeaderColumnsEvent
.. _ModifyRecordListRecordActionsEvent:


========================================
ModifyRecordListRecordActionsEvent
========================================

.. versionadded:: 11.4

An event to modify the displayed record actions (for example
:guilabel:`edit`, :guilabel:`copy`, :guilabel:`delete`) for a table in
the record list.

API
===

.. php:namespace:: TYPO3\CMS\Recordlist\Event\

.. php:class:: ModifyRecordListRecordActionsEvent

   .. php:method:: setAction(string $action, string $actionName = '', string $group = '', string $before = '', string $after = '')

      Add a new action or override an existing one. Latter is only possible,
      in case $actionName is given. Otherwise, the column will be added with
      a numeric index, which is generally not recommended. It's also possible
      to define the position of an action with either the "before" or "after"
      argument, while their value must be an existing action.

      .. note::
         In case non or an invalid $group is provided, the new action will
         be added to the secondary group.

      :param string $action: The action to be set
      :param string $actionName: Recommended: the name of the action
      :param string $group: Recommended: the group where the action should be added
      :param string $before: Optional: the action should be added before this one
      :param string $after: Optional: The action should be added after this one
      :returntype: void

   .. php:method:: hasAction(string $actionName, string $group = '')

      Whether the action exists in the given group. In case non or
      an invalid $group is provided, both groups will be checked.

      :param string $actionName: The name of the action
      :param string $group: Optional: the group where the action should be found
      :returntype: bool

   .. php:method:: getAction(string $actionName, string $group = '')

      Get action by its name. In case the action exists in both groups
      and non or an invalid $group is provided, the action from the
      "primary" group will be returned.

      :param string $actionName: The name of the action
      :param string $group: Optional: the group where the action should be found
      :returntype: string|null
      :returns: The action or NULL if the action does not exist

   .. php:method:: removeAction(string $actionName)

      Remove action by its name. In case the action exists in both groups
      and non or an invalid $group is provided, the action will be removed
      from both groups.

      :param string $actionName: The name of the action
      :param string $group: Optional: the group where the action should be deleted from
      :returntype: bool
      :returns: Whether the action could be removed - Will therefore return
         FALSE if the action to remove does not exist.

   .. php:method:: getActionGroup(string $group)

         Get the actions of a specific group

         :param string $group: The group
         :returntype: array

   .. php:method:: setActions(array $actions)

      :param array $actions: An array of string, each represents an action
      :returntype: void


   .. php:method:: getActions()

      :returntype: array

   .. php:method:: setNoActionLabel(string $noActionLabel)

      :param string $actionName: The label, which will be displayed, in case no action is available
      :returntype: void

   .. php:method:: getNoActionLabel()

      Get the label, which will be displayed, in case no
      action is available for the current user. Note: If
      this returns an empty string, this only means that
      no other listener set a label before. TYPO3 will
      always fall back to a default if this remains empty.

      :returntype: string

   .. php:method:: getTable()

      :returntype: string

   .. php:method:: getRecordIds()

      :returntype: array

   .. php:method:: getRecordList()

      Returns the current DatabaseRecordList instance.

      :returntype: DatabaseRecordList


Usage
=====

See :ref:`combined usage example <ModifyRecordListTableActionsEvent-usage>`.
