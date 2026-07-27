<?php

use FriendsOfTYPO3\BlogExample\Controller\PostController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

// RSS Feed
ExtensionUtility::configurePlugin(
    'blog_post',
    'PostListRss',
    [PostController::class => 'displayRssList'],
);
