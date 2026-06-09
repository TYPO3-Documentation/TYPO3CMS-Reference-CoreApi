<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyNewRecordCreationLinksEvent;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;

final readonly class CustomizeNewRecordWizardEventListener
{
    public function __construct(
        private IconFactory $iconFactory,
        private UriBuilder $uriBuilder,
    ) {}

    #[AsEventListener]
    public function __invoke(ModifyNewRecordCreationLinksEvent $event): void
    {
        // Add a custom creation group
        $customGroup = [
            'title' => 'Custom Records',
            'icon' => $this->iconFactory->getIcon('apps-pagetree-category')->render(),
            'items' => [
                'tx_myext_domain_model_item' => [
                    'url' => (string)$this->uriBuilder->buildUriFromRoute('record_edit', [
                        'edit' => ['tx_myext_domain_model_item' => [$event->pageId => 'new']],
                        'returnUrl' => $event->request->getAttribute('normalizedParams')->getRequestUri(),
                    ]),
                    'icon' => $this->iconFactory->getIconForRecord('tx_myext_domain_model_item', []),
                    'label' => 'Custom Item',
                ],
            ],
        ];

        // Add the custom group to the existing structure
        $event->groupedCreationLinks['custom'] = $customGroup;

        // Modify existing groups - for example, remove specific items
        if (isset($event->groupedCreationLinks['system']['items']['sys_template'])) {
            unset($event->groupedCreationLinks['system']['items']['sys_template']);
        }

        // Add custom types to an existing table
        if (isset($event->groupedCreationLinks['content']['items']['sys_note'])) {
            $event->groupedCreationLinks['content']['items']['sys_note']['types'] = [
                'important' => [
                    'url' => (string)$this->uriBuilder->buildUriFromRoute('record_edit', [
                        'edit' => ['sys_note' => [$event->pageId => 'new']],
                        'defVals' => ['sys_note' => ['category' => '1']],
                        'returnUrl' => $event->request->getAttribute('normalizedParams')->getRequestUri(),
                    ]),
                    'icon' => $this->iconFactory->getIcon('status-dialog-warning', IconSize::SMALL),
                    'label' => 'Important Note',
                ],
                'info' => [
                    'url' => (string)$this->uriBuilder->buildUriFromRoute('record_edit', [
                        'edit' => ['sys_note' => [$event->pageId => 'new']],
                        'defVals' => ['sys_note' => ['category' => '0']],
                        'returnUrl' => $event->request->getAttribute('normalizedParams')->getRequestUri(),
                    ]),
                    'icon' => $this->iconFactory->getIcon('status-dialog-information', IconSize::SMALL),
                    'label' => 'Information Note',
                ],
            ];
        }
    }
}
