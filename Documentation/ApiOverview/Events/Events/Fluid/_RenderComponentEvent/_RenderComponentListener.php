<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Fluid\Event\RenderComponentEvent;

#[AsEventListener]
final readonly class RenderComponentListener
{
  public function __construct(private AssetCollector $assetCollector) {}

  public function __invoke(RenderComponentEvent $event): void
  {
    // Add bundled component's CSS if a component is used on the page
    if ($event->getComponentCollection()->getNamespace() === 'MyVendor\\MyExtension\\Components') {
      $this->assetCollector->addStyleSheet(
        'componentsBundle',
        'EXT:my_extension/Resources/Public/ComponentsBundle.css',
      );
    }
  }
}
