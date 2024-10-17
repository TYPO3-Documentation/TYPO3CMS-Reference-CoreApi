<?php

declare(strict_types=1);

use FriendsOfTYPO3\BlogExample\Controller\PostController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

// RSS feed
ExtensionUtility::configurePlugin(
    'BlogExample',
    'PostListRss',
    [PostController::class => 'displayRssList'],
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);
