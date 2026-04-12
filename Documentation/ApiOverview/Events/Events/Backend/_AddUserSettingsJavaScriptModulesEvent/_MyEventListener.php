<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\UserSettings\EventListener;

use TYPO3\CMS\Backend\Event\AddUserSettingsJavaScriptModulesEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/my-event-listener',
)]
final readonly class MyEventListener
{
    public function __invoke(AddUserSettingsJavaScriptModulesEvent $event): void
    {
        $event->addJavaScriptModule('@my-extension/setupModule/some-file.js');
    }
}
