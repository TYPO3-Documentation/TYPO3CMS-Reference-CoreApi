<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Fluid\Event\ModifyRenderedContentAreaEvent;

final readonly class WrapRenderedContentAreaListener
{
  #[AsEventListener('my_extension/wrap-rendered-content-area')]
  public function __invoke(ModifyRenderedContentAreaEvent $event): void
  {
    $contentArea = $event->getContentArea();
    if ($contentArea->getRecords() !== []) {
      return;
    }
    // Mark an area that rendered nothing, to find gaps in a layout
    $event->setRenderedContentArea(sprintf(
      '<div class="my-empty-area">%s is empty</div>',
      htmlspecialchars($contentArea->getName()),
    ));
  }
}
