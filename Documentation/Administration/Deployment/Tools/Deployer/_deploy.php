<?php

namespace Deployer;

require_once(__DIR__ . '/vendor/sourcebroker/deployer-loader/autoload.php');

new \SourceBroker\DeployerExtendedTypo3\Loader();

set('repository', 'git@github.com:youraccount/yourproject.git');
set('bin/php', '/home/www/example-project-directory/.bin/php');
set('web_path', 'public/');

host('live')
    ->hostname('production.example.org')
    ->user('deploy')
    ->set('branch', 'main')
    ->set('public_urls', ['https://production.example.org'])
    ->set('deploy_path', '/home/www/example-project-directory/live');
