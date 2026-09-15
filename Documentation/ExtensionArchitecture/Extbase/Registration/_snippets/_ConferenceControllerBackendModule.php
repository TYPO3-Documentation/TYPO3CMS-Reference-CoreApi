<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
  public function __construct(
    protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    protected readonly ConferenceRepository $conferenceRepository,
  ) {}

  public function indexAction(): ResponseInterface
  {
    $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
    $moduleTemplate->assign(
      'conferences',
      $this->conferenceRepository->findAll(),
    );
    return $moduleTemplate->renderResponse('Conference/Index');
  }
}
