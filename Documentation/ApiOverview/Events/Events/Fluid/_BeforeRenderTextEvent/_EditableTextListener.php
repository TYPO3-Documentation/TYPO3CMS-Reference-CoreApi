<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Schema\Field\InputFieldType;
use TYPO3\CMS\Fluid\Event\BeforeRenderTextEvent;
use TYPO3Fluid\Fluid\Core\Parser\UnsafeHTMLString;

final readonly class EditableTextListener
{
  #[AsEventListener(
    identifier: 'my-extension/editable-text',
  )]
  public function __invoke(BeforeRenderTextEvent $event): void
  {
    if (!$event->getFieldSchema() instanceof InputFieldType) {
      return;
    }
    if (!$event->getRequest()?->getAttribute('my_extension.edit_mode')) {
      return;
    }
    // The listener escapes the value itself
    $event->setRenderedText(new UnsafeHTMLString(
      '<span class="editable">'
      . htmlspecialchars($event->getValue())
      . '</span>',
    ));
  }
}
