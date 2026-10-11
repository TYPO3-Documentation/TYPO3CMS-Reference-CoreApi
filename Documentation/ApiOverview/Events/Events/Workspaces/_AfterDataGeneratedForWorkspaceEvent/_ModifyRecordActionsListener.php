<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Workspaces\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Workspaces\Event\AfterDataGeneratedForWorkspaceEvent;

#[AsEventListener(
  identifier: 'my-extension/workspaces/modify-record-actions',
)]
final readonly class ModifyRecordActionsListener
{
  public function __invoke(AfterDataGeneratedForWorkspaceEvent $event): void
  {
    $data = $event->getData();
    foreach ($data as $identifier => $record) {
      if ($record['table'] !== 'tt_content') {
        continue;
      }
      $data[$identifier]['actions'] = [
        // Render the publish button greyed out
        'publish' => ['enabled' => false],
        // Remove the discard button
        'remove' => ['visible' => false],
        // Add a button of your own
        'schedule' => [
          'icon' => 'actions-clock',
          'title' => 'Schedule publication',
        ],
      ];
    }
    $event->setData($data);
  }
}
