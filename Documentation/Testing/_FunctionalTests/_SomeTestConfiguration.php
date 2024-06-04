<?php

namespace MyVendor\MyExtension\Tests\Functional;

use Symfony\Component\Mailer\Transport\NullTransport;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case
 */
class SomeTest extends FunctionalTestCase
{
    protected array $configurationToUseInTestInstance = [
        'MAIL' => [
            'transport' => NullTransport::class,
        ],
    ];

    public function testSomething()
    {
        //...
    }
}
