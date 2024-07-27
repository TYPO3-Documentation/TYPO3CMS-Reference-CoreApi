<?php

use T3docs\Examples\Controller\AdminModuleController;
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
