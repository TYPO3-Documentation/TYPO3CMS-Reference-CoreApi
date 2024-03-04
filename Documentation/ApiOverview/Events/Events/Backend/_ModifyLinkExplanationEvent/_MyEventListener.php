<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Form\Event\ModifyLinkExplanationEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-link-explanation',
)]
final readonly class MyEventListener
{
    public function __construct(
        private readonly IconFactory $iconFactory,
    ) {}

    public function __invoke(ModifyLinkExplanationEvent $event): void
    {
        // Use a custom icon for a custom link type
        if ($event->getLinkData()['type'] === 'myCustomLinkType') {
            $event->setLinkExplanationValue(
                'icon',
                $this->iconFactory->getIcon(
                    'my-custom-link-icon',
                    Icon::SIZE_SMALL,
                )->render(),
            );
        }
    }
}
