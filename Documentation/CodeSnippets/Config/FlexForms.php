<?php

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

return [
    [
        'action'=> 'createCodeSnippet',
        'caption'=> 'EXT:styleguide/Configuration/FlexForms/Simple.xml',
        'sourceFile'=> 'EXT:styleguide/Configuration/FlexForms/Simple.xml',
        'targetFileName'=> 'FlexForms/Simple.rst.txt'
    ],
    [
        'action'=> 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/Flexforms/PluginHaikuList.xml',
        'sourceFile'=> 'EXT:examples/Configuration/Flexforms/PluginHaikuList.xml',
        'targetFileName' => 'FlexForms/Examples/PluginHaikuList.rst.txt',
    ],
    [
        'action'=> 'createCodeSnippet',
        'emphasizeLines' => ['19', '20', '21', '22'],
        'caption' => 'EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_haiku_list.php',
        'sourceFile'=> 'EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_haiku_list.php',
        'targetFileName' => 'FlexForms/Examples/PluginHaikuListRegistration.rst.txt',
    ],
];