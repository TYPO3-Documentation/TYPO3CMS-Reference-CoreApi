<?php

$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash'] = [
  'excludedParameters' => [
    'utm_source',
    'utm_medium',
  ],
  'excludedParametersIfEmpty' => [
    '^tx_myextension_myplugin[aspects]',
    'tx_myextension_myplugin[filter]',
  ],
];
