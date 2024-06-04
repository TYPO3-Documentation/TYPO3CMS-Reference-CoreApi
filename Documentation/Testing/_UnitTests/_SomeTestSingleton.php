<?php

namespace MyVendor\MyExtension\Tests\Unit;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\EnvironmentService;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class SomeTest extends UnitTestCase
{
    public function testSomething(): void
    {
        // Todo: EnvironmentService was deprecated with v11, find another example
        $environmentServiceMock = $this->prophesize(EnvironmentService::class);
        GeneralUtility::setSingletonInstance(EnvironmentService::class, $environmentServiceMock);
    }
}
