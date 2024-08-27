<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Country\Country;
use TYPO3\CMS\Core\Country\Event\BeforeCountriesEvaluatedEvent;

final readonly class EventListener
{
    #[AsEventListener(identifier: 'my-extension/before-countries-evaluated')]
    public function __invoke(BeforeCountriesEvaluatedEvent $event): void
    {
        $countries = $event->getCountries();
        unset($countries['BS']);
        $countries['XX'] = new Country(
            'XX',
            'XYZ',
            'Magic Kingdom',
            '987',
            '🔮',
            'Kingdom of Magic and Wonders',
        );
        $event->setCountries($countries);
    }
}
