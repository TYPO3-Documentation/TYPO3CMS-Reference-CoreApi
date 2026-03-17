<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Fluid\Event\ModifyComponentDefinitionEvent;
use TYPO3Fluid\Fluid\Core\Component\ComponentDefinition;
use TYPO3Fluid\Fluid\Core\ViewHelper\ArgumentDefinition;

#[AsEventListener]
final readonly class ModifyComponentDefinitionListener
{
    public function __invoke(ModifyComponentDefinitionEvent $event): void
    {
        // Add required argument to one specific component
        if (
            $event->getNamespace() === 'MyVendor\\MyExtension\\Components' &&
            $event->getComponentDefinition()->getName() === 'myComponent'
        ) {
            $originalDefinition = $event->getComponentDefinition();
            $event->setComponentDefinition(new ComponentDefinition(
                $originalDefinition->getName(),
                [
                    ...$originalDefinition->getArgumentDefinitions(),
                    'myArgument' => new ArgumentDefinition('myArgument', 'string', '', true),
                ],
                $originalDefinition->additionalArgumentsAllowed(),
                $originalDefinition->getAvailableSlots(),
            ));
        }
    }
}