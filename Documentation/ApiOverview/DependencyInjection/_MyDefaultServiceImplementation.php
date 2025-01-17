<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(MyServiceInterface::class)]
class MyDefaultServiceImplementation implements MyServiceInterface
{
    public function foo()
    {
        // do something
    }
}
