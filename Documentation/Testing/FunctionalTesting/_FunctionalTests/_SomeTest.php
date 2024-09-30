<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class SomeTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'workspaces',
    ];

    /**
     * @test
     */
    public function somethingWithWorkspaces(): void
    {
        //...
    }
}
