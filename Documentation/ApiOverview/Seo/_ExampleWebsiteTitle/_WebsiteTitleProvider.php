<?php

declare(strict_types=1);

namespace MyVendor\MySitepackage\PageTitle;

use TYPO3\CMS\Core\PageTitle\PageTitleProviderInterface;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class WebsiteTitleProvider implements PageTitleProviderInterface
{
    public function __construct(
        private readonly SiteFinder $siteFinder,
    ) {}

    public function getTitle(): string
    {
        $site = $this->siteFinder->getSiteByPageId($this->getTypoScriptFrontendController()->page['uid']);
        $titles = [
            $this->getTypoScriptFrontendController()->page['title'],
            $site->getAttribute('websiteTitle'),
        ];

        // do something
        return implode(' - ', $titles);
    }

    private function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
