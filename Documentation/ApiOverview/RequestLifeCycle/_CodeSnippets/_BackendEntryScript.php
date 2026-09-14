<?php

use TYPO3\CMS\Backend\Http\Application;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;

// Set up the application for the backend
call_user_func(function () {
  $classLoader = require dirname(__DIR__) . '/vendor/autoload.php';
  SystemEnvironmentBuilder::run(1, SystemEnvironmentBuilder::REQUESTTYPE_BE);
  Bootstrap::init($classLoader)->get(Application::class)->run();
});
