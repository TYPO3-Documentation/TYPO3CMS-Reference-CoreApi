<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\ContentObject\Event\AfterRecordIsRenderedEvent;

final readonly class WrapRenderedRecordListener
{
  #[AsEventListener('my_extension/wrap-rendered-record')]
  public function __invoke(AfterRecordIsRenderedEvent $event): void
  {
    $record = $event->getRecord();
    if ($record->getMainType() !== 'tt_content') {
      return;
    }
    $event->setRenderedRecord(sprintf(
      '<div data-uid="%d">%s</div>',
      $record->getUid(),
      $event->getRenderedRecord(),
    ));
  }
}
