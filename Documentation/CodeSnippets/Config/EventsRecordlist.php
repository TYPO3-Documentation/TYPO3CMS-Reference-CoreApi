<?php

return [
    [
        "action" => "createPhpClassDocs",
        "class" => TYPO3\CMS\Recordlist\Event\ModifyRecordListHeaderColumnsEvent::class,
        "targetFileName" => "Events/RecordList/ModifyRecordListHeaderColumnsEvent.rst.txt",
        "withCode" => false
    ],
    [
        "action" => "createPhpClassDocs",
        "class" => TYPO3\CMS\Recordlist\Event\ModifyRecordListRecordActionsEvent::class,
        "targetFileName" => "Events/RecordList/ModifyRecordListRecordActionsEvent.rst.txt",
        "withCode" => false
    ],
    [
        "action" => "createPhpClassDocs",
        "class" => TYPO3\CMS\Recordlist\Event\ModifyRecordListTableActionsEvent::class,
        "targetFileName" => "Events/RecordList/ModifyRecordListTableActionsEvent.rst.txt",
        "withCode" => false
    ],
    [
        "action" => "createPhpClassDocs",
        "class" => TYPO3\CMS\Recordlist\Event\RenderAdditionalContentToRecordListEvent::class,
        "targetFileName" => "Events/RecordList/RenderAdditionalContentToRecordListEvent.rst.txt",
        "withCode" => false
    ],
    // TYPO3 12.0
    [
        "action" => "createPhpClassDocs",
        "class" => TYPO3\CMS\Recordlist\Event\ModifyLinkHandlersEvent::class,
        "targetFileName" => "Events/RecordList/ModifyLinkHandlersEvent.rst.txt",
        "withCode" => false
    ],
    [
        "action" => "createPhpClassDocs",
        "class" => TYPO3\CMS\Recordlist\Event\ModifyAllowedItemsEvent::class,
        "targetFileName" => "Events/RecordList/ModifyAllowedItemsEvent.rst.txt",
        "withCode" => false
    ],
];