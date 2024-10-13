<?php

declare(strict_types=1);

use FriendsOfTYPO3\BlogExample\Controller\CommentController;
use FriendsOfTYPO3\BlogExample\Controller\PostController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
    'BlogExample',
    // arbitrary, but unique plugin name (not visible in the backend)
    'PostSingle',
    // all actions
    [PostController::class => 'show', CommentController::class => 'create'],
    // non-cacheable actions
    [CommentController::class => 'create'],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);
