<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Configuration\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureIdentifierInitializedEvent;
use TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureParsedEvent;
use TYPO3\CMS\Core\Configuration\Event\BeforeFlexFormDataStructureIdentifierInitializedEvent;
use TYPO3\CMS\Core\Configuration\Event\BeforeFlexFormDataStructureParsedEvent;

#[AsEventListener(
    identifier: 'my-extension/set-data-structure',
    method: 'setDataStructure',
)]
#[AsEventListener(
    identifier: 'my-extension/modify-data-structure',
    method: 'modifyDataStructure',
)]
#[AsEventListener(
    identifier: 'my-extension/set-data-structure-identifier',
    method: 'setDataStructureIdentifier',
)]
#[AsEventListener(
    identifier: 'my-extension/modify-data-structure-identifier',
    method: 'modifyDataStructureIdentifier',
)]
final readonly class FlexFormParsingModifyEventListener
{
    public function setDataStructure(BeforeFlexFormDataStructureParsedEvent $event): void
    {
        $identifier = $event->getIdentifier();
        if (($identifier['type'] ?? '') === 'my_custom_type') {
            $event->setDataStructure('FILE:EXT:my_extension/Configuration/FlexForms/MyFlexform.xml');
        }
    }

    public function modifyDataStructure(AfterFlexFormDataStructureParsedEvent $event): void
    {
        $identifier = $event->getIdentifier();
        if (($identifier['type'] ?? '') === 'my_custom_type') {
            $parsedDataStructure = $event->getDataStructure();
            $parsedDataStructure['sheets']['sDEF']['ROOT']['sheetTitle'] = 'Some dynamic custom sheet title';
            $event->setDataStructure($parsedDataStructure);
        }
    }

    public function setDataStructureIdentifier(BeforeFlexFormDataStructureIdentifierInitializedEvent $event): void
    {
        if ($event->getTableName() === 'tx_myextension_domain_model_sometable') {
            $event->setIdentifier([
                'type' => 'my_custom_type',
            ]);
        }
    }

    public function modifyDataStructureIdentifier(AfterFlexFormDataStructureIdentifierInitializedEvent $event): void
    {
        $identifier = $event->getIdentifier();
        if (($identifier['type'] ?? '') === 'some_other_type') {
            $identifier['type'] = 'my_custom_type';
        }
        $event->setIdentifier($identifier);
    }
}
