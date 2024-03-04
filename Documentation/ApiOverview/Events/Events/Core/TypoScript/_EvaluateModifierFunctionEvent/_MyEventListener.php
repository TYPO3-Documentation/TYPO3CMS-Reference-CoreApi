<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\TypoScript\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\TypoScript\AST\Event\EvaluateModifierFunctionEvent;

#[AsEventListener(
    identifier: 'my-extension/evaluate-modifier-function',
)]
final readonly class MyEventListener
{
    public function __invoke(EvaluateModifierFunctionEvent $event): void
    {
        if ($event->getFunctionName() === 'myModifierFunction') {
            $originalValue = $event->getOriginalValue();
            $functionArgument = $event->getFunctionArgument();
            // Manipulate values and set new value
            $event->setValue($originalValue . ' example ' . $functionArgument);
        }
    }
}
