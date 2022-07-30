<?php

return [
    [
        'action'=> 'createCodeSnippet',
        'caption' => 'EXT:blog_example/Configuration/TypoScript/RssFeed/setup.typoscript',
        'sourceFile'=> 'typo3conf/ext/blog_example/Configuration/TypoScript/RssFeed/setup.typoscript',
        'targetFileName' => 'Extbase/FrontendPlugins/TypoScriptPluginRss.rst.txt'
    ],
    [
        'action'=> 'createPhpClassDocs',
        'class'=> \TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface::class,
        'targetFileName'=> 'Extbase/Api/ValidatorInterface.rst.txt',
        'withCode'=> false
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BlogController::class,
        'members' => [
            'newAction'
        ],
        'withComment' => true,
        'targetFileName' => 'Extbase/FrontendPlugins/BlogControllerNew.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BlogController::class,
        'members' => [
            'updateAction'
        ],
        'withComment' => true,
        'targetFileName' => 'Extbase/FrontendPlugins/BlogControllerUpdate.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BackendController::class,
        'members' => [
            'initializeAction'
        ],
        'targetFileName' => 'Extbase/FrontendPlugins/BackendControllerInitialize.rst.txt'
    ],
];
