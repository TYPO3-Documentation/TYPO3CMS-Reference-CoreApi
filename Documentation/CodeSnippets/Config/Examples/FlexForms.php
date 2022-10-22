<?php

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

return [
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:styleguide/Configuration/FlexForms/Simple.xml',
        'sourceFile' => 'EXT:styleguide/Configuration/FlexForms/Simple.xml',
        'targetFileName' => 'CodeSnippets/FlexForms/Simple.rst.txt'
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/Flexforms/PluginHaikuList.xml',
        'sourceFile' => 'EXT:examples/Configuration/Flexforms/PluginHaikuList.xml',
        'targetFileName' => 'CodeSnippets/FlexForms/Examples/PluginHaikuList.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'emphasizeLines' => ['23', '24', '25', '26'],
        'caption' => 'EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_haiku_list.php',
        'sourceFile' => 'EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_haiku_list.php',
        'replaceFirstMultilineComment' => true,
        'targetFileName' => 'CodeSnippets/FlexForms/Examples/PluginHaikuListRegistration.rst.txt',
    ],
];