<?php

namespace MyVendor\MyExample\EventListener;

use TYPO3\CMS\Backend\Backend\Event\SystemInformationToolbarCollectorEvent;
use TYPO3\CMS\Backend\Toolbar\InformationStatus;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/add-release-info-to-sysstem-information',
)]
final class AddReleaseInfoToSystemInformationEventListener
{
    public function __invoke(SystemInformationToolbarCollectorEvent $event): void
    {
        [$releaseDate, $releaseHash, $releaseAge] = $this->getReleaseData();

        $event->getToolbarItem()->addSystemInformation(
            'Release nr / hash',
            $releaseHash ?? 'n/a',
            'actions-cloud-upload',
        );

        if ($releaseAge > 14) {
            $event->getToolbarItem()->addSystemMessage(
                sprintf('Release is %d days old', $releaseAge),
                InformationStatus::WARNING,
                1,
            );
        }

        $event->getToolbarItem()->addSystemInformation(
            'Release date',
            $releaseDate ?? 'n/a',
            'actions-calendar',
        );
    }

    private function getReleaseData(): array
    {
        // Todo:: Implement
        return ['01.10.2025 11:11:11', 'abc123', 15];
    }
}
