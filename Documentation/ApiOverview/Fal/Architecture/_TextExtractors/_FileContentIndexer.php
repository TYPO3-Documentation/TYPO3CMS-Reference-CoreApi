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
    $extractedText = $this->textExtractorRegistry->extract($file);
    if ($extractedText === null) {
      return '';
    }
    return trim($extractedText->title . "\n" . $extractedText->text);
  }
}
