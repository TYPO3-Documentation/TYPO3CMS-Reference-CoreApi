<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent;

final class MyEventListener
{
    public function __invoke(ModifyHrefLangTagsEvent $event): void
    {
        $hrefLangs = $event->getHrefLangs();
        $request = $event->getRequest();

        // Do anything you want with $hrefLangs
        $hrefLangs = [
            'en-US' => 'https://example.org',
            'nl-NL' => 'https://example.org/nl',
        ];

        // Override all hrefLang tags
        $event->setHrefLangs($hrefLangs);

        // Or add a single hrefLang tag
        $event->addHrefLang('de-DE', 'https://example.org/de');
    }
}
