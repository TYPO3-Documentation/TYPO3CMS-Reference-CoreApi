<?php

use MyVendor\MyExtension\LoginProvider\CustomLoginProvider;

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders'][1433416020]
  = [
    'provider' => CustomLoginProvider::class,
    'sorting' => 50,
    'iconIdentifier' => 'actions-key',
    'label' => 'backend.messages:login.link',
  ];
