<?php

use MyVendor\MyExtension\Controller\SsoCallbackController;

return [
  // The single sign-on provider calls this route without a TYPO3 session
  'my_sso_callback' => [
    'path' => '/my-extension/sso/callback',
    'access' => 'anonymous',
    'target' => SsoCallbackController::class . '::handleRequest',
  ],
];
