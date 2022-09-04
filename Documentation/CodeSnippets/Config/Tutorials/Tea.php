<?php

return [
    // TODO: Create code-snipperts automatically
    /*
    [
        'action'=> 'createCodeSnippet',
        'caption' => 'EXT:tea/composer.json',
        'sourceFile'=> 'typo3conf/ext/tea/composer.json',
        'targetFileName' => 'Tutorials/Tea/ComposerJson.rst.txt'
    ],
    */
    [
        'action'=> 'createCodeSnippet',
        'caption' => 'EXT:tea/ext_tables.sql',
        'sourceFile'=> 'typo3conf/ext/tea/ext_tables.sql',
        'targetFileName' => 'Tutorials/Tea/ExtTablesSql.rst.txt',
        'language' => 'sql',
    ],
    [
        'action'=> 'createPhpArrayCodeSnippet',
        'caption' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'sourceFile'=> 'typo3conf/ext/tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'fields' => ['ctrl'],
        'showLineNumbers' => true,
        'targetFileName' => 'Tutorials/Tea/Configuration/TCA/TeaCtrl.rst.txt',
    ],
    [
        'action'=> 'createPhpArrayCodeSnippet',
        'caption' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'sourceFile'=> 'typo3conf/ext/tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'fields' => ['columns/title'],
        'showLineNumbers' => true,
        'targetFileName' => 'Tutorials/Tea/Configuration/TCA/TeaColumnTitle.rst.txt',
    ],
    [
        'action'=> 'createPhpArrayCodeSnippet',
        'caption' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'sourceFile'=> 'typo3conf/ext/tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'fields' => ['columns/image'],
        'showLineNumbers' => true,
        'targetFileName' => 'Tutorials/Tea/Configuration/TCA/TeaColumnImage.rst.txt',
    ],
    [
        'action'=> 'createPhpArrayCodeSnippet',
        'caption' => 'EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'sourceFile'=> 'typo3conf/ext/tea/Configuration/TCA/tx_tea_domain_model_product_tea.php',
        'fields' => ['types'],
        'showLineNumbers' => true,
        'targetFileName' => 'Tutorials/Tea/Configuration/TCA/TeaTypes.rst.txt',
    ],
];
