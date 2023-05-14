<?php

declare(strict_types=1);

namespace B13\Bolt\TsConfig;

use TYPO3\CMS\Core\Configuration\Event\ModifyLoadedPageTsConfigEvent as LegacyModifyLoadedPageTsConfigEvent;
use TYPO3\CMS\Core\TypoScript\IncludeTree\Event\ModifyLoadedPageTsConfigEvent;

class Loader
{
    public function addSiteConfigurationCore11(LegacyModifyLoadedPageTsConfigEvent $event): void
    {
        if (class_exists(ModifyLoadedPageTsConfigEvent::class)) {
            // TYPO3 v12 calls both old and new event. Check for class existence of new event to
            // skip handling of old event in v12, but continue to work with < v12.
            // Simplify this construct when v11 compat is dropped, clean up Services.yaml.
            return;
        }
        $this->findAndAddConfiguration($event);
    }

    public function addSiteConfiguration(ModifyLoadedPageTsConfigEvent $event): void
    {
        $this->findAndAddConfiguration($event);
    }

    protected function findAndAddConfiguration($event): void
    {
        // Business code
    }
}
