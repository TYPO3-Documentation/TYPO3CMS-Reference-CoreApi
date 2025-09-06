<?php

use MyVendor\MySitepackage\PageTitle\MyOwnPageTitleProvider;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class SomeController extends ActionController
{
    public function __construct(
        private readonly MyOwnPageTitleProvider $titleProvider,
    ) {}

    public function someAction(): ResponseInterface
    {
        $this->titleProvider->setTitle('Title from controller action');
        // do something
        return $this->htmlResponse();
    }
}
