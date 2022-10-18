<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent::class,
        'targetFileName' => 'Events/Frontend/ModifyHrefLangTagsEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Frontend\Authentication\ModifyResolvedFrontendGroupsEvent::class,
        'targetFileName' => 'Events/Frontend/ModifyResolvedFrontendGroupsEvent.rst.txt',
        'withCode' => false
    ],
];