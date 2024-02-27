<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service\MyClass;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Log\Channel;

#[Channel('security')]
class MyClass
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}
}
