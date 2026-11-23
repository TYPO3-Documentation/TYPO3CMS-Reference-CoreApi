<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Messenger\Event\ResolveFailureTransportEvent;

final readonly class RouteImportFailures
{
  #[AsEventListener('my-extension/route-import-failures')]
  public function __invoke(ResolveFailureTransportEvent $event): void
  {
    // Park the failed messages of the transport "import" separately
    if ($event->getReceiverName() === 'import') {
      $event->setFailureTransportName('failed_import');
    }
  }
}
