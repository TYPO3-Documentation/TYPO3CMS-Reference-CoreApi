<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Redirects\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Redirects\Event\AfterPageUrlsForSiteForRedirectIntegrityHaveBeenCollectedEvent;

final class MyEventListener
{
    public function __construct(
        private RequestFactory $requestFactory,
    ) {}

    #[AsEventListener]
    public function __invoke(AfterPageUrlsForSiteForRedirectIntegrityHaveBeenCollectedEvent $event): void
    {
        $pageUrls = $event->getPageUrls();

        $additionalOptions = [
            'headers' => ['Cache-Control' => 'no-cache'],
            'allow_redirects' => false,
        ];

        $site = $event->getSite();
        foreach ($site->getLanguages() as $siteLanguage) {
            $sitemapIndexUrl = rtrim((string)$siteLanguage->getBase(), '/') . '/sitemap.xml';
            $response = $this->requestFactory->request(
                $sitemapIndexUrl,
                'GET',
                $additionalOptions,
            );
            $sitemapIndex = simplexml_load_string($response->getBody()->getContents());
            foreach ($sitemapIndex as $sitemap) {
                $sitemapUrl = (string)$sitemap->loc;
                $response = $this->requestFactory->request(
                    $sitemapUrl,
                    'GET',
                    $additionalOptions,
                );
                $sitemap = simplexml_load_string($response->getBody()->getContents());
                foreach ($sitemap as $url) {
                    $pageUrls[] = (string)$url->loc;
                }
            }
        }

        $event->setPageUrls($pageUrls);
    }
}
