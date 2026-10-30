<?php

declare(strict_types=1);

/*
 * Adds the records that the screenshots show to the demo site of the
 * Camino theme, like in the Editors Tutorial: Spanish and Arabic, which is
 * written from right to left, error pages, a second root page with the
 * site configuration that TYPO3 creates for it, a third root page without
 * a site configuration, the backend users, groups, and file mounts of the
 * chapter on user management, and categories of the regions that the
 * routes of Camino lead through.
 *
 * Runs after "typo3 setup" and "typo3 extension:setup".
 */

use TYPO3\CMS\Core\Authentication\CommandLineUserAuthentication;
use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$classLoader = require __DIR__ . '/../../.Build/vendor/autoload.php';
SystemEnvironmentBuilder::run(0, SystemEnvironmentBuilder::REQUESTTYPE_CLI);
$container = Bootstrap::init($classLoader);
Bootstrap::initializeBackendUser(CommandLineUserAuthentication::class);
$GLOBALS['BE_USER']->authenticate();
$GLOBALS['LANG'] = $container->get(LanguageServiceFactory::class)
    ->createFromUserPreferences($GLOBALS['BE_USER']);

$process = static function (array $data): DataHandler {
    $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
    $dataHandler->start($data, []);
    $dataHandler->process_datamap();
    if ($dataHandler->errorLog !== []) {
        throw new RuntimeException(implode("\n", $dataHandler->errorLog));
    }
    return $dataHandler;
};

// With the argument "naming", adds the users and groups of the naming
// conventions instead, once the other screenshots are taken
if (($argv[1] ?? '') === 'naming') {
    require __DIR__ . '/create-naming-records.php';
    exit;
}
// With the argument "upgrade", adds the data of the upgrade wizards that
// have not run yet, once the screenshots of the naming conventions are taken
if (($argv[1] ?? '') === 'upgrade') {
    require __DIR__ . '/create-upgrade-records.php';
    exit;
}

// The error pages below the root page "Camino", after its last page
// "Footer navigation" (uid 2), and two more root pages, for which TYPO3
// creates a site configuration
$dataHandler = $process(['pages' => [
    'NEWforbidden' => ['pid' => -2, 'title' => 'Access denied'],
    'NEWnotFound' => ['pid' => -2, 'title' => 'Page not found'],
    // A negative pid places the page after the page with that uid, so the
    // site "camino" comes first in the module
    'NEWnoSite' => ['pid' => -1, 'title' => 'My other site', 'is_siteroot' => 1],
    'NEWmySite' => ['pid' => -1, 'title' => 'My site', 'is_siteroot' => 1],
]]);
$notFound = $dataHandler->substNEWwithIDs['NEWnotFound'];
$forbidden = $dataHandler->substNEWwithIDs['NEWforbidden'];
$noSite = $dataHandler->substNEWwithIDs['NEWnoSite'];

// The same languages as in the Editors Tutorial: Spanish, and Arabic,
// which was spoken in Spain for centuries, and which is written from right
// to left
$siteFinder = $container->get(SiteFinder::class);
$site = $siteFinder->getSiteByIdentifier('camino')->getConfiguration();
$site['languages'][] = [
    'title' => 'Español',
    'enabled' => true,
    'languageId' => 1,
    'base' => '/es/',
    'locale' => 'es-ES',
    'hreflang' => 'es-ES',
    'navigationTitle' => 'Español',
    'websiteTitle' => '',
    'flag' => 'es',
    'fallbackType' => 'strict',
    'fallbacks' => '',
];
$site['languages'][] = [
    'title' => 'العربية',
    'enabled' => true,
    'languageId' => 2,
    'base' => '/ar/',
    'locale' => 'ar',
    'hreflang' => 'ar',
    'navigationTitle' => 'العربية',
    'websiteTitle' => '',
    'flag' => 'ma',
    'fallbackType' => 'strict',
    'fallbacks' => '',
];
$site['errorHandling'] = [
    [
        'errorCode' => 404,
        'errorHandler' => 'Page',
        'errorContentSource' => 't3://page?uid=' . $notFound,
    ],
    [
        'errorCode' => 403,
        'errorHandler' => 'Page',
        'errorContentSource' => 't3://page?uid=' . $forbidden,
    ],
];
$siteWriter = $container->get(SiteWriter::class);
$siteWriter->write('camino', $site);

// The page "My other site" loses the site configuration that TYPO3 created
// for it, so the module offers to create one
foreach ($siteFinder->getAllSites(false) as $identifier => $otherSite) {
    if ($otherSite->getRootPageId() === $noSite) {
        $siteWriter->delete($identifier);
    }
}

