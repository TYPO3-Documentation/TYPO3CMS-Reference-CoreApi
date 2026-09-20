<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\Form;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;

final class StatusIconElement extends AbstractFormElement
{
  public function __construct(
    private readonly IconFactory $iconFactory,
  ) {}

  public function render(): array
  {
    $resultArray = $this->initializeResultArray();
    $isActive = (bool)($this->data['databaseRow']['active'] ?? false);
    $identifier = $isActive ? 'actions-check' : 'actions-close';
    $resultArray['html'] = $this->iconFactory
        ->getIcon($identifier, IconSize::SMALL)
        ->render();
    return $resultArray;
  }
}
