<?php

use TYPO3\CMS\Core\Information\Typo3Version;

// ...

$typo3Version = new Typo3Version();
if ($typo3Version->getMajorVersion() > 11) {
    $this->pageRenderer->loadJavaScriptModule(
        '@vendor/my-extension/my-example.js'
    );
} else {
    // keep RequireJs for TYPO3 below v12.0
    $this->pageRenderer->loadRequireJsModule(
        'TYPO3/CMS/MyExtension/MyExample'
    );
}
