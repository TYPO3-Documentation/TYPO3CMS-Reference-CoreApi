<?php
// included in All.php

return [
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/TypoScript/DataProcessors/Processors/CustomCategoryProcessor.typoscript',
        'sourceFile' => 'EXT:examples/Configuration/TypoScript/DataProcessors/Processors/CustomCategoryProcessor.typoscript',
        'targetFileName' => 'CodeSnippets/DataProcessing/CustomCategoryProcessorTypoScript.rst.txt'
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Classes/DataProcessing/CustomCategoryProcessor.php',
        'sourceFile' => 'EXT:examples/Classes/DataProcessing/CustomCategoryProcessor.php',
        'replaceFirstMultilineComment' => true,
        'targetFileName' => 'CodeSnippets/DataProcessing/CustomCategoryProcessor.rst.txt',
    ],
];