<?php

return [
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:styleguide/Configuration/FlexForms/Simple.xml',
        'sourceFile' => 'EXT:styleguide/Configuration/FlexForms/Simple.xml',
        'targetFileName' => 'CodeSnippets/FlexForms/Simple.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/Flexforms/PluginHaikuList.xml',
        'sourceFile' => 'EXT:examples/Configuration/Flexforms/PluginHaikuList.xml',
        'targetFileName' => 'CodeSnippets/FlexForms/Examples/PluginHaikuList.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'emphasizeLines' => ['19', '20', '21', '22'],
        'caption' => 'EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_haiku_list.php',
        'sourceFile' => 'EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_haiku_list.php',
        'targetFileName' => 'CodeSnippets/FlexForms/Examples/PluginHaikuListRegistration.rst.txt',
    ],
];
