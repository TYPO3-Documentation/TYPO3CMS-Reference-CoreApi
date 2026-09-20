<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\Form\Behavior;

use TYPO3\CMS\Backend\Form\Behavior\OnFieldChangeInterface;

final readonly class NotifyOnFieldChange implements OnFieldChangeInterface
{
  public function __construct(
    private string $title,
    private string $message,
  ) {}

  public function toArray(): array
  {
    return [
      // The name of the handler registered in JavaScript
      'name' => 'my-extension-notify',
      // Passed to the handler as its first argument
      'data' => [
        'title' => $this->title,
        'message' => $this->message,
      ],
    ];
  }
}
