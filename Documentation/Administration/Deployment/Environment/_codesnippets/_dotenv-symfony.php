<?php

use Symfony\Component\Dotenv\Dotenv;
use TYPO3\CMS\Core\Core\Environment;

$dotenv = new Dotenv();
$dotenv->load(Environment::getProjectPath() . '/.env');
