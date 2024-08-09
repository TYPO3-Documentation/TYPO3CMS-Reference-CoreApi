<?php

defined('TYPO3') or die();

use T3docs\BlogExample\Controller\BlogController;
use T3docs\BlogExample\Controller\CommentController;
use T3docs\BlogExample\Controller\PostController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::configurePlugin(
    'BlogExample',
    'PostSingle',
    [
        PostController::class => 'show',
        CommentController::class => 'create',
        BlogController::class => 'index',
    ],
    [
        // Non-cached actions
        CommentController::class => 'create',
    ],
);

// ...
