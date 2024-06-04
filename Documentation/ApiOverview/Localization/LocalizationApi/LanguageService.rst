.. include:: /Includes.rst.txt
.. _LanguageService-api:

===============
LanguageService
===============

This class is used to translate strings in plain PHP. For examples
see :ref:`extension-localization-php`. A :php:`LanguageService` **should not**
be created directly, therefore its constructor is internal. Create a
:php:`LanguageService` with the :ref:`LanguageServiceFactory-api`.

In the backend context a :php:`LanguageService` is stored in the global
variable :php:`$GLOBALS['LANG']`.
In the frontend it can be accessed via the contentObject:

..  code-block:: php
    :caption: Classes/Controller/ExampleController.php

    use Psr\Http\Message\ServerRequestInterface;
    use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
    use TYPO3\CMS\Core\Utility\GeneralUtility;

    class ExampleController {
        proteced ServerRequestInterface $request;

        public function processAction(ServerRequestInterface $request): string
            $this->request = $request;

            $content = '';
            ...
            $label = $this->getTranslatedLabel('LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:labels.exampleLabel');
            ...

            return $content;
        }

        protected function getTranslatedLabel(string $key): string
        {
            $language = $this->request->getAttribute('language') ?? $this->request->getAttribute('site')->getDefaultLanguage();
            $languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)
                ->createFromSiteLanguage($language);

            return $languageService->sL($key);
        }


..  include:: _LanguageService.rst.txt
