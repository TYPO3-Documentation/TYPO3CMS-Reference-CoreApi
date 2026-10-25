<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\BeforeFormValueIsRenderedEvent;

final readonly class CheckboxYesNoListener
{
  #[AsEventListener(
    identifier: 'my-extension/checkbox-yes-no',
  )]
  public function __invoke(BeforeFormValueIsRenderedEvent $event): void
  {
    if ($event->element->getType() !== 'Checkbox') {
      return;
    }
    // Show "Yes" or "No" in the summary page and in the emails
    $event->data['processedValue'] = ($event->data['value'] ?? false)
      ? 'Yes'
      : 'No';
  }
}
