<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\RecordList\EventListener;

use TYPO3\CMS\Backend\RecordList\DownloadPreset;
use TYPO3\CMS\Backend\RecordList\Event\BeforeRecordDownloadPresetsAreDisplayedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(identifier: 'my-package/modify-record-list-preset')]
final readonly class PresetListener
{
    public function __invoke(BeforeRecordDownloadPresetsAreDisplayedEvent $event): void
    {
        $presets = $event->getPresets();

        switch ($event->getDatabaseTable()) {
            case 'be_users':
                $presets[] = new DownloadPreset('PSR-14 preset', ['uid', 'email']);
                break;

            case 'pages':
                $presets[] = new DownloadPreset('PSR-14 preset', ['title']);
                $presets[] = new DownloadPreset('Another PSR-14 preset', ['title', 'doktype']);
                break;

            case 'tx_myvendor_myextension':
                $presets[] = new DownloadPreset('PSR-14 preset', ['uid', 'something']);
                break;
        }

        $presets[] = new DownloadPreset('Available everywhere, simple UID list', ['uid']);

        $presets['some-identifier'] = new DownloadPreset('Overwrite preset', ['uid, pid'], 'some-identifier');

        $event->setPresets($presets);
    }
}
