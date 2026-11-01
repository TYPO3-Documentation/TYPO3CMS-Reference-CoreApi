<?php

declare(strict_types=1);

/*
 * The records of the screenshots that would change the other ones, so
 * create-records.php includes this file after those are taken:
 *
 * Two users for the screens of multi-factor authentication after the
 * login: m.doe has to set up a provider, t.doe has the time-based
 * one-time password active. As administrators, both may use every
 * provider.
 *
 * A root page whose site depends on a set that does not exist, for the
 * exception page in the frontend.
 *
 * The Admin Panel in the frontend of Camino, for j.doe.
 *
 * The content elements of the example extension, each on a page of its own
 * in Camino, whose site gets the set of the extension.
 */

use TYPO3\CMS\Core\Configuration\SiteConfiguration;
use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\ConnectionPool;

/** @var \Psr\Container\ContainerInterface $container */
/** @var \Closure $process */
$process(['be_users' => [
    'NEWmdoe' => [
        'pid' => 0,
        'username' => 'm.doe',
        'password' => 'Screenshots-2026!',
        'admin' => 1,
        'TSconfig' => 'auth.mfa.required = 1',
        'disable' => 0,
    ],
    'NEWtdoe' => [
        'pid' => 0,
        'username' => 't.doe',
        'password' => 'Screenshots-2026!',
        'admin' => 1,
        'disable' => 0,
    ],
]]);
// DataHandler does not write the field of the providers
$container->get(ConnectionPool::class)
    ->getConnectionForTable('be_users')->update(
        'be_users',
        ['mfa' => json_encode(['totp' => [
            'secret' => 'JBSWY3DPEHPK3PXP',
            'active' => true,
            'name' => '',
            'attempts' => 0,
            'lastUsed' => 0,
        ]])],
        ['username' => 't.doe'],
    );

$dataHandler = $process(['pages' => [
    'NEWbroken' => ['pid' => 0, 'title' => 'Broken site', 'is_siteroot' => 1, 'hidden' => 0],
]]);
$container->get(SiteWriter::class)->write('broken', [
    'rootPageId' => $dataHandler->substNEWwithIDs['NEWbroken'],
    'base' => '/broken/',
    'dependencies' => ['my-vendor/my-site-package'],
    'languages' => [[
        'title' => 'English',
        'enabled' => true,
        'languageId' => 0,
        'base' => '/',
        'locale' => 'en_US.UTF-8',
    ]],
]);

$container->get(ConnectionPool::class)->getConnectionForTable('be_users')->update(
    'be_users',
    ['TSconfig' => 'admPanel.enable.all = 1'],
    ['username' => 'j.doe'],
);
file_put_contents(
    Environment::getConfigPath() . '/sites/camino/setup.typoscript',
    "config.admPanel = 1\n",
);

$process([
    'pages' => [
        'NEWbasic' => ['pid' => 1, 'title' => 'Basic content', 'slug' => '/basic-content', 'hidden' => 0],
        'NEWcsv' => ['pid' => 1, 'title' => 'Table from CSV', 'slug' => '/table-from-csv', 'hidden' => 0],
    ],
    'tt_content' => [
        'NEWbasiccontent' => [
            'pid' => 'NEWbasic',
            'colPos' => 0,
            'CType' => 'myextension_basiccontent',
            'header' => 'Basic content',
            'bodytext' => 'Your <strong>text</strong> goes here …',
        ],
        'NEWcsvcontent' => [
            'pid' => 'NEWcsv',
            'colPos' => 0,
            'CType' => 'myextension_newcontentcsv',
            'header' => 'Table from CSV',
            'bodytext' => "1;2;3\n4;5;6\n7;8;9",
            'myextension_separator' => ';',
            'imagecols' => 3,
        ],
    ],
]);
$configuration = $container->get(SiteConfiguration::class)->load('camino');
$configuration['dependencies'][] = 'myvendor/my-extension';
$container->get(SiteWriter::class)->write('camino', $configuration);
