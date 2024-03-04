<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Extbase\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Extbase\Event\Configuration\BeforeFlexFormConfigurationOverrideEvent;

#[AsEventListener(
    identifier: 'my-extension/before-flexform-configuration-override',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforeFlexFormConfigurationOverrideEvent $event): void
    {
        // Configuration from TypoScript
        $frameworkConfiguration = $event->getFrameworkConfiguration();

        // Configuration from FlexForm
        $originalFlexFormConfiguration = $event->getOriginalFlexFormConfiguration();

        // Currently merged configuration
        $flexFormConfiguration = $event->getFlexFormConfiguration();

        // Implement custom logic
        $flexFormConfiguration['settings']['foo'] = 'set from event listener';

        $event->setFlexFormConfiguration($flexFormConfiguration);
    }
}
