<?php

declare(strict_types=1);

namespace MyVendor\MySitepackage\PageTitle;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class WebsiteTitleProvider extends AbstractPageTitleProvider
{
    public function __construct(SiteFinder $siteFinder)
    {
        $site = $siteFinder->getSiteByPageId($this->getTypoScriptFrontendController()->page['uid']);
        $titles = [
            $this->getTypoScriptFrontendController()->page['title'],
            $this->$site->getAttribute('websiteTitle'),
        ];

        $this->title = $this->doSomeThing($titles);
    }

    private function doSomeThing(array $titles): string
    {
        // do something
        return implode(' - ', $titles);
    }

    private function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
