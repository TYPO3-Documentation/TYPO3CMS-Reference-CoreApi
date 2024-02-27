<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Database\Middleware\UsableForConnectionInterface::class,
        'members' => [
            'canBeUsedForConnection',
        ],
        'targetFileName' => 'CodeSnippets/Manual/Database/UsableForConnectionInterface.rst.txt',
        'withCode' => false,
    ],
];
