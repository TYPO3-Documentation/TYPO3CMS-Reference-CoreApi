<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Messenger\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Messenger\Event\BeforeMessengerDoctrineCloseEvent;

#[AsEventListener(
  identifier: 'my-extension/keep-reporting-connection-open',
)]
final readonly class KeepReportingConnectionOpen
{
  public function __invoke(BeforeMessengerDoctrineCloseEvent $event): void
  {
    if ($event->getConnectionName() === 'Reporting') {
      $event->skip();
    }
  }
}
