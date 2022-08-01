<?php

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
        'action'=> 'createPhpClassDocs',
        'class'=> \TYPO3\CMS\Extbase\Persistence\Repository::class,
        'targetFileName'=> 'Extbase/Api/Repository.rst.txt',
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
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Model\Comment::class,
        'members' => [
            'author',
            'content',
            'getAuthor',
            'setAuthor',
            'getContent',
            'setContent',
        ],
        'withComment' => false,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Domain/AbstractEntity.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Model\Tag::class,
        'members' => [
            'name',
            '__construct',
            'getName',
        ],
        'withComment' => false,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Domain/AbstractValueObject.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Repository\BlogRepository::class,
        'members' => [
            'defaultOrderings',
        ],
        'withComment' => false,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Domain/BlogRepository.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Repository\PostRepository::class,
        'members' => [
            'findByTagAndBlog',
            'findAllSortedByCategory',
        ],
        'withComment' => false,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Domain/CustomMethods.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Repository\CommentRepository::class,
        'members' => [
            'initializeObject',
        ],
        'withComment' => false,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Domain/DefaultQuerySettings.rst.txt'
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Repository\CommentRepository::class,
        'members' => [
            'findAllIgnoreEnableFields',
        ],
        'withComment' => false,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Domain/SpecialQuerySettings.rst.txt',
    ],

    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BlogController::class,
        'members' => [
            'newAction'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/View/HtmlResponse.rst.txt',
        'emphasizeLines' => [18],
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BlogController::class,
        'members' => [
            'helloWorldAction'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/View/HtmlResponseCustom.rst.txt',
        'emphasizeLines' => [10],
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BlogController::class,
        'members' => [
            'showBlogAjaxAction'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/View/JsonResponseCustom.rst.txt',
        'emphasizeLines' => [9],
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\PostController::class,
        'members' => [
            'displayRssListAction'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/View/CustomResponse.rst.txt',
        'emphasizeLines' => [17,18,19],
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Validator\TitleValidator::class,
        'members' => [
            'isValid'
        ],
        'targetFileName' => 'Extbase/Validator/PropertyValidator.rst.txt',
        'emphasizeLines' => [8],
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Model\Blog::class,
        'members' => [
            'title'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Validator/PropertyValidatorUsage.rst.txt',
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Domain\Validator\BlogValidator::class,
        'members' => [
            'isValid'
        ],
        'targetFileName' => 'Extbase/Validator/ObjectValidator.rst.txt',
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> \FriendsOfTYPO3\BlogExample\Controller\BlogController::class,
        'members' => [
            'updateAction'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Validator/ObjectValidatorUsage.rst.txt',
    ],
    [
        'action'=> 'createPhpClassCodeSnippet',
        'class'=> FriendsOfTYPO3\BlogExample\Domain\Model\Person::class,
        'members' => [
            'email',
            'firstname',
            'lastname'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'Extbase/Validator/ValidatorWithArgumentUsage.rst.txt',
    ],
];
