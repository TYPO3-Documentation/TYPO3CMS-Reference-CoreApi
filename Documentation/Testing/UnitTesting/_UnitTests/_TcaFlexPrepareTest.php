<?php

namespace TYPO3\CMS\Backend\Tests\Unit\Form\FormDataProvider;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

final class TcaFlexPrepareTest extends UnitTestCase
{
    protected bool $resetSingletonInstances = true;
    protected function setUp(): void
    {
        parent::setUp();
        // Suppress cache foo in xml helpers of GeneralUtility
        $cacheManagerMock =
            $this->createMock(CacheManager::class);
        GeneralUtility::setSingletonInstance(
            CacheManager::class,
            $cacheManagerMock,
        );
        $cacheFrontendMock =
            $this->createMock(FrontendInterface::class);
        $cacheManagerMock
            ->method('getCache')
            ->with(self::anything())
            ->willReturn($cacheFrontendMock);
    }

    #[Test]
    public function addDataKeepsExistingDataStructure(): void
    {
        // Test something
    }
}
