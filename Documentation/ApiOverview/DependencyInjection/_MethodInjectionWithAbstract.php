<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Logger\Logger;
use MyVendor\MyExtension\Repository\UserRepository;

abstract class AbstractController
{
    protected ?Logger $logger = null;

    public function injectLogger(Logger $logger)
    {
        $this->logger = $logger;
    }
}

final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}
}
