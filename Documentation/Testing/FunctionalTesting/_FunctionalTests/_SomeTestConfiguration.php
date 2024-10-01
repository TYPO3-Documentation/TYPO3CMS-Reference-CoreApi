<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Tests\Functional;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Mailer\Transport\NullTransport;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class SomeTest extends FunctionalTestCase
{
    protected array $configurationToUseInTestInstance = [
        'MAIL' => [
            'transport' => NullTransport::class,
        ],
    ];

    #[Test]
    public function something(): void
    {
        //...
    }
}
