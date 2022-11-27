<?php

return [
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\LinkHandler\GitHubLinkHandler::class,
        'members' => [
            'linkAttributes',
            'linkParts',
            'view',
            'configuration',
            '__construct',
            'initialize',
            'setView',
        ],
        'targetFileName' => 'ApiOverview/LinkHandling/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerInitialize.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\LinkHandler\GitHubLinkHandler::class,
        'members' => [
            'canHandleLink',
        ],
        'targetFileName' => 'ApiOverview/LinkHandling/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerCanHandleLink.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\LinkHandler\GitHubLinkHandler::class,
        'members' => [
            'formatCurrentUrl',
        ],
        'targetFileName' => 'ApiOverview/LinkHandling/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerFormatCurrentUrl.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\LinkHandler\GitHubLinkHandler::class,
        'members' => [
            'render',
        ],
        'targetFileName' => '/ApiOverview/LinkHandling/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerRender.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Resources/Public/JavaScript/GitHubLinkHandler.js',
        'sourceFile' => 'EXT:examples/Resources/Public/JavaScript/GitHubLinkHandler.js',
        'language' => 'js',
        'targetFileName' => '/ApiOverview/LinkHandling/Tutorials/_CustomLinkBrowser/_CustomLinkHandlerJavaScript.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\LinkHandler\GitHubLinkHandling::class,
        'members' => [
            'baseUrn',
            'asString',
            'resolveHandlerData',
        ],
        'withComment' => false,
        'withClassComment' => true,
        'targetFileName' => '/ApiOverview/LinkHandling/Tutorials/_CustomLinkBrowser/_GitHubLinkHandling.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\LinkHandler\GithubLinkBuilder::class,
        'members' => [
            'TYPE_GITHUB',
            'build',
        ],
        'withComment' => false,
        'withClassComment' => true,
        'targetFileName' => '/ApiOverview/LinkHandling/Tutorials/_CustomLinkBrowser/_GithubLinkBuilder.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/TsConfig/Page/LinkBrowser/GitHubLinkhandler.tsconfig',
        'sourceFile' => 'EXT:examples/Configuration/TsConfig/Page/LinkBrowser/GitHubLinkhandler.tsconfig',
        'language' => 'typoscript',
        'targetFileName' => 'ApiOverview/LinkHandling/Tutorials/_CustomLinkBrowser/_PageTsConfig.rst.txt',
    ],
];
