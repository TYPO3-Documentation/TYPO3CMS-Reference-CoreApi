<?php

declare(strict_types=1);

namespace T3docs\ReferenceCoreApi\Tests\Functional\EventListener;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the listener that transliterates file names, on the page on the
 * SanitizeFileNameEvent. The storage dispatches the event.
 */
final class TransliterateFileNameListenerTest extends FunctionalTestCase
{
  protected array $testExtensionsToLoad = [
    'myvendor/my-extension',
  ];

  public static function fileNameDataProvider(): array
  {
    return [
      'umlaut' => ['Grüße.pdf', 'Gruesse.pdf'],
      'accent' => ['Café menu.pdf', 'Cafe_menu.pdf'],
      'Cyrillic' => ['Москва.jpg', 'Moskva.jpg'],
      'no ASCII equivalent' => ['日本.pdf', '日本.pdf'],
      'already ASCII' => ['report-2026.pdf', 'report-2026.pdf'],
    ];
  }

  #[Test]
  #[DataProvider('fileNameDataProvider')]
  public function storageStoresTheTransliteratedFileName(
    string $fileName,
    string $expected,
  ): void {
    $storage = $this->get(StorageRepository::class)->getDefaultStorage();

    self::assertSame($expected, $storage?->sanitizeFileName($fileName));
  }
}
