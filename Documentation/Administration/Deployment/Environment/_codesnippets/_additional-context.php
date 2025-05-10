<?php

use TYPO3\CMS\Core\Core\Environment;

defined('TYPO3') or die();

$context       = Environment::getContext();
$baseDirectory = Environment::getConfigPath();
$subContexts   = explode('/', strtolower($context));

// Include a file like system/production.php, system/development.php
// or system/staging.php - depending on the TYPO3_CONTEXT application
// context that is currently active.
if (file_exists($baseDirectory . '/system/' . $subContexts[0] . '.php')) {
    include $baseDirectory . '/system/' . $subContexts[0] . '.php';
}

// ALSO overload an environment-specific configuration, to allow more
// specific environment configuration on top of the "global" application
// context.
if (file_exists($baseDirectory . '/system/environment.php')) {
    include $baseDirectory . '/system/environment.php';
}
