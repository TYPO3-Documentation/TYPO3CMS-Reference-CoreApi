<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Search;

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorRegistry;

final readonly class FileContentIndexer
{
  public function __construct(
    private TextExtractorRegistry $textExtractorRegistry,
  ) {}

  public function getIndexableText(FileInterface $file): string
  {
    $textExtractor = $this->textExtractorRegistry->getTextExtractor($file);
    if ($textExtractor === null) {
      return '';
    }
    return $textExtractor->extractText($file);
  }
}
