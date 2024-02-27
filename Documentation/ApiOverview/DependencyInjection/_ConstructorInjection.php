<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Repository\UserRepository;

final class UserController
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}
}
