<?php

defined('TYPO3') or die();

use FriendsOfTYPO3\BlogExample\Controller\CommentController;
use FriendsOfTYPO3\BlogExample\Controller\PostController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::configurePlugin(
    'BlogExample',
    'PostSingle',
    [PostController::class => 'show', CommentController::class => 'create'],
    [CommentController::class => 'create'],
);
