<?php

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['processors']['MyNewImageProcessor'] = [
  'className' => \MyVendor\MyExtension\Resource\Processing\MyNewImageProcessor::class,
  'before' => ['LocalImageProcessor'],
];
