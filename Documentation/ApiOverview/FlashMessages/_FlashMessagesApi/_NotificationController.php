<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

final readonly class NotificationController
{
  public function __construct(
    private FlashMessageService $flashMessageService,
  ) {}

  public function notify(): void
  {
    $notificationQueue = $this->flashMessageService
      ->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
    $notificationQueue->enqueue(new FlashMessage(
      'I am a message rendered as notification',
      'Hooray!',
      ContextualFeedbackSeverity::OK,
    ));
  }
}
