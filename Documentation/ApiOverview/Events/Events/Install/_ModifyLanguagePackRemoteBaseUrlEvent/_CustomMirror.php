<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Install\Service\Event\ModifyLanguagePackRemoteBaseUrlEvent;

#[AsEventListener(
    identifier: 'my-extension/custom-mirror',
)]
final readonly class CustomMirror
{
    private const EXTENSION_KEY = 'my_extension';
    private const MIRROR_URL = 'https://example.org/typo3-packages/';

    public function __invoke(ModifyLanguagePackRemoteBaseUrlEvent $event): void
    {
        if ($event->getPackageKey() === self::EXTENSION_KEY) {
            $event->setBaseUrl(new Uri(self::MIRROR_URL));
        }
    }
}
