<?php

use TYPO3\CMS\Core\Security\RequestToken;
use TYPO3\CMS\Fluid\View\StandaloneView;

final class MyController
{
    private StandaloneView $view;

    public function showFormAction()
    {
        // creating new request token with scope 'my/process' and hand over to view
        $requestToken = RequestToken::create('my/process');
        $this->view->assign('requestToken', $requestToken);
        // ...
    }

    public function processAction()
    {
        // for the implementation, see below
    }
}
