<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\LinkHandling\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Mvc\Persistence\Event\AfterFormDefinitionLoadedEvent;

#[AsEventListener(
    identifier: 'my-extension/after-form-definition-loaded',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterFormDefinitionLoadedEvent $event): void
    {
        if ($event->getPersistenceIdentifier() === '1:/form_definitions/contact.form.yaml') {
            $formDefinition = $event->getFormDefinition();
            $formDefinition['label'] = 'Some new label';
            $event->setFormDefinition($formDefinition);
        }
    }
}
