<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Backend\RecordList\Event\AfterRecordListRowPreparedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final readonly class MarkLockedRecordListRowListener
{
  #[AsEventListener('my_extension/mark-locked-record-list-row')]
  public function __invoke(AfterRecordListRowPreparedEvent $event): void
  {
    $lockInfo = $event->getLockInfo();
    if (!is_array($lockInfo)) {
      // The record is not being edited by anybody else
      return;
    }

    $tagAttributes = $event->getTagAttributes();
    // Append, so that the classes TYPO3 set are kept
    $tagAttributes['class'] = trim(
      ($tagAttributes['class'] ?? '') . ' my-extension-locked',
    );
    $tagAttributes['title'] = $lockInfo['msg'] ?? '';
    $event->setTagAttributes($tagAttributes);

    $data = $event->getData();
    $data['__label'] = ($data['__label'] ?? '') . ' (locked)';
    $event->setData($data);
  }
}