// Two groups, the second one inherits from the first, two editors, and two
// file mounts of the folder with the images of Camino, one of them
// read-only. Editors see the pages and the images of Camino and work with
// the modules for content and media.
$dataHandler = $process([
    'sys_filemounts' => [
        'NEWcamino' => ['pid' => 0, 'title' => 'Camino', 'identifier' => '1:/camino/'],
        'NEWreadOnly' => [
            'pid' => 0,
            'title' => 'Camino - read only',
            'identifier' => '1:/camino/',
            'read_only' => 1,
        ],
    ],
]);
$caminoMount = $dataHandler->substNEWwithIDs['NEWcamino'];
$readOnlyMount = $dataHandler->substNEWwithIDs['NEWreadOnly'];
$dataHandler = $process([
    'be_groups' => [
        'NEWeditor' => [
            'pid' => 0,
            'title' => 'Editor',
            'description' => 'Editors have access to basic content elements and modules '
                . 'in the backend.',
            'db_mountpoints' => '1',
            'file_mountpoints' => (string)$caminoMount,
            'groupMods' => 'dashboard,web_layout,records,page_preview,media_management,user_setup',
            'tables_select' => 'pages,tt_content,sys_file,sys_file_metadata,sys_file_reference',
            'tables_modify' => 'pages,tt_content,sys_file_metadata,sys_file_reference',
            // Standard page, link, shortcut, folder, and menu separator
            'pagetypes_select' => '1,3,4,254,199',
            // Workspaces is installed, the editors work in the live workspace
            'workspace_perms' => 1,
        ],
        'NEWadvanced' => [
            'pid' => 0,
            'title' => 'Advanced Editor',
            'description' => 'Advanced Editors have access to all content elements and '
                . 'non administrative modules in the backend.',
            'subgroup' => 'NEWeditor',
        ],
    ],
]);
$editor = $dataHandler->substNEWwithIDs['NEWeditor'];
$advanced = $dataHandler->substNEWwithIDs['NEWadvanced'];
$process(['be_users' => [
    'NEWedoe' => [
        'pid' => 0,
        'username' => 'e.doe',
        // With an email address, the module offers to reset the password
        'email' => 'e.doe@example.org',
        'password' => 'Screenshots-2026!',
        'usergroup' => (string)$editor,
        // Mounts the page tree entry points and the file mounts of the
        // groups, and the read-only file mount of its own
        'options' => 3,
        'file_mountpoints' => (string)$readOnlyMount,
        'disable' => 0,
    ],
    'NEWadoe' => [
        'pid' => 0,
        'username' => 'a.doe',
        'email' => 'a.doe@example.org',
        'password' => 'Screenshots-2026!',
        'usergroup' => $editor . ',' . $advanced,
        'options' => 3,
        'disable' => 0,
    ],
]]);

// The pages of Camino belong to the group "Editor", which may show, edit,
// and create them, but not delete them. The group may only show the pages
// of the footer navigation, and may also delete the error pages, which
// everybody may show.
$pages = $container->get(ConnectionPool::class)->getConnectionForTable('pages');
$pages->update(
    'pages',
    ['perms_groupid' => $editor, 'perms_group' => 1 + 2 + 8 + 16],
    ['is_siteroot' => 0],
);
$pages->update(
    'pages',
    ['perms_groupid' => $editor, 'perms_group' => 1 + 2 + 8 + 16],
    ['uid' => 1],
);
$pages->update('pages', ['perms_group' => 1], ['uid' => 2]);
$pages->update('pages', ['perms_group' => 1], ['pid' => 2]);
foreach ([$notFound, $forbidden] as $uid) {
    $pages->update(
        'pages',
        ['perms_group' => 1 + 2 + 4 + 8 + 16, 'perms_everybody' => 1],
        ['uid' => $uid],
    );
}

// Two folders in the folder of Camino, so the folder tree of an editor
// has something to show
foreach (['Downloads', 'Press'] as $folder) {
    GeneralUtility::mkdir_deep(Environment::getPublicPath() . '/fileadmin/camino/' . $folder);
}

// Categories on the root level, one of them below another one, and the
// two of them that the image of the Camino Francés belongs to
$dataHandler = $process(['sys_category' => [
    'NEWregion' => ['pid' => 0, 'title' => 'Region'],
    'NEWfrance' => ['pid' => 0, 'title' => 'France', 'parent' => 'NEWregion'],
    'NEWportugal' => ['pid' => 0, 'title' => 'Portugal', 'parent' => 'NEWregion'],
    'NEWspain' => ['pid' => 0, 'title' => 'Spain', 'parent' => 'NEWregion'],
    'NEWgalicia' => ['pid' => 0, 'title' => 'Galicia', 'parent' => 'NEWspain'],
]]);
$image = $container->get(ResourceFactory::class)
    ->getFileObjectFromCombinedIdentifier('1:/camino/camino-frances.webp');
$process(['sys_file_metadata' => [
    $image->getMetaData()->get()['uid'] => ['categories' => implode(',', [
        $dataHandler->substNEWwithIDs['NEWfrance'],
        $dataHandler->substNEWwithIDs['NEWspain'],
    ])],
]]);
