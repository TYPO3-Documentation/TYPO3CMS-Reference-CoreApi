<?php

use Dotenv\Dotenv;
use TYPO3\CMS\Core\Core\Environment;

defined('TYPO3') or die();

$dotenv = Dotenv::createUnsafeImmutable(Environment::getProjectPath());
$dotenv->load();
