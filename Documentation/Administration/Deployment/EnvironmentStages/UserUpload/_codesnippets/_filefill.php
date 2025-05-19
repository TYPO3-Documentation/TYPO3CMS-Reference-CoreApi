<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Core\Environment;

if (Environment::getContext()->isDevelopment()) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['filefill']['storages'][1] = [
        [
            'identifier' => 'domain',
            'configuration' => 'https://example.org',
        ],
        [
            'identifier' => 'placehold',
        ],
    ];
}
