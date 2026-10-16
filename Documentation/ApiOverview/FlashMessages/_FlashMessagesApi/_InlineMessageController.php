<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;

final readonly class InlineMessageController
{
  public function __construct(
    private FlashMessageService $flashMessageService,
  ) {}

  public function addMessage(FlashMessage $message): void
  {
    $messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();
    $messageQueue->addMessage($message);
  }
}
