<?php

return [
    [
        'action' => 'createJsonCodeSnippet',
        'caption' => 'EXT:tea/composer.json',
        'sourceFile' => 'EXT:tea/composer.json',
        'fields' => [
            'name',
            'description',
            'type',
            'authors',
            'homepage',
            'support',
            'require',
            'prefer-stable',
            'autoload',
            '"extra"/"typo3/cms"/"extension-key"',
        ],
        'inlineLevel' => 3,
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/ComposerJsonSimplified.rst.txt',
    ],
    [
        'action' => 'createJsonCodeSnippet',
        'caption' => 'EXT:tea/composer.json, extract',
        'sourceFile' => 'EXT:tea/composer.json',
        'fields' => [
            'name',
            'autoload',
        ],
        'inlineLevel' => 3,
        'emphasize-lines' => 5,
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/ComposerJsonAutoload.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:tea/ext_emconf.php',
        'sourceFile' => 'EXT:tea/ext_emconf.php',
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/ExtEmconf.rst.txt',
    ],
    [
        'action' => 'createPhpArrayCodeSnippet',
        'caption' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'sourceFile' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'fields' => ['ctrl'],
        'showLineNumbers' => true,
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Configuration/TCA/TeaCtrl.rst.txt',
    ],
    [
        'action' => 'createPhpArrayCodeSnippet',
        'caption' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'sourceFile' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'fields' => ['columns/title'],
        'showLineNumbers' => true,
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Configuration/TCA/TeaColumnTitle.rst.txt',
    ],
    [
        'action' => 'createPhpArrayCodeSnippet',
        'caption' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'sourceFile' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'fields' => ['types'],
        'showLineNumbers' => true,
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Configuration/TCA/TeaTypes.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \TTN\Tea\Domain\Model\Product\Tea::class,
        'members' => [
            'title',
            'description',
            'image',
        ],
        'withComment' => true,
        'withClassComment' => true,
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Classes/Domain/Model/TeaProperties.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \TTN\Tea\Domain\Model\Product\Tea::class,
        'members' => [
            'title',
            'getTitle',
            'setTitle',
        ],
        'withComment' => false,
        'withClassComment' => false,
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Classes/Domain/Model/TeaTitle.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \TTN\Tea\Domain\Model\Product\Tea::class,
        'members' => [
            'image',
            'getImage',
            'setImage',
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Classes/Domain/Model/TeaImage.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \TTN\Tea\Domain\Model\Product\Tea::class,
        'members' => [
            'image',
            'getImage',
            'setImage',
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Classes/Domain/Model/TeaImage.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:tea/Classes/Domain/Repository/Product/TeaRepository.php',
        'sourceFile' => 'EXT:tea/Classes/Domain/Repository/Product/TeaRepository.php',
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Classes/Domain/Repository/TeaRepository.rst.txt',
    ],
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:tea/Classes/Domain/Repository/Traits/StoragePageAgnosticTrait.php',
        'sourceFile' => 'EXT:tea/Classes/Domain/Repository/Traits/StoragePageAgnosticTrait.php',
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Classes/Domain/Repository/StoragePageAgnosticTrait.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => TTN\Tea\Controller\TeaController::class,
        'members' => [
            'teaRepository',
            '__construct',
        ],
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Classes/Domain/Repository/InjectRepository.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => TTN\Tea\Controller\TeaController::class,
        'members' => [
            'teaRepository',
            'indexAction',
        ],
        'targetFileName' => 'CodeSnippets/Tutorials/Tea/Classes/Domain/Repository/UseRepository.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => TTN\Tea\Controller\TeaController::class,
        'members' => [
            'showAction',
        ],
        'targetFileName' => '/ExtensionArchitecture/Tutorials/Tea/_Controller/_ShowAction.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => TTN\Tea\Controller\TeaController::class,
        'members' => [
            'teaRepository', '__construct', 'indexAction',
        ],
        'targetFileName' => '/ExtensionArchitecture/Tutorials/Tea/_Controller/_IndexAction.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => TYPO3\CMS\Extbase\Mvc\Controller\ActionController::class,
        'members' => [
            'htmlResponse',
        ],
        'targetFileName' => '/ExtensionArchitecture/Tutorials/Tea/_Controller/_HtmlResponse.rst.txt',
    ],
];
