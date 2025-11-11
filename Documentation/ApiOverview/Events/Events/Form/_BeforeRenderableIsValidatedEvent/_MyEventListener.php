<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\BeforeRenderableIsValidatedEvent;

final readonly class MyEventListener
{
    #[AsEventListener(
        identifier: 'my-extension/before-renderable-is-validate',
    )]
    public function __invoke(BeforeRenderableIsValidatedEvent $event): void
    {
        $renderable = $event->renderable;
        if ($renderable->getType() !== 'AdvancedPassword') {
            return;
        }

        $elementValue = $event->value;
        if ($elementValue['password'] !== $elementValue['confirmation']) {
            $processingRule = $renderable->getRootForm()->getProcessingRule($renderable->getIdentifier());
            $processingRule->getProcessingMessages()->addError(
                GeneralUtility::makeInstance(
                    Error::class,
                    GeneralUtility::makeInstance(TranslationService::class)->translate('validation.error.1556283177', null, 'EXT:form/Resources/Private/Language/locallang.xlf'),
                    1556283177,
                )
            );
        }
        $event->value = $elementValue['password'];
    }
}
