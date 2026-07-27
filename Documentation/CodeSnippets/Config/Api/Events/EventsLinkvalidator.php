<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Linkvalidator\Event\BeforeRecordIsAnalyzedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Linkvalidator\Event\ModifyValidatorTaskEmailEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Linkvalidator/ModifyValidatorTaskEmailEvent.rst.txt',
        'withCode' => false,
    ],
];
