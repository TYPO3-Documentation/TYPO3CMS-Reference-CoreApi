<?php

$GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config'] = [
  'type' => 'imageManipulation',
  'cropVariants' => [
    'mobile' => [
      'title' => 'ext_key.messages:imageManipulation.mobile',
      'cropArea' => [
        'x' => 0.1,
        'y' => 0.1,
        'width' => 0.8,
        'height' => 0.8,
      ],
    ],
  ],
];
