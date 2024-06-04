<?php

namespace MyVendor\MyExtension\Tests\Unit;

use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class SomeTest extends UnitTestCase
{
    public function testSomething(): void
    {
        $iconFactory =
            $this->createMock(IconFactory::class);
        GeneralUtility::addInstance(IconFactory::class, $iconFactory);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
        parent::tearDown();
    }
}
