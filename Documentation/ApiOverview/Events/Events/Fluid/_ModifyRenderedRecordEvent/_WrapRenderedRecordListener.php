<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Fluid\Event\ModifyRenderedRecordEvent;

final readonly class WrapRenderedRecordListener
{
  #[AsEventListener('my_extension/wrap-rendered-record')]
  public function __invoke(ModifyRenderedRecordEvent $event): void
  {
    $record = $event->getRecord();
    $event->setRenderedRecord(sprintf(
      '<div data-record="%s" data-uid="%d">%s</div>',
      htmlspecialchars($record->getFullType()),
      $record->getUid(),
      $event->getRenderedRecord(),
    ));
  }
}
