<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Form\Event\CustomFileSelectorsEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/custom-file-selector',
)]
final readonly class MyEventListener
{
    public function __construct(
        private CustomDamFileSelector $damFileSelector,
    ) {}

    public function __invoke(CustomFileSelectorsEvent $event): void
    {
        $result = $this->damFileSelector->renderFileSelector(
            $event->getFormFieldIdentifier(),
        );
        $event->setSelectors(array_merge(
            $event->getSelectors(),
            $result['control'],
        ));
        $event->setJavascriptModules(array_merge(
            $event->getJavascriptModules(),
            $result['javaScriptModule'],
        ));
    }
}
