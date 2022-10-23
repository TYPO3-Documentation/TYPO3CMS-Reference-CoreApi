<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Filelist\Event\ProcessFileListActionsEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Filelist/ProcessFileListActionsEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Filelist\Event\ModifyEditFileFormDataEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Filelist/ModifyEditFileFormDataEvent.rst.txt',
        'withCode' => false,
    ],
];
