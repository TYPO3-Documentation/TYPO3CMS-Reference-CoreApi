<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyGenericBackendMessagesEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

#[AsEventListener(
  identifier: 'my-extension/maintenance-warning',
)]
final readonly class MaintenanceWarningListener
{
  public function __invoke(ModifyGenericBackendMessagesEvent $event): void
  {
    $event->addMessage(new FlashMessage(
      'The site is in maintenance on Saturday from 8 to 10 am.',
      'Planned maintenance',
      ContextualFeedbackSeverity::WARNING,
    ));
  }
}
