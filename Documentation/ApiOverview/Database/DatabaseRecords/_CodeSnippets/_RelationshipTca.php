<?php

declare(strict_types=1);

return [
  'ctrl' => [
    // ...
  ],
  'columns' => [
    // ...
    'author' => [
      'label' => 'Author',
      'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'foreign_table' => 'tx_myextension_domain_model_author',
        // {item.author} contains one record instead of a collection
        'relationship' => 'manyToOne',
      ],
    ],
  ],
];
