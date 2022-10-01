<?php

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

return [
    [
        'action'=> 'createCodeSnippet',
        'caption' => 'EXT:felogin/Configuration/FlexForms/Login.xml',
        'sourceFile'=> 'typo3/sysext/felogin/Configuration/FlexForms/Login.xml',
        'targetFileName' => 'FlexForms/FeLogin.rst.txt'
    ],
    [
        'action'=> 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/Flexforms/PluginHaikuList.xml',
        'sourceFile'=> 'EXT:examples/Configuration/Flexforms/PluginHaikuList.xml',
        'targetFileName' => 'FlexForms/Examples/PluginHaikuList.rst.txt'
    ],
    [
        'action'=> 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_haiku_list.php',
        'sourceFile'=> 'EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_haiku_list.php',
        'targetFileName' => 'FlexForms/Examples/PluginHaikuListRegistration.rst.txt'
    ],
];