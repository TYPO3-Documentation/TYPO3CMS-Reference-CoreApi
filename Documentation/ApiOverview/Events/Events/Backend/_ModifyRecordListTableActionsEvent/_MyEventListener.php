<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListHeaderColumnsEvent;
use TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListRecordActionsEvent;
use TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListTableActionsEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/recordlist/my-event-listener',
    method: 'modifyRecordActions',
)]
#[AsEventListener(
    identifier: 'my-extension/recordlist/my-event-listener',
    method: 'modifyHeaderColumns',
)]
#[AsEventListener(
    identifier: 'my-extension/recordlist/my-event-listener',
    method: 'modifyTableActions',
)]
final readonly class MyEventListener
{
    private LoggerInterface $logger;

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
                'move',
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
