<?php

use MyVendor\MyExtension\PasswordPolicy\Generator\MyPasswordGenerator;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']['customGeneratorPolicy'] = [
    'generator' => [
        'className' => MyPasswordGenerator::class,
        'options' => [
            'length' => 32,
        ],
    ],
    'validators' => [
        // Your custom validators
    ],
];

$GLOBALS['TYPO3_CONF_VARS']['BE']['passwordPolicy'] = 'customPolicy';
$GLOBALS['TYPO3_CONF_VARS']['FE']['passwordPolicy'] = 'customPolicy';
