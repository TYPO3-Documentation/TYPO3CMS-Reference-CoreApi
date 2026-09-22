<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\FileList\EventListener;

use TYPO3\CMS\Backend\Template\Components\ActionGroup;
use TYPO3\CMS\Backend\Template\Components\ComponentFactory;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Filelist\Event\ProcessFileListActionsEvent;

#[AsEventListener(
  identifier: 'my-extension/process-file-list',
)]
final readonly class MyEventListener
{
  public function __construct(
    private ComponentFactory $componentFactory,
    private IconFactory $iconFactory,
  ) {}

  public function __invoke(ProcessFileListActionsEvent $event): void
  {
    if (!$event->isFile()) {
      return;
    }

    // Add a button for files to the secondary actions
    $button = $this->componentFactory->createGenericButton()
        ->setIcon($this->iconFactory->getIcon('actions-heart'))
        ->setTitle('Add to favorites');
    $event->setAction($button, 'myFavorite', ActionGroup::secondary);
  }
}
