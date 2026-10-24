<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\TextExtraction;

use TYPO3\CMS\Core\Attribute\AsTextExtractor;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorInterface;

#[AsTextExtractor(priority: 10)]
final class MarkdownTextExtractor implements TextExtractorInterface
{
  public function canExtractText(FileInterface $file): bool
  {
    return $file->getExtension() === 'md';
  }

  public function extractText(FileInterface $file): string
  {
    // Remove the Markdown markup for headlines, emphasis, and code
    return (string)preg_replace('/[#*_`]+/', '', $file->getContents());
  }
}
