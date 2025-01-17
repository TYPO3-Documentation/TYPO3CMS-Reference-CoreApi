<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Service\MyServiceInterface;

class MyFirstController
{
    public function __construct(
        private readonly MyServiceInterface $myService,
    ) {}
}
