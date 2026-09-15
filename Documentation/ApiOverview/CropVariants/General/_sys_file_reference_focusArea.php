<?php

$GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config'] = [
  'type' => 'imageManipulation',
  'cropVariants' => [
    'mobile' => [
      'title' => 'ext_key.messages:imageManipulation.mobile',
      'focusArea' => [
        'x' => 1 / 3,
        'y' => 1 / 3,
        'width' => 1 / 3,
        'height' => 1 / 3,
      ],
    ],
  ],
];
