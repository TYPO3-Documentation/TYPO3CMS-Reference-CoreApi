<?php

declare(strict_types=1);

return [
  \MyVendor\MyExtension\Domain\Model\FrontendUser::class => [
    'tableName' => 'fe_users',
    'properties' => [
      'firstName' => ['fieldName' => 'first_name'],
    ],
  ],
];
