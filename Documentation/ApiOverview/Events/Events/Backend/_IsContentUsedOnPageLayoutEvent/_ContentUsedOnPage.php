<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Listener;

use TYPO3\CMS\Backend\View\Event\IsContentUsedOnPageLayoutEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/view/content-used-on-page'
)]
final class ContentUsedOnPage
{
    public function __invoke(IsContentUsedOnPageLayoutEvent $event): void
    {
        if ($event->getUsed()) {
            return true;
        }

        if ($record['colPos'] === 999 && !empty($record['tx_myext_content_parent'])) {
            $event->setUsed(true);
        }
    }
}
