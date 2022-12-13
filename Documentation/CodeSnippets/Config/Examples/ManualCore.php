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
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Classes/Http/MeowInformationRequester.php',
        'sourceFile' => 'EXT:examples/Classes/Http/MeowInformationRequester.php',
        'replaceFirstMultilineComment' => true,
        'targetFileName' => 'CodeSnippets/Examples/Http/MeowInformationRequester.rst.txt',
    ],
];
