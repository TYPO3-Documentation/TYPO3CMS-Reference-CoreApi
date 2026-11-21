<?php

declare(strict_types=1);

return [
  \MyVendor\MyExtension\Domain\Model\Conference::class => [
    'recordType' => 'conference',
    'subclasses' => [
      'workshop' => \MyVendor\MyExtension\Domain\Model\Workshop::class,
    ],
  ],
  \MyVendor\MyExtension\Domain\Model\Workshop::class => [
    'tableName' => 'tx_myextension_domain_model_conference',
    'recordType' => 'workshop',
  ],
];
