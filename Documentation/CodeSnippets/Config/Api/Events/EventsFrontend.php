<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Frontend/ModifyHrefLangTagsEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Frontend\Authentication\ModifyResolvedFrontendGroupsEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Frontend/ModifyResolvedFrontendGroupsEvent.rst.txt',
        'withCode' => false
    ],
];