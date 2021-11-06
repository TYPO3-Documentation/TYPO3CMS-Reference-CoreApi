.. include:: /Includes.rst.txt
.. index:: Events; ModifyRecordListTableActionsEvent
.. _ModifyRecordListTableActionsEvent:


========================================
ModifyRecordListTableActionsEvent
========================================

.. versionadded:: 11.4

An event to modify the multi record selection actions (for example
:guilabel:`edit`, :guilabel:`copy to clipboard`) for a table in the record list.

API
---

.. php:namespace:: TYPO3\CMS\Recordlist\Event\

.. php:class:: ModifyRecordListTableActionsEvent


   .. php:method:: setAction(string $action, string $actionName = '', string $before = '', string $after = '')

      Add a new action or override an existing one. Latter is only possible,
      in case $actionName is given. Otherwise, the action will be added with
      a numeric index, which is generally not recommended. It's also possible
      to define the position of an action with either the "before" or "after"
      argument, while their value must be an existing action.

      :param string $action: The action to be set
      :param string $actionName: Recommended: the name of the action
      :param string $before: Optional: the action should be added before this one
      :param string $after: Optional: The action should be added after this one
      :returntype: void

   .. php:method:: hasAction(string $actionName)

      Whether the action exists

      :param string $actionName: The name of the action
      :returntype: bool

   .. php:method:: getAction(string $actionName)

      Get action by its name

      :param string $actionName: The name of the action
      :returntype: string|null
      :returns: The action or NULL if the action does not exist

   .. php:method:: removeAction(string $actionName)

      Remove action by its name

      :param string $actionName: The name of the action
      :returntype: bool
      :returns: Whether the action could be removed - Will therefore return
         FALSE if the action to remove does not exist.

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

.. _ModifyRecordListTableActionsEvent-usage:

Usage
=====

An example registration of the events in your extensions' :file:`Services.yaml`:

.. code-block:: yaml

  MyVendor\MyPackage\RecordList\MyEventListener:
    tags:
      - name: event.listener
        identifier: 'my-package/recordlist/my-event-listener'
        method: 'modifyRecordActions'
      - name: event.listener
        identifier: 'my-package/recordlist/my-event-listener'
        method: 'modifyHeaderColumns'
      - name: event.listener
        identifier: 'my-package/recordlist/my-event-listener'
        method: 'modifyTableActions'

The corresponding event listener class:

.. code-block:: php

    use Psr\Log\LoggerInterface;
    use TYPO3\CMS\Recordlist\Event\ModifyRecordListHeaderColumnsEvent;
    use TYPO3\CMS\Recordlist\Event\ModifyRecordListRecordActionsEvent;
    use TYPO3\CMS\Recordlist\Event\ModifyRecordListTableActionsEvent;

    class MyEventListener {

        protected LoggerInterface $logger;

        public function __construct(LoggerInterface $logger)
        {
            $this->logger = $logger;
        }

        public function modifyRecordActions(ModifyRecordListRecordActionsEvent $event): void
        {
            $currentTable = $event->getTable();

            // Add a custom action for a custom table in the secondary action bar, before the "move" action
            if ($currentTable === 'my_custom_table' && !$event->hasAction('myAction')) {
                $event->setAction(
                    '<button>My Action</button>',
                    'myAction',
                    'secondary',
                    'move'
                );
            }

            // Remove the "viewBig" action in case more than 4 actions exist in the group
            if (count($event->getActionGroup('secondary')) > 4 && $event->hasAction('viewBig')) {
                $event->removeAction('viewBig');
            }

            // Move the "delete" action after the "edit" action
            $event->setAction('', 'delete', 'primary', '', 'edit');
        }

        public function modifyHeaderColumns(ModifyRecordListHeaderColumnsEvent $event): void
        {
            // Change label of "control" column
            $event->setColumn('Custom Controls', '_CONTROL_');

            // Add a custom class for the table header row
            $event->setHeaderAttributes(['class' => 'my-custom-class']);
        }

        public function modifyTableActions(ModifyRecordListTableActionsEvent $event): void
        {
            // Remove "edit" action and log, if this failed
            $actionRemoved = $event->removeAction('unknown');
            if (!$actionRemoved) {
                $this->logger->warning('Action "unknown" could not be removed');
            }

            // Add a custom clipboard action after "copyMarked"
            $event->setAction('<button>My action</button>', 'myAction', '', 'copyMarked');

            // Set a custom label for the case, no actions are available for the user
            $event->setNoActionLabel('No actions available due to missing permissions.');
        }

    }
