<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\TextExtraction;

use TYPO3\CMS\Core\Attribute\AsTextExtractor;
use TYPO3\CMS\Core\Resource\TextExtraction\ExtractedText;
use TYPO3\CMS\Core\Resource\TextExtraction\StructuredTextExtractorInterface;
use TYPO3\CMS\Core\SystemResource\Type\SystemResourceInterface;

#[AsTextExtractor(priority: 10)]
final class MarkdownTextExtractor implements StructuredTextExtractorInterface
{
  public function getSupportedMimeTypes(): array
  {
    return ['text/markdown'];
  }

  public function extractStructuredText(SystemResourceInterface $resource): ExtractedText
  {
    $markdown = $resource->getContents();
    // The first headline of the document is its title
    preg_match('/^#\s+(.+)$/m', $markdown, $matches);
    return new ExtractedText(
      // Remove the Markdown markup for headlines, emphasis, and code
      text: (string)preg_replace('/[#*_`]+/', '', $markdown),
      title: trim($matches[1] ?? ''),
    );
  }
}
