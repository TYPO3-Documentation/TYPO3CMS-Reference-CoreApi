<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

#[AsController]
final class MyController extends ActionController
{
  public function __construct(
    protected readonly ModuleTemplateFactory $moduleTemplateFactory,
  ) {}
}
