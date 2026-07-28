<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Persistence\Repository::class,
        'targetFileName' => 'CodeSnippets/Extbase/Api/Repository.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class,
        'targetFileName' => 'CodeSnippets/Extbase/UriBuilder.rst.txt',
        'withCode' => false,
    ],
];
