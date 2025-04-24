<?php

defined('TYPO3') || die();

// Other settings

$file = realpath(__DIR__) . '/credentials.php';
if (is_file($file)) {
    include_once($file);
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
}
