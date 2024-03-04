<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Redirects\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Redirects\Event\ModifyAutoCreateRedirectRecordBeforePersistingEvent;
use TYPO3\CMS\Redirects\RedirectUpdate\PlainSlugReplacementRedirectSource;

#[AsEventListener(
    identifier: 'my-extension/modify-auto-create-redirect-record-before-persisting',
)]
final readonly class MyEventListener
{
    public function __invoke(
        ModifyAutoCreateRedirectRecordBeforePersistingEvent $event,
    ): void {
        // Only work on plain slug replacement redirect sources.
        if (!($event->getSource() instanceof PlainSlugReplacementRedirectSource)) {
            return;
        }

        // Get prepared redirect record and change some values
        $record = $event->getRedirectRecord();

        // Override the status code, eventually to another value than
        // configured in the site configuration
        $record['status_code'] = 307;

        // Set value to a field extended by a custom extension, to persist
        // additional data to the redirect record.
        $record['custom_field_added_by_a_extension']
            = 'page_' . $event->getSlugRedirectChangeItem()->getPageId();

        // Update changed record in event to ensure changed values are saved.
        $event->setRedirectRecord($record);
    }
}
