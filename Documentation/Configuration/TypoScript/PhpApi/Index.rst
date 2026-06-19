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

Backend TypoScript
==================

Anonther means needs to be used than the Frontend method to read the TypoScript of the currently selected page in the backend page module.
The needed TYPO3 internal object of the :php:`Extbase` class :php:`BackendConfigurationManager` can be obtained by means of Dependency Injection. 
Note that it may be required to enrich the request object. TypoScript parsing is time consuming. Consider unsing the
:php:`SiteFinder` instead of this solution.

.. code-block:: php

    use Psr\Http\Message\ServerRequestInterface;
    use TYPO3\CMS\Core\SingletonInterface;
    use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;

    class OrderBackend implements SingletonInterface
    {
        private ContainerInterface $container;
        protected BackendConfigurationManager $concreteConfigurationManager;
    
        public function __construct(
            ContainerInterface $container,
            BackendConfigurationManager $configurationManager
        )
        {
            $this->container = $container;
            $this->concreteConfigurationManager = $configurationManager;
        }

        public function getTypoScript(ServerRequestInterface $request): array
        {
             $setup = $this->concreteConfigurationManager->getTypoScriptSetup($request);
             return $setup;
        }
    }

