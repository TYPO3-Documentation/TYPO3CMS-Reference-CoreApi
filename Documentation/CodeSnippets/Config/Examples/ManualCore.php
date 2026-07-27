<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Page\AssetCollector::class,
        'targetFileName' => 'CodeSnippets/Manual/Core/AssetCollector.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Site\SiteFinder::class,
        'targetFileName' => 'CodeSnippets/Manual/Core/SiteFinder.rst.txt',
        'withCode' => false,
    ],
];
