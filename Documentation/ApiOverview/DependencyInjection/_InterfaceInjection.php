<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Logger\LoggerInterface;

final class UserController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {}
}
