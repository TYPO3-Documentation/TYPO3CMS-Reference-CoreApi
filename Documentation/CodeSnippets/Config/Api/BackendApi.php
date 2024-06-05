<?php

use T3docs\BlogExample\Controller\BackendController;
use TYPO3\CMS\Backend\Template\Components\DocHeaderComponent;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\Module\ModuleInterface::class,
        'targetFileName' => 'CodeSnippets/Manual/Backend/ModuleInterface.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\Module\ModuleProvider::class,
        'targetFileName' => 'CodeSnippets/Manual/Backend/ModuleProvider.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\Preview\PreviewRendererInterface::class,
        'targetFileName' => 'CodeSnippets/Manual/Backend/PreviewRendererInterface.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => ModuleTemplateFactory::class,
        'targetFileName' => 'ApiOverview/Backend/BackendModules/_ModuleTemplateFactory.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => ModuleTemplate::class,
        'targetFileName' => 'ApiOverview/Backend/BackendModules/_ModuleTemplate.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => DocHeaderComponent::class,
        'targetFileName' => 'ApiOverview/Backend/BackendModules/_DocHeaderComponent.rst.txt',
        'withCode' => false,
    ]
];
