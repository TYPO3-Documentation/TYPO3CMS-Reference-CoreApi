<?php

$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash'] = [
  'excludedParameters' => [
    'utm_source',
    'utm_medium',
  ],
  'excludedParametersIfEmpty' => [
    '^tx_my_plugin[aspects]',
    'tx_my_plugin[filter]',
  ],
];
