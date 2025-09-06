<?php

declare(strict_types=1);

namespace MyVendor\MySitepackage\PageTitle;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\PageTitle\PageTitleProviderInterface;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Frontend\Page\PageInformation;

#[Autoconfigure(public: true)]
final readonly class WebsiteTitleProvider implements PageTitleProviderInterface
{
    private ServerRequestInterface $request;

    public function __construct(
        private SiteFinder $siteFinder,
    ) {}

    public function getTitle(): string
    {
        $site = $this->siteFinder->getSiteByPageId($this->getPageInformation()->getId());
        $titles = [
            $this->getPageInformation()->getPageRecord()['title'] ?? '',
            $site->getAttribute('websiteTitle'),
        ];

        return implode(' - ', $titles);
    }

    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    private function getPageInformation(): PageInformation
    {
        $pageInformation = $this->request->getAttribute('frontend.page.information');
        if (!$pageInformation instanceof PageInformation) {
            throw new \Exception('Current frontend page information not available', 1730098625);
        }
        return $pageInformation;
    }
}
