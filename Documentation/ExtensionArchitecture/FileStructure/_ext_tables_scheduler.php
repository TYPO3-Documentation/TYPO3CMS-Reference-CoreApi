<?php

declare(strict_types=1);

use TYPO3\CMS\Scheduler\Task\CachingFrameworkGarbageCollectionAdditionalFieldProvider;
use TYPO3\CMS\Scheduler\Task\CachingFrameworkGarbageCollectionTask;

defined('TYPO3') or die();

$lll = 'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:';

// Add caching framework garbage collection task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']
        [CachingFrameworkGarbageCollectionTask::class] = [
            'extension' => 'my_extension',
            'title' => $lll . 'cachingFrameworkGarbageCollection.name',
            'description' => $lll . 'cachingFrameworkGarbageCollection.description',
            'additionalFields' =>
                CachingFrameworkGarbageCollectionAdditionalFieldProvider::class,
        ];
