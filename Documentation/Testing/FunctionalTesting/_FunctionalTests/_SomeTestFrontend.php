<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class SomeTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function somethingWithWorkspaces(): void
    {
        $this->setUpFrontendRootPage(
            1,
            ['EXT:fluid_test/Configuration/TypoScript/Basic.typoscript'],
        );
    }
}
