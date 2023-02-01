<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Country\Country::class,
        'targetFileName' => 'CodeSnippets/Manual/Country/Country.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Country\CountryProvider::class,
        'targetFileName' => 'CodeSnippets/Manual/Country/CountryProvider.rst.txt',
        'withCode' => false,
    ],
];
