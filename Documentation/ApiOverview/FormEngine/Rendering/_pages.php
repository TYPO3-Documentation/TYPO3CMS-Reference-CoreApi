<?php

defined('TYPO3') or die();

(static function (): void {
    $langFile = 'my_extension.messages';

    $GLOBALS['TCA']['pages']['columns']['somefield'] = [
        'label' => $langFile . ':pages.somefield',
        'config' => [
            'type' => 'input',
            'eval' => 'int, unique',
            'fieldControl' => [
                'my_fieldControl_identifier' => [
                    'renderType' => 'importDataControl',
                ],
            ],
        ],
    ];
})();
