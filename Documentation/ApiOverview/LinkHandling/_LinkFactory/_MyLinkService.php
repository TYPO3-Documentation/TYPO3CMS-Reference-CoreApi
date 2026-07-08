<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Typolink\LinkFactory;
use TYPO3\CMS\Frontend\Typolink\LinkResultInterface;
use TYPO3\CMS\Frontend\Typolink\UnableToLinkException;

readonly class MyLinkService
{
    public function __construct(
        protected LinkFactory $linkFactory,
    ) {}

    /**
     * Build a link to a page and return the ready-to-use URL.
     */
    public function pageUrl(int $pageUid, ContentObjectRenderer $contentObjectRenderer): string
    {
        try {
            $linkResult = $this->linkFactory->create(
                'Read more',
                ['parameter' => 't3://page?uid=' . $pageUid],
                $contentObjectRenderer,
            );
        } catch (UnableToLinkException) {
            return '';
        }

        return $linkResult->getUrl();
    }

    /**
     * Return the full anchor tag instead of just the URL.
     */
    public function pageLink(int $pageUid, ContentObjectRenderer $contentObjectRenderer): LinkResultInterface
    {
        return $this->linkFactory->create(
            'Read more',
            [
                'parameter' => 't3://page?uid=' . $pageUid,
                'target' => '_blank',
                'title' => 'Opens in a new window',
            ],
            $contentObjectRenderer,
        );
    }
}
