<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Html\Event\AfterTransformTextForPersistenceEvent;
use TYPO3\CMS\Core\Html\Event\AfterTransformTextForRichTextEditorEvent;

class TransformListener
{
    /**
     * Transforms the current value the RTE delivered into a value that is stored (persisted) in the database.
     */
    #[AsEventListener('rtehtmlparser/modify-data-for-persistence')]
    public function modifyPersistence(AfterTransformTextForPersistenceEvent $event): void
    {
        $value = $event->getHtmlContent();
        $value = str_replace('TYPO3', '[tag:typo3]', $value);
        $event->setHtmlContent($value);
    }

    /**
     * Transforms the current persisted value into something the RTE can display
     */
    #[AsEventListener('rtehtmlparser/modify-data-for-richtexteditor')]
    public function modifyRichTextEditor(AfterTransformTextForRichTextEditorEvent $event): void
    {
        $value = $event->getHtmlContent();
        $value = str_replace('[tag:typo3]', 'TYPO3', $value);
        $event->setHtmlContent($value);
    }
}
