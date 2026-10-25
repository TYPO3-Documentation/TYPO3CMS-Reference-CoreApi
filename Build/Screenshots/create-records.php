<?php

declare(strict_types=1);

/*
 * Creates the pages and the site configurations that the screenshots show:
 * the site "main" with three languages and error handling, a second root
 * page with the site configuration that TYPO3 creates for it, and a third
 * root page without a site configuration.
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

// The root page of the site "main", the error pages below it, and two more
// root pages, for which TYPO3 creates a site configuration
$dataHandler = $process(['pages' => [
    1 => ['title' => 'Start page'],
    'NEWnotFound' => ['pid' => 1, 'title' => 'Page not found'],
    'NEWforbidden' => ['pid' => 1, 'title' => 'Access denied'],
    // A negative pid places the page after the page with that uid, so the
    // site "main" comes first in the module
    'NEWnoSite' => ['pid' => -1, 'title' => 'My other site', 'is_siteroot' => 1],
    'NEWmySite' => ['pid' => -1, 'title' => 'My site', 'is_siteroot' => 1],
]]);
$notFound = $dataHandler->substNEWwithIDs['NEWnotFound'];
$forbidden = $dataHandler->substNEWwithIDs['NEWforbidden'];
$noSite = $dataHandler->substNEWwithIDs['NEWnoSite'];

$siteFinder = $container->get(SiteFinder::class);
$site = $siteFinder->getSiteByIdentifier('main')->getConfiguration();
$site['base'] = '/';
$site['dependencies'] = ['typo3/fluid-styled-content'];
$site['languages'][1] = [
    'title' => 'Deutsch',
    'enabled' => true,
    'languageId' => 1,
    'base' => '/de/',
    'locale' => 'de_DE.UTF-8',
    'navigationTitle' => 'Deutsch',
    'flag' => 'de',
];
$site['languages'][2] = [
    'title' => 'Français',
    'enabled' => true,
    'languageId' => 2,
    'base' => '/fr/',
    'locale' => 'fr_FR.UTF-8',
    'navigationTitle' => 'Français',
    'flag' => 'fr',
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
$container->get(SiteWriter::class)->write('main', $site);

// The page "My other site" loses the site configuration that TYPO3 created
// for it, so the module offers to create one
$siteWriter = $container->get(SiteWriter::class);
foreach ($siteFinder->getAllSites(false) as $identifier => $otherSite) {
    if ($otherSite->getRootPageId() === $noSite) {
        $siteWriter->delete($identifier);
    }
}
