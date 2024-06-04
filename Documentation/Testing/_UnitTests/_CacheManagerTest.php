<?php

namespace TYPO3\CMS\Core\Tests\Unit\Cache;

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheGroupException;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class CacheManagerTest extends UnitTestCase
{
    /**
     * @test
     */
    public function flushCachesInGroupThrowsExceptionForNonExistingGroup()
    {
        $this->expectException(NoSuchCacheGroupException::class);
        $this->expectExceptionCode(1390334120);
        $subject = new CacheManager();
        $subject->flushCachesInGroup('nonExistingGroup');
    }
}
