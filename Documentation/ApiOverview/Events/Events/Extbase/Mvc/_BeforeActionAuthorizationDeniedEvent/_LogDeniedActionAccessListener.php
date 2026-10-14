<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Extbase\Event\Mvc\BeforeActionAuthorizationDeniedEvent;

final readonly class LogDeniedActionAccessListener
{
  public function __construct(
    private LoggerInterface $logger,
  ) {}

  #[AsEventListener('my_extension/log-denied-action-access')]
  public function __invoke(BeforeActionAuthorizationDeniedEvent $event): void
  {
    $this->logger->notice('Access to an Extbase action was denied', [
      'controller' => $event->getControllerClassName(),
      'action' => $event->getActionMethodName(),
      'reason' => $event->getFailureReason()->value,
    ]);
  }
}
