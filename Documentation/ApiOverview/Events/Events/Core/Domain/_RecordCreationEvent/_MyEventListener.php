<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Access;

use MyVendor\MyExtension\Domain\Model\Coordinates;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Domain\Event\RecordCreationEvent;

final readonly class MyEventListener
{
    #[AsEventListener]
    public function __invoke(RecordCreationEvent $event): void
    {
        $rawRecord = $event->getRawRecord();
        if ($rawRecord->getMainType() !== 'tt_content') {
            return;
        }
        if ($rawRecord->getRecordType() !== 'maps') {
            return;
        }
        if (!$event->hasProperty('coordinates')) {
            return;
        }
        $event->setProperty(
            'coordinates',
            new Coordinates($event->getProperty('coordinates')),
        );
    }
}
