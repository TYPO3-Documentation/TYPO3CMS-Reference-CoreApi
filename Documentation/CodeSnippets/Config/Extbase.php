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
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Controllers/BlogControllerNew.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BlogController::class,
        'members' => [
            'updateAction'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Controllers/BlogControllerUpdate.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BackendController::class,
        'members' => [
            'initializeAction'
        ],
        'targetFileName' => 'Extbase/Controllers/BackendControllerInitialize.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Model\Post::class,
        'members' => [
            'comments'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Annotation/Multiple.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Model\Post::class,
        'members' => [
            'relatedPosts'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Annotation/Lazy.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Model\Blog::class,
        'members' => [
            'description'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Annotation/Validate.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BlogController::class,
        'members' => [
            'newAction'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Annotation/IgnoreValidation.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Model\Blog::class,
        'members' => [
            'posts'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Annotation/Cascade.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Model\Person::class,
        'members' => [
            'fullname'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Annotation/Transient.rst.txt'
    ],
];
