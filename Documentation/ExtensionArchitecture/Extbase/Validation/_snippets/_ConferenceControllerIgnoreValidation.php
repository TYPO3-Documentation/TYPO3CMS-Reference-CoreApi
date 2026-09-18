<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Attribute\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function newAction(
    #[IgnoreValidation]
    ?Conference $conference = null,
  ): ResponseInterface {
    $this->view->assign('conference', $conference ?? new Conference());
    return $this->htmlResponse();
  }
}
