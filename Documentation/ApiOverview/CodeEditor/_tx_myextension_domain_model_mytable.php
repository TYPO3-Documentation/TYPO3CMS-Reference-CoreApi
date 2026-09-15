<?php

return [
  // 'ctrl' and the other sections of the TCA definition
  'columns' => [
    // ... other columns
    'codeeditor1' => [
      'label' => 'codeEditor_1 format=html, rows=7',
      'description' => 'field description',
      'config' => [
        'type' => 'text',
        'renderType' => 'codeEditor',
        'format' => 'html',
        'rows' => 7,
      ],
    ],
  ],
];
