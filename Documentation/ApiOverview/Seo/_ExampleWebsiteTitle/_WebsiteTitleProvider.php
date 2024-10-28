<?php

declare(strict_types=1);

namespace MyVendor\MySitepackage\PageTitle;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\PageTitle\PageTitleProviderInterface;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Frontend\Page\PageInformation;

final readonly class WebsiteTitleProvider implements PageTitleProviderInterface
{
    public function __construct(
        private SiteFinder $siteFinder,
    ) {}

    public function getTitle(): string
    {
        /** @var PageInformation $pageInformation */
        $pageInformation = $this->getRequest()->getAttribute('frontend.page.information');

        $site = $this->siteFinder->getSiteByPageId($pageInformation->getId());
        $titles = [
            $pageInformation->getPageRecord()['title'],
            $site->getAttribute('websiteTitle'),
        ];

        return implode(' - ', $titles);
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
