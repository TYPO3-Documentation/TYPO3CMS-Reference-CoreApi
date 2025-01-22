<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller\MyController;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class MyController extends ActionController
{
    public function myAction(): ResponseInterface
    {
        $url = $this->uriBuilder
            ->reset()
            ->setTargetPageUid(42)
            ->uriFor(
                'another', // only action name, not `myAction`
                [
                    'myRecord' => 21,
                ],
                'My', // only controller name, not `MyController`
                'myextension',
                'myplugin',
            );

        // do something with $url
    }
}
