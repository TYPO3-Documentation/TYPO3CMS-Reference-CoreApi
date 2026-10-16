<?php

namespace TYPO3\CMS\Core\Tests\Unit\LinkHandling;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\LinkHandling\FolderLinkHandler;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

final class FolderLinkHandlerTest extends UnitTestCase
{
  protected bool $resetSingletonInstances = true;

  #[Test]
  public function resolveHandlerDataReturnsFolder(): void
  {
    $storage = self::createStub(ResourceStorage::class);
    $folder = new Folder($storage, '/images/', '/images/');
    $factory = $this->createMock(ResourceFactory::class);
    $factory->method('getFolderObjectFromCombinedIdentifier')
      ->with('1:/images/')
      ->willReturn($folder);
    // FolderLinkHandler fetches the factory with makeInstance()
    GeneralUtility::setSingletonInstance(ResourceFactory::class, $factory);

    $subject = new FolderLinkHandler();

    $data = ['storage' => '1', 'identifier' => '/images/'];
    self::assertSame(
      ['folder' => $folder],
      $subject->resolveHandlerData($data),
    );
  }
}
