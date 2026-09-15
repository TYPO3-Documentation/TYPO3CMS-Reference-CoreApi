<?php

return [
  'BE' => [
    // ...
    // This pseudo password enables you to load the standalone install
    // tool to be able to generate a new hash value. Change the password
    // at once!
    'installToolPassword' => '$2y$12$AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA',
    'passwordHashing' => [
      'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\BcryptPasswordHash',
      'options' => [],
    ],
  ],
  'FE' => [
    // ...
    'passwordHashing' => [
      'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\BcryptPasswordHash',
      'options' => [],
    ],
  ],
  // ...
];
