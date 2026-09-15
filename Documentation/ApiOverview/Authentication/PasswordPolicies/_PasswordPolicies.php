<?php

$GLOBALS['TYPO3_CONF_VARS']['SYS']['passwordPolicies']['simple'] = [
  'validators' => [
    CorePasswordValidator::class => [
      'options' => [
        'minimumLength' => 6,
      ],
    ],
  ],
];
