<?php

declare(strict_types=1);

namespace T3docs\Examples\LinkHandler;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Frontend\Typolink\LinkResult;
use TYPO3\CMS\Frontend\Typolink\LinkResultInterface;
use TYPO3\CMS\Frontend\Typolink\TypolinkBuilderInterface;
use TYPO3\CMS\Frontend\Typolink\UnableToLinkException;

/**
 * Builds a TypoLink to a Github issue
 */
class GithubLinkBuilder implements TypolinkBuilderInterface
{
    private const TYPE_GITHUB = 'github';

    public function buildLink(array $linkDetails, array $configuration, ServerRequestInterface $request, string $linkText = ''): LinkResultInterface
    {
        // Access ContentObjectRenderer from request
        $contentObjectRenderer = $request->getAttribute('currentContentObject');

        $issueId = (int)$linkDetails['issue'];
        if ($issueId < 1) {
            throw new UnableToLinkException(
                '"' . $issueId . '" is not a valid GitHub issue number.',
                // Use the Unix timestamp of the time of creation of this message
                1665304602,
                null,
                $linkText,
            );
        }
        $url = 'https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/' . $issueId;

        return (new LinkResult(self::TYPE_GITHUB, $url))
            ->withLinkConfiguration($configuration)
            ->withLinkText($linkText);
    }
}
