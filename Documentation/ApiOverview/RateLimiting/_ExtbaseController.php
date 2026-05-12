<?php

declare(strict_types=1);


namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Attribute\RateLimit;

final class MyController extends ActionController
{
    #[RateLimit(
        limit: 5,
        interval: '10 minutes',
        message: 'ratelimit.dosomething'
    )]
    public function doSomethingAction(): ResponseInterface
    {
        return $this->redirect('index');
    }
}
