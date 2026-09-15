<?php

$GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config'] = [
  'type' => 'imageManipulation',
  'cropVariants' => [
    'mobile' => [
      'title' => 'ext_key.messages:imageManipulation.mobile',
      'allowedAspectRatios' => [
        '4:3' => [
          'title' => 'core.wizards:imwizard.ratio.4_3',
          'value' => 4 / 3,
        ],
        'NaN' => [
          'title' => 'core.wizards:imwizard.ratio.free',
          'value' => 0.0,
        ],
      ],
    ],
    'desktop' => [
      'title' => 'ext_key.messages:imageManipulation.desktop',
      'allowedAspectRatios' => [
        '4:3' => [
          'title' => 'core.wizards:imwizard.ratio.4_3',
          'value' => 4 / 3,
        ],
        'NaN' => [
          'title' => 'core.wizards:imwizard.ratio.free',
          'value' => 0.0,
        ],
      ],
    ],
  ],
];
