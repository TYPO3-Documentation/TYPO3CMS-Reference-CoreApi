<?php

use Psr\Http\Message\ResponseInterface;
use TTN\Tea\Domain\Model\Product\Tea;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class TeaController extends ActionController
{
  public function showAction(Tea $tea): ResponseInterface
  {
    $this->view->assign('tea', $tea);
    return $this->htmlResponse();
  }
}
