<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Service\MyServiceInterface;

class MyThirdController
{
    private MyServiceInterface $myService;

    public function injectMyService(MyServiceInterface $myService): void
    {
        $this->myService = $myService;
    }
}
