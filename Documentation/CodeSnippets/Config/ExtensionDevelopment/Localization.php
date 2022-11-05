<?php

return [
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\Middleware\HaikuSeasonList::class,
        'members' => [
            '__construct',
        ],
        'withComment' => true,
        'withClassComment' => true,
        'targetFileName' => '/ExtensionArchitecture/HowTo/Localization/_php/_LanguageServiceFactoryDI.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\Middleware\HaikuSeasonList::class,
        'members' => [
            'URL_SEGMENT',
            'process',
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => '/ExtensionArchitecture/HowTo/Localization/_php/_ProcessMiddleware.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\Middleware\HaikuSeasonList::class,
        'members' => [
            'SEASONS',
            'TRANSLATION_PATH',
            'getSeasons',
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => '/ExtensionArchitecture/HowTo/Localization/_php/_LanguageServiceSl.rst.txt',
    ],
];
