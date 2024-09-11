<?php

use TYPO3\CMS\Core\Security\RequestToken;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;

final class MyController
{
    public function __construct(
        private readonly ViewFactoryInterface $viewFactory,
    ) {}

    public function showFormAction()
    {
        $view = $this->viewFactory->create(new ViewFactoryData(/* ... */));
        // creating new request token with scope 'my/process' and hand over to view
        $requestToken = RequestToken::create('my/process');
        $view->assign('requestToken', $requestToken);
        // ...
    }

    public function processAction()
    {
        // for the implementation, see below
    }
}
