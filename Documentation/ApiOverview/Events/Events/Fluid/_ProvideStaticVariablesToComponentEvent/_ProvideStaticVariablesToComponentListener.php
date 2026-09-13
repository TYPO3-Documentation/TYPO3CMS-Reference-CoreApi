<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Fluid\Event\ProvideStaticVariablesToComponentEvent;

#[AsEventListener]
final readonly class ProvideStaticVariablesToComponentListener
{
  public function __invoke(ProvideStaticVariablesToComponentEvent $event): void
  {
    // Provide design tokens to all components in a collection
    if ($event->getComponentCollection()->getNamespace() === 'MyVendor\\MyExtension\\Components') {
      $event->setStaticVariables([
        ...$event->getStaticVariables(),
        'designTokens' => [
          'color1' => '#abcdef',
          'color2' => '#123456',
        ],
      ]);
    }
  }
}
