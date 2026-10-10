<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Charset\CharsetConverter;
use TYPO3\CMS\Core\Resource\Event\SanitizeFileNameEvent;

#[AsEventListener(
  identifier: 'my-extension/ascii-filename',
)]
final readonly class AsciiFileNameListener
{
  public function __construct(
    private CharsetConverter $charsetConverter,
  ) {}

  public function __invoke(SanitizeFileNameEvent $event): void
  {
    $fileName = $this->charsetConverter->utf8_char_mapping($event->getFileName());
    $event->setFileName((string)preg_replace('/[^.\w-]/', '_', $fileName));
  }
}
