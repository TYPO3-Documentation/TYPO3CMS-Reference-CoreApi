<?php

return [
    [
        "action"=> "createCodeSnippet",
        'caption' => 'EXT:blog_example/Configuration/TypoScript/RssFeed/setup.typoscript',
        'sourceFile'=> 'typo3conf/ext/blog_example/Configuration/TypoScript/RssFeed/setup.typoscript',
        'targetFileName' => 'Extbase/FrontendPlugins/TypoScriptPluginRss.rst.txt'
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface::class,
        "targetFileName"=> "Extbase/Api/ValidatorInterface.rst.txt",
        "withCode"=> false
    ],
];