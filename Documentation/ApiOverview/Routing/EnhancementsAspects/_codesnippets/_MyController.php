<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\MyModel;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class MyController extends ActionController
{
    public function showAction(?MyModel $myModel = null): ResponseInterface
    {
        if ($myModel === null) {
            return $this->redirect('somethingElse');
        }

        return $this->htmlResponse();
    }
}
