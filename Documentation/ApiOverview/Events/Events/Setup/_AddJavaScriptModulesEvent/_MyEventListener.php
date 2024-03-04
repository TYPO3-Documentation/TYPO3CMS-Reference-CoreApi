<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\UserSettings\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Setup\Event\AddJavaScriptModulesEvent;

#[AsEventListener(
    identifier: 'my-extension/my-event-listener',
)]
final readonly class MyEventListener
{
    // The name of JavaScript module to be loaded
    private const MODULE_NAME = 'TYPO3/CMS/MyExtension/CustomUserSettingsModule';

    public function __invoke(AddJavaScriptModulesEvent $event): void
    {
        if (in_array(self::MODULE_NAME, $event->getModules(), true)) {
            return;
        }
        $event->addModule(self::MODULE_NAME);
    }
}
