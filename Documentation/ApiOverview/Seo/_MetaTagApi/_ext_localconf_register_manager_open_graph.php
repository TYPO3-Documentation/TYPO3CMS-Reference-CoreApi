<?php

declare(strict_types=1);

use Some\CustomExtension\MetaTag\MyOpenGraphMetaTagManager;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

$metaTagManagerRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);
$metaTagManagerRegistry->registerManager(
    'myOwnOpenGraphManager',
    MyOpenGraphMetaTagManager::class,
    ['opengraph'],
);
