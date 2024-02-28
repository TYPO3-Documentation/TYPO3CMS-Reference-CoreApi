<?php

use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

return [
    'my/addon' => [
        'module' => JavaScriptModuleInstruction::create(
            '@codemirror/addon',
            'addon',
        )->invoke(),
        'cssFiles' => [
            'EXT:my_extension/Resources/Public/Css/MyAddon.css',
        ],
        'options' => ['foobar' => 'baz'],
    ],
    'modes' => ['htmlmixed', 'xml'],
];
