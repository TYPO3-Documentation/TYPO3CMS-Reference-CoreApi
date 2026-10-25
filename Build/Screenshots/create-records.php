<?php

declare(strict_types=1);

/*
 * Adds the records that the screenshots show to the demo site of the
 * Camino theme, like in the Editors Tutorial: Spanish and Arabic, which is
 * written from right to left, error pages, a second root page with the
 * site configuration that TYPO3 creates for it, a third root page without
 * a site configuration, and the backend users, groups, and file mounts of
 * the chapter on user management.
 *
 * Runs after "typo3 setup" and "typo3 extension:setup".
 */

use TYPO3\CMS\Core\Authentication\CommandLineUserAuthentication;
use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
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

// The error pages below the root page "Camino", and two more root pages,
// for which TYPO3 creates a site configuration
$dataHandler = $process(['pages' => [
    'NEWnotFound' => ['pid' => 1, 'title' => 'Page not found'],
    'NEWforbidden' => ['pid' => 1, 'title' => 'Access denied'],
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
// read-only
$dataHandler = $process([
    'be_groups' => [
        'NEWeditor' => ['pid' => 0, 'title' => 'Editor'],
        'NEWadvanced' => ['pid' => 0, 'title' => 'Advanced Editor', 'subgroup' => 'NEWeditor'],
    ],
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
        'disable' => 0,
    ],
    'NEWadoe' => [
        'pid' => 0,
        'username' => 'a.doe',
        'email' => 'a.doe@example.org',
        'password' => 'Screenshots-2026!',
        'usergroup' => $editor . ',' . $advanced,
        'disable' => 0,
    ],
]]);
