<?php

use TYPO3\CMS\Core\PasswordPolicy\Generator\PasswordGenerator;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']['default']['generator'] = [
    'className' => PasswordGenerator::class,
    'options' => [
        'length' => 12,
        'upperCaseCharacters' => true,
        'lowerCaseCharacters' => true,
        'digitCharacters' => true,
        'specialCharacters' => true,
    ],
];
