<?php

use TYPO3\CMS\Core\PasswordPolicy\Validator\CorePasswordValidator;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']['simple'] = [
  'validators' => [
    CorePasswordValidator::class => [
      'options' => [
        'minimumLength' => 6,
      ],
    ],
  ],
];
