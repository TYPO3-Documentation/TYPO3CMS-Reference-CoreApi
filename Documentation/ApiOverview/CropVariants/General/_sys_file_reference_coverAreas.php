<?php

$GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config'] = [
  'type' => 'imageManipulation',
  'cropVariants' => [
    'mobile' => [
      'title' => 'ext_key.messages:imageManipulation.mobile',
      'coverAreas' => [
        [
          'x' => 0.05,
          'y' => 0.85,
          'width' => 0.9,
          'height' => 0.1,
        ],
      ],
    ],
  ],
];
