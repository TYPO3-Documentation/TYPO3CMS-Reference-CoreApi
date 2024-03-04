<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Page;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Domain\Event\BeforePageIsRetrievedEvent;
use TYPO3\CMS\Core\Domain\Page;

#[AsEventListener(
    identifier: 'my-extension/my-custom-page-resolver',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforePageIsRetrievedEvent $event): void
    {
        if ($event->getPageId() === 13) {
            $event->setPageId(42);
            return;
        }

        if ($event->getContext()->getPropertyFromAspect('language', 'id') > 0) {
            $event->setPage(new Page(['uid' => 43]));
        }
    }
}
