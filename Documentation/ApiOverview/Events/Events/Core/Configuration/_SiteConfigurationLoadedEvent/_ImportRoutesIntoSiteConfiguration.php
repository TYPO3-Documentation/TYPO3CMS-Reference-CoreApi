<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Configuration\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Configuration\Event\SiteConfigurationLoadedEvent;
use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\Utility\ArrayUtility;

#[AsEventListener(
    identifier: 'my-extension/import-routes-into-site-configuration',
)]
final readonly class ImportRoutesIntoSiteConfiguration
{
    private const ROUTES = 'EXT:my_extension/Configuration/Routes/Routes.yaml';

    public function __construct(
        private YamlFileLoader $yamlFileLoader,
    ) {}

    public function __invoke(SiteConfigurationLoadedEvent $event): void
    {
        $routeConfiguration = $this->yamlFileLoader->load(self::ROUTES);

        // Using this method instead of array_merge_recursive will
        // prevent duplicate keys, and also allow to use the special
        // "_UNSET" handling properly.
        $configuration = ArrayUtility::mergeRecursiveWithOverrule(
            $event->getConfiguration(),
            $$routeConfiguration,
        );

        $event->setConfiguration($configuration);
    }
}
