<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Resource\Rendering;

use TYPO3\CMS\Core\Attribute\AsFileRenderer;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\Rendering\FileRendererInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[AsFileRenderer(priority: 10)]
final class PdfRenderer implements FileRendererInterface
{
  public function canRender(FileInterface $file): bool
  {
    return $file->getMimeType() === 'application/pdf';
  }

  public function render(
    FileInterface $file,
    int|string $width,
    int|string $height,
    array $options = [],
  ): string {
    // Width and height can carry a suffix like "m" or "c", the iframe
    // takes the number only. An empty value leaves out the attribute.
    $attributes = [
      'src' => $file->getPublicUrl(),
      'title' => $options['title'] ?? $file->getName(),
      'width' => (int)$width ?: null,
      'height' => (int)$height ?: null,
    ];
    return '<iframe ' . GeneralUtility::implodeAttributes($attributes, true)
      . '></iframe>';
  }
}
