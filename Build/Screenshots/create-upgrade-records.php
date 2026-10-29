<?php

declare(strict_types=1);

/*
 * A backend user as an older TYPO3 version left it behind, for the
 * upgrade wizards that have not run yet: the language "default" instead
 * of "en", and the user settings only in the serialized field "uc".
 * create-records.php includes this file after the other screenshots are
 * taken, so the wizards show only in their own screenshot.
 */

use TYPO3\CMS\Backend\Upgrades\UserSettingsMigration;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Upgrades\BackendUserLanguageMigration;

/** @var \Psr\Container\ContainerInterface $container */
$container->get(ConnectionPool::class)->getConnectionForTable('be_users')->update(
    'be_users',
    ['lang' => 'default', 'uc' => serialize([]), 'user_settings' => null],
    ['username' => 'alex.smith'],
);
// The setup marks every wizard as done
foreach ([BackendUserLanguageMigration::class, UserSettingsMigration::class] as $wizard) {
    $container->get(Registry::class)->remove('installUpdate', $wizard);
}
