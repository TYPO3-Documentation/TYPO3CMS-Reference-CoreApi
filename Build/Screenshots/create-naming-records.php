<?php

declare(strict_types=1);

/*
 * The users and groups of the recommendations on naming in the chapter on
 * permissions management. create-records.php includes this file when the
 * other screenshots are taken, so these names show only in their own
 * screenshots. The users and groups of Camino do not follow the
 * conventions, so they are deleted.
 *
 * Generic accounts are disabled, accounts of a person are enabled, so the
 * filter of the module shows one kind or the other.
 */

use TYPO3\CMS\Core\Database\ConnectionPool;

/** @var \Psr\Container\ContainerInterface $container */
/** @var \Closure $process */
$connectionPool = $container->get(ConnectionPool::class);
foreach (['be_users' => ['a.doe', 'e.doe'], 'be_groups' => ['Editor', 'Advanced Editor']] as $table => $names) {
    $field = $table === 'be_users' ? 'username' : 'title';
    foreach ($names as $name) {
        $connectionPool->getConnectionForTable($table)->update($table, ['deleted' => 1], [$field => $name]);
    }
}

$groups = [
    'R_editor', 'R_editor_advanced', 'R_proofreader',
    'PG_website_a', 'PG_website_b',
    'DBM_website_a', 'DBM_website_b',
    'FM_website_a', 'FM_shared',
    'FO_all', 'FO_read_write',
    'CM_website_a', 'CM_website_b',
    'ACL_content_elements', 'ACL_module_reports', 'ACL_news', 'ACL_news_extended',
    'L_all',
];
$data = ['be_groups' => []];
foreach ($groups as $title) {
    $data['be_groups']['NEW' . $title] = ['pid' => 0, 'title' => $title];
}
$dataHandler = $process($data);
$group = static fn(string $title): string => (string)$dataHandler->substNEWwithIDs['NEW' . $title];

$users = [
    'editor' => ['R_editor', 1],
    'proofreader' => ['R_proofreader', 1],
    'webmaster' => ['R_editor_advanced', 1],
    'alex.smith' => ['R_editor', 0],
    'john.doe' => ['R_proofreader', 0],
    'samantha.jones@example.org' => ['R_editor_advanced', 0],
];
$data = ['be_users' => []];
foreach ($users as $username => [$role, $disable]) {
    $data['be_users']['NEW' . md5($username)] = [
        'pid' => 0,
        'username' => $username,
        'password' => 'Screenshots-2026!',
        'usergroup' => $group($role),
        'disable' => $disable,
    ];
}
$process($data);
