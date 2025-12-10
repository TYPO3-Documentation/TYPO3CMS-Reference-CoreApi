<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ExampleController extends ActionController
{
    public function initializeView(): void
    {
        $this->view->assignMultiple([
            'site' => $this->request->getAttribute('site'),
        ]);
    }
    public function indexAction(): ResponseInterface
    {
        // Variable '{site}' is automatically available
        return $this->htmlResponse();
    }
}
