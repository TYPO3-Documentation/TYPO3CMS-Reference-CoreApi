<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service\MyClass;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Log\Channel;

class MyClass
{
    public function __construct(
        #[Channel('security')]
        private readonly LoggerInterface $logger,
    ) {}
}
