<?php

return [
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/TsConfig/Page/LinkBrowser/HaikuRecordLinkBrowser.tsconfig',
        'sourceFile' => 'EXT:examples/Configuration/TsConfig/Page/LinkBrowser/HaikuRecordLinkBrowser.tsconfig',
        'targetFileName' => 'CodeSnippets/Tutorials/LinkBrowser/Classes/HaikuRecordLinkBrowserTsconfig.rst.txt',
        'language' => 'typoscript',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/TypoScript/RecordLinks/Haiku.typoscript',
        'sourceFile' => 'EXT:examples/Configuration/TypoScript/RecordLinks/Haiku.typoscript',
        'targetFileName' => 'CodeSnippets/Tutorials/LinkBrowser/Classes/HaikuRecordLinkTypoScript.rst.txt',
    ],
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
        'targetFileName' => 'ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerInitialize.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\LinkHandler\GitHubLinkHandler::class,
        'members' => [
            'canHandleLink',
        ],
        'targetFileName' => 'ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerCanHandleLink.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\LinkHandler\GitHubLinkHandler::class,
        'members' => [
            'formatCurrentUrl',
        ],
        'targetFileName' => 'ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerFormatCurrentUrl.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\LinkHandler\GitHubLinkHandler::class,
        'members' => [
            'render',
        ],
        'targetFileName' => '/ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerRender.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Resources/Public/JavaScript/github_link_handler.js',
        'sourceFile' => 'EXT:examples/Resources/Public/JavaScript/github_link_handler.js',
        'language' => 'js',
        'targetFileName' => '/ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_CustomLinkHandlerJavaScript.rst.txt',
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
        'targetFileName' => '/ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GitHubLinkHandling.rst.txt',
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
        'targetFileName' => '/ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GithubLinkBuilder.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/TsConfig/Page/LinkBrowser/GitHubLinkhandler.tsconfig',
        'sourceFile' => 'EXT:examples/Configuration/TsConfig/Page/LinkBrowser/GitHubLinkhandler.tsconfig',
        'language' => 'typoscript',
        'targetFileName' => 'ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_PageTsConfig.rst.txt',
    ],
];
