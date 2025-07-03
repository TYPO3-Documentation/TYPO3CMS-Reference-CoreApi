<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\View\Event\AfterSectionMarkupGeneratedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/after-section-markup-generated',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterSectionMarkupGeneratedEvent $event): void
    {
        // Check for relevant backend layout
        if ($event->getPageLayoutContext()->getBackendLayout()->getIdentifier() !== 'someBackendLayout') {
            return;
        }

        // Check for relevant column
        if ($event->getColumnConfig()['identifier'] !== 'someColumn') {
            return;
        }

        $event->setContent('
            <div class="t3-page-ce">
                <div class="t3-page-ce-element">
                    <div class="t3-page-ce-header">
                        <div class="t3-page-ce-header-title">
                            Some content at the end of the column
                        </div>
                    </div>
                </div>
            </div>
        ');
    }
}
