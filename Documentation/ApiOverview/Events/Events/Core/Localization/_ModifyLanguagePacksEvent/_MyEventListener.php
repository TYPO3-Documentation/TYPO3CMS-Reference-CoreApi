<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Install\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Install\Service\Event\ModifyLanguagePacksEvent;

#[AsEventListener(
    identifier: 'my-extension/modify-language-packs',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyLanguagePacksEvent $event): void
    {
        $extensions = $event->getExtensions();
        foreach ($extensions as $key => $extension) {
            // Do not download language packs from Core extensions
            if ($extension['type'] === 'typo3-cms-framework') {
                $event->removeExtension($key);
            }
        }

        // Remove German language pack from EXT:styleguide
        $event->removeIsoFromExtension('de', 'styleguide');
    }
}
