<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

final class MyProcessor implements DataProcessorInterface
{
  public function process(
    ContentObjectRenderer $cObj,
    array $contentObjectConfiguration,
    array $processorConfiguration,
    array $processedData,
  ): array {
    $request = $cObj->getRequest();

    // ...
  }
}
