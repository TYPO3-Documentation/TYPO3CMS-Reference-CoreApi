<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListHeaderColumnsEvent;
use TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListRecordActionsEvent;
use TYPO3\CMS\Backend\RecordList\Event\ModifyRecordListTableActionsEvent;
use TYPO3\CMS\Backend\Template\Components\ActionGroup;
use TYPO3\CMS\Backend\Template\Components\ComponentFactory;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Imaging\IconFactory;

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
  public function __construct(
    private LoggerInterface $logger,
    private ComponentFactory $componentFactory,
    private IconFactory $iconFactory,
  ) {}

  public function modifyRecordActions(
    ModifyRecordListRecordActionsEvent $event,
  ): void {
    $table = $event->getRecord()->getMainType();

    // Add a custom action for a custom table to the secondary actions,
    // before the "move" action
    if ($table === 'my_custom_table' && !$event->hasAction('myAction')) {
      $button = $this->componentFactory->createGenericButton()
          ->setIcon($this->iconFactory->getIcon('actions-heart'))
          ->setTitle('My action');
      $event->setAction($button, 'myAction', ActionGroup::secondary, 'move');
    }

    // Remove the "viewBig" action if there are more than 4 secondary actions
    $secondary = $event->getActionGroup(ActionGroup::secondary)->getItems();
    if (count($secondary) > 4 && $event->hasAction('viewBig')) {
      $event->removeAction('viewBig');
    }

    // Move the "delete" action after the "edit" action
    if ($event->hasAction('delete')) {
      $event->moveActionTo('delete', ActionGroup::primary, after: 'edit');
    }
  }

  public function modifyHeaderColumns(
    ModifyRecordListHeaderColumnsEvent $event,
  ): void {
    // Change label of "control" column
    $event->setColumn('Custom Controls', '_CONTROL_');

    // Add a custom class for the table header row
    $event->setHeaderAttributes(['class' => 'my-custom-class']);
  }

  public function modifyTableActions(
    ModifyRecordListTableActionsEvent $event,
  ): void {
    // Remove "edit" action and log, if this failed
    $actionRemoved = $event->removeAction('unknown');
    if (!$actionRemoved) {
      $this->logger->warning('Action "unknown" could not be removed');
    }

    // Add a custom clipboard action after "copyMarked"
    $event->setAction(
      '<button>My action</button>',
      'myAction',
      '',
      'copyMarked',
    );

    // Set a custom label for the case, no actions are available for the user
    $event->setNoActionLabel(
      'No actions available due to missing permissions.',
    );
  }
}
