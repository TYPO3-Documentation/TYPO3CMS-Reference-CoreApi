<?php

$GLOBALS['TYPO3_CONF_VARS']['SYS']['rateLimiter']['login-be'] = [
  'limit' => 3,
  'interval' => '5 minutes',
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['rateLimiter']['backend-password-recovery']
    = [
      'limit' => 1,
      'interval' => '1 hour',
    ];
