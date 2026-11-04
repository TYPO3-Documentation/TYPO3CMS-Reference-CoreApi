<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\AfterFormDefinitionValidationConfigurationIsBuiltEvent as Event;

final readonly class CustomPropertyPathListener
{
  #[AsEventListener(
    identifier: 'my-extension/custom-property-path',
  )]
  public function __invoke(Event $event): void
  {
    $configuration = $event->getConfiguration();
    $element = $configuration['formElements']['MyCustomElement'] ?? [];
    // Allow the form editor to write a property that a custom
    // inspector editor sets without a "propertyPath"
    $element['additionalPropertyPaths'][] = 'properties.my.custom.property';
    $configuration['formElements']['MyCustomElement'] = $element;
    $event->setConfiguration($configuration);
  }
}
