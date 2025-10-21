<?php

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Localization\Event\BeforeLabelResourceResolvedEvent;

final readonly class CustomTranslationDomainResolver
{
    #[AsEventListener(identifier: 'my-extension/custom-domain-names')]
    public function __invoke(BeforeLabelResourceResolvedEvent $event): void
    {
        // Shorten domain names for specific extension
        if ($event->packageKey !== 'my_extension') {
            return;
        }

        $event->domains['my_extension.messages'] =
            'EXT:my_extension/Resources/Private/Language/my_messages.xlf';
    }
}
