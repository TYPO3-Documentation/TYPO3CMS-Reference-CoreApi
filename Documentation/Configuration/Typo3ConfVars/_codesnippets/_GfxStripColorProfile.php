<?php

// Before
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileCommand']
    = '+profile \'*\'';

// After
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileParameters'] = [
  '+profile',
  '*',
];
