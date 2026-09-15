<?php

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['processors']['MyNewImageProcessor'] = [
  'className' => \MyVendor\ExtensionName\Resource\Processing\MyNewImageProcessor::class,
  'before' => ['LocalImageProcessor'],
];
