<?php

defined('TYPO3') or die();

(static function (): void {
    $langFile = 'LLL:EXT:my_extension/Ressources/Private/Language/locallang.xlf';

    $GLOBALS['TCA']['pages']['columns']['somefield'] = [
        'label' => $langFile . ':pages.somefield',
        'config' => [
            'type' => 'input',
            'eval' => 'int, unique',
            'fieldControl' => [
                'my_fieldControl_button' => [
                    'renderType' => 'importDataControl',
                ],
            ],
        ],
    ];
})();
