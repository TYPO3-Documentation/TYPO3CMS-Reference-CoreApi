<?php

use T3docs\BlogExample\Controller\BackendController;
use T3docs\Examples\Controller\AdminModuleController;
use T3docs\Examples\Controller\ModuleController;
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
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => BackendController::class,
        'members' => [
            'initializeModuleTemplate',
            'showPostAction',
        ],
        'withComment' => false,
        'withClassComment' => false,
        'targetFileName' => 'ApiOverview/Backend/BackendModules/_InitializeModuleTemplate.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => BackendController::class,
        'members' => [
            'modifyDocHeaderComponent',
            'initializeModuleTemplate',
        ],
        'withComment' => false,
        'withClassComment' => false,
        'targetFileName' => 'ApiOverview/Backend/BackendModules/_ModifyDocHeaderComponent.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Resources/Private/Partials/Module/CreateHaikuBlankLink.html',
        'sourceFile' => 'EXT:examples/Resources/Private/Partials/Module/CreateHaikuBlankLink.html',
        'targetFileName' => 'ApiOverview/Backend/_UriBuilder/_CreateHaikuBlankLink.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => ModuleController::class,
        'members' => [
            'getCreateHaikuLink',
        ],
        'targetFileName' => 'ApiOverview/Backend/_UriBuilder/_CreateHaikuLinkPhp.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Resources/Private/Partials/Module/CreateHaikuLink.html',
        'sourceFile' => 'EXT:examples/Resources/Private/Partials/Module/CreateHaikuLink.html',
        'targetFileName' => 'ApiOverview/Backend/_UriBuilder/_CreateHaikuLink.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => ModuleController::class,
        'members' => [
            'getEditDoktypeLink',
        ],
        'targetFileName' => 'ApiOverview/Backend/_UriBuilder/_GetEditDoktypeLink.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => ModuleController::class,
        'members' => [
            'linksAction',
            'getEditPageLink',
            '__construct',
        ],
        'targetFileName' => 'ApiOverview/Backend/_UriBuilder/_LinksAction.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Configuration/Backend/Modules.php',
        'sourceFile' => 'EXT:examples/Configuration/Backend/Modules.php',
        'targetFileName' => 'ExtensionArchitecture/HowTo/BackendModule/_ModuleConfiguration/_Modules.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => AdminModuleController::class,
        'members' => [
            '__construct',
        ],
        'targetFileName' => 'ExtensionArchitecture/HowTo/BackendModule/_ModuleConfiguration/_AdminModuleControllerConstruct.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => AdminModuleController::class,
        'members' => [
            'handleRequest',
        ],
        'targetFileName' => 'ExtensionArchitecture/HowTo/BackendModule/_ModuleConfiguration/_AdminModuleControllerHandleRequest.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => AdminModuleController::class,
        'members' => [
            'debugAction',
        ],
        'targetFileName' => 'ExtensionArchitecture/HowTo/BackendModule/_ModuleConfiguration/_AdminModuleControllerDebugAction.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => AdminModuleController::class,
        'members' => [
            'setUpDocHeader',
        ],
        'targetFileName' => 'ExtensionArchitecture/HowTo/BackendModule/_ModuleConfiguration/_AdminModuleControllerSetUpDocHeader.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Resources/Private/Templates/AdminModule/Debug.html',
        'sourceFile' => 'EXT:examples/Resources/Private/Templates/AdminModule/Debug.html',
        'targetFileName' => 'ExtensionArchitecture/HowTo/BackendModule/_ModuleConfiguration/_DebugHtml.rst.txt',
    ],
];
