<?php

declare(strict_types=1);

namespace MyVendor\MyPackage\Backend\Search\EventListener;

use TYPO3\CMS\Backend\Search\Event\BeforeLiveSearchFormIsBuiltEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final class BeforeLiveSearchFormIsBuiltEventListener
{
    #[AsEventListener('my-package/backend/search/modify-live-search-form-data')]
    public function __invoke(BeforeLiveSearchFormIsBuiltEvent $event): void
    {
        $event->addHints(...[
            'LLL:EXT:my-package/Resources/Private/Language/locallang.xlf:identifier',
        ]);
        $event->setAdditionalViewData(['myVariable' => 'some data']);
    }
}
