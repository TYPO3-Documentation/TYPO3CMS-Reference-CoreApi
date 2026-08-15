.. include:: /Includes.rst.txt
.. index::
   TypoScript; Parsing
   TypoScript; Execution
   TypoScript; Storage
.. _typoscript-syntax-typoscript-parser-api:
.. _typoscript-syntax-parsing-storing-executing-typoscript:
.. _typoscript-syntax-parsing-typoscript:
.. _typoscript-syntax-storing-typoscript:
.. _typoscript-syntax-executing-typoscript:
.. _typoscript-syntax-parser-introduction:
.. _typoscript-syntax-custom-typoscript:

=======
PHP API
=======

With the rewrite of the TypoScript parser in TYPO3 v12, the parsing logic
itself has been entirely marked as internal. Developers typically do not
need to deal with all the nasty details and some parts of the parser are
still subject to change.

Developers who really need to parse own TypoScript snippets, should have
a look at the factory classes located in :file:`EXT:core/Classes/TypoScript/`,
though. They are marked :php:`@internal` as well, but may be opened in the
future. Use them on your own risk at the moment.

TYPO3 already provides frontend TypoScript and TSconfig. Use these APIs for other use cases:


.. index:: TSconfig; PHP
.. _typoscript-access_page_tsconfig:

Page TSconfig
=============

The page TSconfig for a specific page can be retrieved using
:php:`\TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig()`. While
the parser creates a tree of PHP objects internally, this method returns only
the array representation of the parsed TypoScript:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    // use TYPO3\CMS\Backend\Utility\BackendUtility;

    // Get the page TSconfig for the page with uid 42
    $pageTsConfig = BackendUtility::getPagesTSconfig(42);

.. _typoscript-access_frontend_typoscript:

Frontend TypoScript
===================

When calling a TYPO3 frontend page, TypoScript is prepared and parsed by
some :ref:`middlewares <request-handling-middlewares>`. They add the
:ref:`TypoScript request attribute <typo3-request-attribute-frontend-typoscript>`.

Frontend TypoScript plays an important role to create, determine und use the correct page
caches, the details in this area are pretty complex. With the continued refactoring of
the frontend parsing chain, this part will evolve in the future and further API will
evolve allowing extensions to parse TypoScript more easily.

However, extension controllers that need the parsed TypoScript can access the parsed
setup as array:

.. code-block:: php

    $fullTypoScript = $request->getAttribute('frontend.typoscript')->getSetupArray();

Read more about :ref:`Getting the PSR-7 request object <getting-typo3-request-object>`
from different contexts.

.. _typoscript-backend-access_frontend_typoscript:

Backend TypoScript
==================

Another means needs to be used to read the Frontend TypoScript of the currently selected page in the backend page module.
This is needed in a case where some Frontend classes need to be called as well by from the Backend. E.g. a shop administrator
is allowed to resend an order email with a new modified bill after the customer has cancelled one item from his order.
The needed TYPO3 internal object of the :php:`Extbase` class :php:`BackendConfigurationManager` can be obtained by means of Dependency Injection. 
Note that it may be required to enrich the request object. TypoScript parsing is time consuming. Consider using the
`SiteFinder class <https://docs.typo3.org/permalink/t3coreapi:sitehandling-sitefinder-object>`_
instead of this solution. For backend module configuration you should use 
`Backend TypoScript / TSconfig <https://docs.typo3.org/permalink/t3tsref:about-tsconfig>`_ instead of Frontend TypoScript. 

