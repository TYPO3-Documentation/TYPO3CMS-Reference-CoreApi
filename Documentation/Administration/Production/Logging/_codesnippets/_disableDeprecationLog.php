<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Core\Environment;

// Add this at the very bottom of your system/additional.php
if (Environment::getContext()->isProduction()) {
    unset($GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']);
}
