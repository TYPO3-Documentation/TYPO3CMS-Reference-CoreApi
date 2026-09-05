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
setup as array (including trailing dots):

.. code-block:: php

    $fullTypoScript = $request->getAttribute('frontend.typoscript')->getSetupArray();

Read more about :ref:`Getting the PSR-7 request object <getting-typo3-request-object>`
from different contexts.

.. _typoscript-backend-access_frontend_typoscript:

Backend TypoScript
==================

Another means needs to be used to read the Frontend TypoScript of the currently selected page in the backend page module.
This is needed in the case some Frontend classes need to be called as well from the Backend. E.g. a shop administrator
is allowed to resend an order email with a new modified bill after the customer has cancelled one item from his order.
The needed TYPO3 internal object of the :php:`Extbase` class :php:`BackendConfigurationManager` can be obtained by means of Dependency Injection. 
Note that it may be required to enrich the request object. TypoScript parsing is time consuming. Consider using the
`SiteFinder class <https://docs.typo3.org/permalink/t3coreapi:sitehandling-sitefinder-object>`_ 
and site configuration attributes instead of this solution. 
For backend module configuration you should use 
`Backend TypoScript / TSconfig <https://docs.typo3.org/permalink/t3tsref:about-tsconfig>`_ instead of Frontend TypoScript. 

.. code-block:: php
    :caption: EXT:my_extension/Classes/Backend/OrderController.php

    namespace MyDomain\MyExtension\Backend;

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use TYPO3\CMS\Backend\Attribute\AsController;
    use TYPO3\CMS\Core\Database\ConnectionPool;
    use TYPO3\CMS\Core\Http\HtmlResponse;
    use MyDomain\MyExtension\Backend\TypoScriptConfigurationManager;

    #[AsController]
    final readonly class OrderController
    {    
        public function __construct(
            private ConnectionPool $connectionPool,
            private TypoScriptConfigurationManager $concreteConfigurationManager
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

<?php

declare(strict_types=1);

namespace MyDomain\MyExtension\Backend;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Site\Entity\NullSite;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\TypoScript\TypoScriptFactory;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

final readonly class TypoScriptConfigurationManager
{
    public function __construct(
        private TypoScriptFactory $typoScriptFactory,
        private TypoScriptService $typoScriptService,
    ) {}

    /**
     * Returns TypoScript Setup array from the current environment.
     *
     * @param ServerRequestInterface $request The current server request
     * @return array The clean, nested TypoScript setup array
     */
    public function getTypoScriptSetup(ServerRequestInterface $request): array
    {
        // 1. Try to get TypoScript from the request attribute (works if rendered via frontend/preview)
        $typoScript = $request->getAttribute('frontend.typoscript');

        if ($typoScript !== null) {
            return $this->typoScriptService->convertTypoScriptArrayToPlainArray($typoScript->getSetupArray());
        }

        // 2. Fallback for the pure Backend context (FormEngine) using the public TypoScriptFactory
        $site = $request->getAttribute('site');
        if ($site === null || $site instanceof NullSite) {
            return [];
        }

        if ($site instanceof Site) {
            // Build the TypoScript registry object based on the current active Site and its Site Sets
            $typoScript = $this->typoScriptFactory->createFromSite($site);
            return $this->typoScriptService->convertTypoScriptArrayToPlainArray($typoScript->getSetupArray());
        }

        return [];
    }
}

Example for :php-short:`\TYPO3\CMS\Core\Site\SiteFinder` :

.. code-block:: php
    :caption: EXT:my_extension/Classes/Service/SiteConfigurationService.php

    namespace MyVendor\MyExtension\Service;

    use Psr\Http\Message\ServerRequestInterface;
    use TYPO3\CMS\Core\Site\SiteFinder;
    use TYPO3\CMS\Core\Site\Entity\Site;
    
    readonly class SiteConfigurationService
    {
        // Inject the SiteFinder via constructor injection
        public function __construct(
            private SiteFinder $siteFinder
        ) {}
    }
    
    public function getMyGeneralWarningText(int $pageId): string
    {
        $warningText = 'Warning!';
        
        try {
            // Find the site object by traversing the rootline upwards from the given page ID
            $site = $this->siteFinder->getSiteByPageId($pageId);
            
            if ($site instanceof Site) {
                // Safely access the attribute and catch potential InvalidArgumentException if the key does not exist
                $warningText = $site->getAttribute('myGeneralWarningText') ?? $warningText;
            }
        } catch (SiteNotFoundException|\InvalidArgumentException) {
            // Fallback to the default warning text if the site is missing or the attribute key is invalid
        }

        return $warningText;
    }