.. code-block:: php
    :caption: EXT:my_extension/Classes/Backend/OrderController.php

    namespace MyDomain\MyExtension\Backend;

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use TYPO3\CMS\Backend\Attribute\AsController;
    use TYPO3\CMS\Core\Database\ConnectionPool;
    use TYPO3\CMS\Core\Http\HtmlResponse;
    use TYPO3\CMS\Core\SingletonInterface;
    use MyDomain\MyExtension\Backend\TypoScriptConfigurationManager;

    #[AsController]
    final readonly class OrderController implements SingletonInterface
    {    
        public function __construct(
            protected ConnectionPool $connectionPool,
            protected TypoScriptConfigurationManager $concreteConfigurationManager
        ) {}

        public function handleRequest(ServerRequestInterface $request): ResponseInterface
        {
            $setup = $this->getTypoScript($request);
            $foo = $setup['my_extension']['bar'] ?? '';
            return new HtmlResponse('<div>Foo Setup: ' . $foo . '</div>');
        }

        public function getTypoScript(ServerRequestInterface $request): array
        {
             $setup = $this->concreteConfigurationManager->getTypoScriptSetup($request);
             return $setup;
        }
    }


This is an example TypoScript Configuration Manager:

.. code-block:: php
    :caption: EXT:my_extension/Classes/Backend/TypoScriptConfigurationManager.php
    namespace MyDomain\MyExtension\Backend;

    use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
    use TYPO3\CMS\Core\Cache\Frontend\PhpFrontend;
    use TYPO3\CMS\Core\Database\ConnectionPool;
    use TYPO3\CMS\Core\Site\Entity\NullSite;
    use TYPO3\CMS\Core\Site\Set\SetRegistry;
    use TYPO3\CMS\Core\Site\SiteFinder;
    use TYPO3\CMS\Core\TypoScript\IncludeTree\SysTemplateRepository;
    use TYPO3\CMS\Core\TypoScript\FrontendTypoScriptFactory;
    use TYPO3\CMS\Core\TypoScript\TypoScriptService;
    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Utility\RootlineUtility;


    final readonly class TypoScriptConfigurationManager
    {
        public function __construct(
            #[Autowire(service: 'cache.typoscript')]
            private PhpFrontend $typoScriptCache,
            #[Autowire(service: 'cache.runtime')]
            private FrontendInterface $runtimeCache,
            private SysTemplateRepository $sysTemplateRepository,
            private SiteFinder $siteFinder,
            private FrontendTypoScriptFactory $frontendTypoScriptFactory,
            private ConnectionPool $connectionPool,
            private SetRegistry $setRegistry,
        ) {}


        /**
        * Returns TypoScript Setup array from current Environment.
        *
        * @return array the raw TypoScript setup
        */
        public function getTypoScriptSetup(ServerRequestInterface $request): array
        {
            $currentPageId = $this->getCurrentPageId($request);

            $cacheIdentifier = 'mydomain-backend-typoscript-pageIda-' . $currentPageId;
            $setupArray = $this->runtimeCache->get($cacheIdentifier);
            if (is_array($setupArray)) {
                return $setupArray;
            }

            $site = $request->getAttribute('site');
            if (($site === null || $site instanceof NullSite) && $currentPageId > 0) {
                try {
                    $site = $this->siteFinder->getSiteByPageId($currentPageId);
                } catch (SiteNotFoundException) {
                    // Keep null / NullSite when no site could be determined for whatever reason.
                }
            }
            if ($site === null) {
                // If still no site object, have NullSite (usually pid 0).
                $site = new NullSite();
            }

            $rootLine = [];
            $sysTemplateRows = [];
            if ($currentPageId > 0) {
                $rootLine = GeneralUtility::makeInstance(RootlineUtility::class, $currentPageId)->get();
                // When the site acts as a TypoScript root, limit sys_template lookup to
                // pages within this site by truncating the rootline at the site root page.
                // This mirrors the frontend behavior and prevents sys_template records from
                // parent sites from leaking into the backend TypoScript evaluation.
                // @see \TYPO3\CMS\Frontend\Page\PageInformationFactory::setSysTemplateRows()
                $rootLineForSysTemplates = $rootLine;
                if ($site instanceof Site && $site->isTypoScriptRoot()) {
                    $rootLineForSysTemplates = [];
                    foreach ($rootLine as $index => $rootlinePage) {
                        $rootLineForSysTemplates[$index] = $rootlinePage;
                        if ((int)($rootlinePage['uid'] ?? 0) === $site->getRootPageId()) {
                            break;
                        }
                    }
                }
                $sysTemplateRows = $this->sysTemplateRepository->getSysTemplateRowsByRootline($rootLineForSysTemplates, $request);
                ksort($rootLine);
            }
            $sets = $site instanceof Site ? $this->setRegistry->getSets(...$site->getSets()) : [];
            if (empty($sysTemplateRows) && $sets === []) {
                // If no page with sys_template rows or site sets could be derived, we
                // "fake" a row to trigger inclusion of 'global' TypoScript only.
                $sysTemplateFakeRow = [
                    'uid' => 0,
                    'pid' => 0,
                    'title' => 'Fake sys_template row to force global TypoScript loading',
                    'root' => 1,
                    'clear' => 3,
                    'include_static_file' => '',
                    'basedOn' => '',
                    'includeStaticAfterBasedOn' => 0,
                    'static_file_mode' => false,
                    'constants' => '',
                    'config' => '',
                    'deleted' => 0,
                    'hidden' => 0,
                    'starttime' => 0,
                    'endtime' => 0,
                    'sorting' => 0,
                ];
                $sysTemplateRows[] = $sysTemplateFakeRow;
            }

            $expressionMatcherVariables = [
                'request' => $request,
                'pageId' => $currentPageId,
                'page' => !empty($rootLine) ? $rootLine[array_key_first($rootLine)] : [],
                'fullRootLine' => $rootLine,
                'site' => $site,
            ];

            $typoScript = $this->frontendTypoScriptFactory->createSettingsAndSetupConditions($site, $sysTemplateRows, $expressionMatcherVariables, $this->typoScriptCache);
            $typoScript = $this->frontendTypoScriptFactory->createSetupConfigOrFullSetup(true, $typoScript, $site, $sysTemplateRows, $expressionMatcherVariables, '0', $this->typoScriptCache, null);
            // Retrieve the TypoScript setup array containing trailing dots
            $setupArray = $typoScript->getSetupArray();
            $this->runtimeCache->set($cacheIdentifier, $setupArray);
            
            // Instantiate the TypoScriptService
            $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);

            // Convert the TypoScript array to a plain nested array (removing trailing dots)
            $plainArray = $typoScriptService->convertTypoScriptArrayToPlainArray($setupArray);

            return $plainArray;
        }

        /**
        * Get page id from the request, accessing POST / GET 'id'
        */
        private function getCurrentPageId(ServerRequestInterface $request): int
        {
            $id = 0;
            $potentialId = $request->getParsedBody()['id'] ?? $request->getQueryParams()['id'] ?? 0;
            if (MathUtility::canBeInterpretedAsInteger($potentialId) && $potentialId > 0) {
                $id = (int)$potentialId;
            }
            return $id;
        }
    }


Here an example for a :php-short:`\TYPO3\CMS\Core\Site\SiteFinder` :

.. code-block:: php
    :caption: EXT:my_extension/Classes/Service/SiteConfigurationService.php

    namespace MyVendor\MyExtension\Service;

    use TYPO3\CMS\Core\Site\SiteFinder;
    use TYPO3\CMS\Core\Site\Entity\Site;
    
    readonly class SiteConfigurationService
    {
        // Inject the SiteFinder via constructor injection
        public function __construct(
            private SiteFinder $siteFinder
        ) {}
    
        public function getMyGeneralWarningText(int $pageId): string
        {
            // Find the site object by traversing the rootline upwards from the given page ID
            $site = $this->siteFinder->getSiteByPageId($pageId);
            
            // Access configuration attributes or custom site settings
            return $site->getAttribute('myGeneralWarningText') ?? 'Warning!';
        }
    }

