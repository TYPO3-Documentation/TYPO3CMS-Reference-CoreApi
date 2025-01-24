<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Language;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Core\Domain\Event\BeforeRecordLanguageOverlayEvent;

#[AsEventListener(
    identifier: 'my-extension/before-record-language-overlay',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeRecordLanguageOverlayEvent $event): void
    {
        if ($event->getTable() !== 'tx_myextension_domain_model_record') {
            return;
        }

        $currentLanguageAspect = $event->getLanguageAspect();
        $newLanguageAspect = new LanguageAspect(
            $currentLanguageAspect->getId(),
            $currentLanguageAspect->getContentId(),
            LanguageAspect::OVERLAYS_ON,
            $currentLanguageAspect->getFallbackChain(),
        );

        $event->setLanguageAspect($newLanguageAspect);
    }
}
