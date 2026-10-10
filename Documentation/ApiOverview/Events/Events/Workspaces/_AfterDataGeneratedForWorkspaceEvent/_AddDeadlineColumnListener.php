<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Workspaces\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Workspaces\Event\AfterDataGeneratedForWorkspaceEvent;

#[AsEventListener(
  identifier: 'my-extension/workspaces/add-deadline-column',
)]
final readonly class AddDeadlineColumnListener
{
  public function __invoke(AfterDataGeneratedForWorkspaceEvent $event): void
  {
    $data = $event->getData();
    foreach ($data as $identifier => $record) {
      if ($record['table'] !== 'tt_content') {
        continue;
      }
      $data[$identifier]['additional']['deadline'] = [
        'label' => 'Deadline',
        'value' => '2026-03-01 08:00',
        'icon' => 'actions-clock',
        'title' => 'Editorial deadline',
      ];
    }
    $event->setData($data);
  }
}
