<?php

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

return [
    [
        'action'=> 'createJsonCodeSnippet',
        'caption' => 'EXT:tea/composer.json',
        'sourceFile'=> 'EXT:tea/composer.json',
        'fields' => [
            'name',
            'description',
            'type',
            'authors',
            'homepage',
            'support',
            'require',
            'prefer-stable',
            'autoload',
            '"extra"/"typo3/cms"/"extension-key"',
        ],
        'inlineLevel' => 3,
        'targetFileName' => 'Tutorials/Tea/ComposerJsonSimplified.rst.txt'
    ],
    [
        'action'=> 'createJsonCodeSnippet',
        'caption' => 'EXT:tea/composer.json, extract',
        'sourceFile'=> 'EXT:tea/composer.json',
        'fields' => [
            'name',
            'autoload',
        ],
        'inlineLevel' => 3,
        'emphasize-lines' => 5,
        'targetFileName' => 'Tutorials/Tea/ComposerJsonAutoload.rst.txt'
    ],
    [
        'action'=> 'createCodeSnippet',
        'caption' => 'EXT:tea/ext_emconf.php',
        'sourceFile'=> 'EXT:tea/ext_emconf.php',
        'targetFileName' => 'Tutorials/Tea/ExtEmconf.rst.txt'
    ],
];
